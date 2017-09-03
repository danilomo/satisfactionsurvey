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
 * Class created to handle the DB abstraction
 *
 * @author ca
 */

namespace Classes\Postgres;

class Connection 
{

    /**
     * Connection
     * @var type 
     */
    private static $conn;

    /**
     * Connect to the database and return an instance of \PDO object
     * @return \PDO
     * @throws \Exception
     */
    public function connect() 
    {
        try {
            // read parameters in the ini configuration file
            $params = parse_ini_file('config/database.ini');
            if ($params === false) {
                throw new \Exception("Error reading database configuration file");
            }
            // connect to the postgresql database
            $conStr = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s", $params['host'], $params['port'], $params['database'], $params['user'], $params['password']);

            $pdo = new \PDO($conStr);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * return an instance of the Connection object
     * @return type
     */
    public static function get() 
    {
        if (null === static::$conn) {
            static::$conn = new static();
        }

        return static::$conn;
    }

}
