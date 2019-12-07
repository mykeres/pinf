<?php
    include_once 'includes/db.php';
    $database = new DataBase();

    $prueba = $database->conectar();
    var_dump($prueba);