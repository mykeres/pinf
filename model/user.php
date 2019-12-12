<?php
include_once 'db.php';
class User extends DataBase{

    private $nombre;
    private $password;

    public function __construct(){
        parent::__construct();
        
    }

    public function userExists($currentUser){

    }

    public function setUser($nombre, $password){
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $query = $this->conectar()->prepare('INSERT INTO `usuario` (`nombre`, `password`) VALUES (?,?)');
        $query->bindParam(1,$nombre,PDO::PARAM_STR);
        $query->bindParam(2,$hash,PDO::PARAM_STR);
        $query->execute();
        //$query->execute([$nombre,  $hash]);
    }

    public function countImages(){
        $query = $this->conectar()->prepare('SELECT COUNT(*) FROM imagen WHERE idusuario = (SELECT idusuario from usuario WHERE nombre= :nombre LIMIT 1)');///
        $query->execute(array(':nombre' => 'Oscar'));
    }

    public function getTags(){

    }

    public function getImages(){

        //TODO terminar consultas
    }

    public function getId(){
        $query = $this->conectar()->prepare('SELECT idusuario FROM usuario WHERE nombre= :nombre LIMIT 1');
        $query->execute(array(':nombre' => 'Oscar'));
        $fetch = $query->fetchAll();
        return $fetch;
    }
}