<?php
include_once 'db.php';
class User extends DataBase{

    private $nombre;
    private $password;

    public function userExists(){

    }

    public function setUser($nombre, $password){
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $query = $this->conectar()->prepare('INSERT INTO `usuario` (`nombre`, `password`) VALUES (?,?)');
        $query->execute([$nombre,  $hash]);
    }

    public function countImages(){

        $query = $this->conectar()->prepare('SELECT COUNT(idimagen) FROM imagen WHERE ');///
        //TODO terminar consultas
    }

    public function getTags(){

    }

    public function getImages(){

    }

    public function getId(){

    }
}