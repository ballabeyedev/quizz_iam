<?php
    $servername = "mysql-balla.alwaysdata.net";
    $username = "balla_db_iam";
    $password = "1234567890BALLA";
    $dbname = "balla_db_iam";    
    try {
        $connect = new PDO('mysql:host='.$servername.';dbname='.$dbname, $username, $password,
            array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
            )
        );
    } catch (PDOException $e) {
        die("Une erreur est survenue lors de la connexion à la Base de données 1 !");
    } 
?>
