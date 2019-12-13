<?php
    include_once 'model/db.php';
    include_once 'controller/controllerLogin.php';
    include_once 'model/user_session.php';
    $usuario = $_POST['usuario'];
    $password =  $_POST['password'];
    // TODO hay que pasarlos al controlador
    // $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    // $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING); 
    $myUser= new User($usuario,$password);
    $controller = new controllerLogin();
    $userValid = $controller->validateUser($myUser);
    echo 'userValid';
    var_dump($userValid);
    if (!isset($userValid)){
        header('Location: http://localhost/pinf/index.php');
    }
    $myUsersession = new UserSession();

    $database = new DataBase();

    $prueba = $database->conectar();
    var_dump($prueba);
    var_dump($_POST);
    var_dump($_GET);