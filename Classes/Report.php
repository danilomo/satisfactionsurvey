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

namespace Classes;

/**
 * Description of Report
 *
 * @author ca
 */
class Report 
{
    public static function parseKeys(array $data): array
    {
        return array_map(function($k){
            if (is_string($k)) {
                return ucwords(str_replace('_', ' ', $k));
            }
        }, array_keys($data[0]));
    }
    
    public static function parseValues(array $data, array $translate): array
    {
        foreach ($data as &$row) {
            foreach ($row as $key => &$column) {
                if (!is_numeric($key)) {
                    if (in_array($key, ['created_at', 'modified_at'])) {
                        $column = date('d/m/Y H:m:s', strtotime($column));
                    } else {
                        $column = ($translate[$column] ?? $column);
                    }
                } else {
                    unset($row[$key]);
                }
            }
        }
        return $data;
    }
    
    public static function head(array $data, array $translate): void
    {
        if (count($data) == 0) {
            throw new \InvalidArgumentException("Array must contain elements to show");
        }
        $dataKeys = self::parseKeys($data);
        $timestamp = time();
        echo "<table name='survey{$timestamp}' id='survey{$timestamp}'>",
             "<caption>" . 
                ($translate['tabletitle'] ?? 
                $_SESSION['lang']['phrases']['survey']) . 
            "</caption>",
             "<thead>";
        foreach ($dataKeys as $key) {
            echo "<th>" . ($translate[$key] ?? $key) . "</th>";
        }
        echo "</thead>";
    }
    
    public static function body(array $data, array $translate): void
    {
        $data = self::parseValues($data, $translate);
        echo "<tbody>";
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $key => $column) {
                echo "<td>$column</td>";
            }
            echo "</tr>";
        }
        echo"</tbody";
    }
    
    public static function foot(array $data): void
    {
        echo "</table>";
    }
    
    public static function show(array $data, array $translate): void
    {
        self::head($data, $translate);
        self::body($data, $translate);
        self::foot($data);
    }
}
