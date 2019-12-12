<?php
include_once 'db.php';
class User extends DataBase{

    private $nombre;

    public function __construct($nombre){
        parent::__construct();
        $this->nombre = $nombre;
    }

    public function userExists($currentUser): bool{
        $query = $this->conectar()->prepare('SELECT EXISTS (SELECT * FROM `usuario` WHERE `nombre` = :nombre LIMIT 1)');
        $query->bindParam(':nombre',$currentUser,PDO::PARAM_STR);
        $query->execute();
        echo "</br>query: ".$currentUser;
        var_dump($query->execute());
        return boolval($query->fetch());
        //MIRAR EN QUE FALLA
    }

    public function setUser($password){
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $query = $this->conectar()->prepare('INSERT INTO `usuario` (`nombre`, `password`) VALUES (?,?)');
        $query->bindParam(1,$this->nombre,PDO::PARAM_STR);
        $query->bindParam(2,$hash,PDO::PARAM_STR);
        $query->execute();
        //$query->execute([$nombre,  $hash]);
    }

    public function deleteUser(){
        $query = $this->conectar()->prepare('DELETE FROM `usuario` WHERE `nombre`= :nombre');
        $query->bindParam(':nombre',$this->nombre,PDO::PARAM_STR);
        $query->execute();
    }
    

    public function countImages(){
        $query = $this->conectar()->prepare('SELECT COUNT(*) FROM `imagen` WHERE `idusuario` = (SELECT `idusuario` FROM `usuario` WHERE `nombre`= :nombre LIMIT 1)');///
        $query->execute(array(':nombre' => 'Oscar'));
    }

    public function getTags(){

        $query = $this->conectar()->prepare('INSERT INTO `usuario` (`nombre`, `password`) VALUES (?,?)');
    }

    public function getImages(){

        $query = $this->conectar()->prepare('INSERT INTO `usuario` (`nombre`, `password`) VALUES (?,?)');
        //TODO terminar consultas
    }

    public function getId(){
        $query = $this->conectar()->prepare('SELECT `idusuario` FROM `usuario` WHERE `nombre`= :nombre LIMIT 1');
        $query->bindParam(':nombre',$this->nombre,PDO::PARAM_STR);
        $fetch = $query->fetchAll();
        return $fetch;
    }
}