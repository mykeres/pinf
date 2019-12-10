<?php
    include_once 'model/db.php';
    $database = new DataBase();

    $prueba = $database->conectar();
    var_dump($prueba);