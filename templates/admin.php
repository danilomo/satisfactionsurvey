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
<a href="<?= htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>">
    &larr;<?= $_SESSION['lang']['phrases']['backtosurvey']; ?>
</a>
<h1><?= $_SESSION['lang']['phrases']['welcomeadminpage']; ?></h1>
<form name="surveyresult" method="POST" action="?view=1">
    <label>
        <input type="date" name="period[]" value="<?= ($_POST['period'][0] ?? date('Y-m-d')); ?>">
        <span><?= $_SESSION['lang']['phrases']['to']; ?></span>
        <input type="date" name="period[]" value="<?= ($_POST['period'][1] ?? date('Y-m-d')); ?>">
        <input type="submit" name="action" value="<?= $_SESSION['lang']['phrases']['search']; ?>">
    </label>
</form>
<?php
    Classes\Report::show(
            $objSatisfactionSurvey->getSurvey(($_POST['period'] ?? [])), 
            [
                0 => $_SESSION['lang']['options']['disagree'], 
                1 => $_SESSION['lang']['options']['agree'],
                'tabletitle' => $_SESSION['lang']['phrases']['satisfactionsurvey'],
                'Level' => $_SESSION['lang']['phrases']['satisfied'],
                'Created At' => $_SESSION['lang']['phrases']['filledat']
            ]
    );
?>