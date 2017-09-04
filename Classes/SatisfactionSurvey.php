<?php

/*
 * Copyright (C) 2017 ca
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Description of SatisfactionSurvey
 *
 * @author ca
 */
namespace Classes;

use Classes\Postgres\Connection as Connection;

class SatisfactionSurvey {
    private $satisfactionLevel;
    private $pdo;
    private $viewLevel;
    
    public function __construct(string $lang = 'us')
    {
        //Connects to Database
        $this->pdo = Connection::get()->connect();
        $this->viewLevel = $_GET['view'] ?? 0;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_POST['satisfactionlevel'])) {
            $this->setSatisfactionLevel(
                filter_input(INPUT_POST, 'satisfactionlevel', FILTER_VALIDATE_INT)
            );
            if ($this->save()) {
                $this->viewLevel = 999;
            }
        }
        $_SESSION['lang'] = $this->getLang($lang);
    }
    
    public function getSurvey(array $period): array
    {
        $period = array_map(function($key, $value){
            $value .= ($key == 0) ? ' 00:00:00' : ' 23:59:59';
            return date('Y-m-d H:i:s', strtotime($value));
        }, array_keys($period), $period);
        try {
            $where = '';
            if (count($period) > 0) {
                $where = " WHERE created_at
                           BETWEEN SYMMETRIC '{$period[0]}' AND '{$period[1]}' ";
            }
            $query = $this->pdo->query(
                "SELECT level, created_at
                 FROM survey
                 $where
                 ORDER BY created_at DESC "
            );
                 
            return $query->fetchAll(\PDO::FETCH_NAMED);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function save(): bool
    {
        return $this->pdo->exec(
            "INSERT INTO survey(level) VALUES ({$this->getSatisfactionLevel()})"
        );
    }
    
    public function setSatisfactionLevel(int $satisfactionLevel)
    {
        $this->satisfactionLevel = $satisfactionLevel;
    }
    
    public function getSatisfactionLevel(): int
    {
        return $this->satisfactionLevel;
    }
    /**
     * View Level
     * 0 -> Initial page
     * 1 -> Admin page
     * 999 -> Thank you page
     * @return int
     */
    public function getViewLevel(): int
    {
        return $this->viewLevel;
    }
    
    private function getLang(string $langType = 'us'): array
    {
        return parse_ini_file("lang/$langType.ini", true);
    }
    
    public function renderView(): void 
    {
        $objSatisfactionSurvey = $this;
        switch ($this->getViewLevel()) {
            case 1:
                include_once('templates/admin.php');
                break;
            case 999:
                include_once('templates/finalscreen.php');
                break;
            default:
                include_once('templates/mainscreen.php');
                break;
        }
    }
    
}
