<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php spl_autoload_register(function ($class_name) {
    include_once 'class/' . $class_name . '.php';
}); 
$objSatisfactionSurvey = new SatisfactionSurvey('us');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $_SESSION['lang']['project']['name']; ?></title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <?php $objSatisfactionSurvey->renderView(); ?>
    </body>
</html>
<script src="js/script.js"></script>
