<?php
    include_once 'model/db.php';
    $usuario = $_POST['usuario'];
    $password =  $_POST['password'];
    // TODO hay que pasarlos al controlador
    // $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    // $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING); 

    
    $database = new DataBase();

    $prueba = $database->conectar();
    var_dump($prueba);

    var_dump($_POST);
    var_dump($_GET);
    echo 'ruta->'.$_POST['route'];