<?php
include_once __DIR__.'/../model/user.php';
class controllerLogin{

    function validateUser(User $usuario){
        if (isset($_POST['usuario'])&& isset($_POST['password'])){
        $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING); 
        //TODO
    }

    }
}