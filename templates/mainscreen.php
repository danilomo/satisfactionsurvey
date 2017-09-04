<!--
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
-->
<h1><?= $_SESSION['lang']['project']['name']; ?></h1>
<form name="survey" method="POST" id="survey">
    <label id='satisfactionlvl1'>
        <input type="checkbox" name="satisfactionlevel" value="1" />
        <?= $_SESSION['lang']['options']['agree']; ?>
    </label>
    <label id='satisfactionlvl0'>
        <input type="checkbox" name="satisfactionlevel" value="0" />
        <?= $_SESSION['lang']['options']['disagree']; ?>
    </label>
</form>