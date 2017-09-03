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
class SatisfactionSurvey {
    private $satisfactionLevel;
    
    public function __construct(string $lang = 'us')
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (count($_POST) > 0) {
            $this->setSatisfactionLevel(
                filter_input(INPUT_POST, 'satisfactionlevel', FILTER_VALIDATE_INT)
            );
            $this->save();
        }
        $_SESSION['lang'] = $this->getLang($lang);
    }
    
    public function save(): bool
    {
        return true;
    }
    
    public function setSatisfactionLevel(int $satisfactionLevel)
    {
        $this->satisfactionLevel = $satisfactionLevel;
    }
    
    public function getSatisfactionLevel(): int
    {
        return $this->satisfactionLevel;
    }
    
    private function getLang(string $langType = 'us'): array
    {
        return parse_ini_file("lang/$langType.ini", true);
    }
    
    public function renderView() 
    {
        include_once('templates/mainscreen.php');
    }
    
}
