<?php
include_once __DIR__.'/../model/user.php';
class controllerLogin{

    function validateUser(User $usuario): User{
        var_dump($usuario);
        if (isset($_POST['usuario'], $_POST['password']))
        {
            $nombre = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING); 
            if ($usuario->isValid()){
                $usuario->setNombre($nombre);
                $usuario->insertUser($password);
            }
            return $usuario;
       }

    }
}