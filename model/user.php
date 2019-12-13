<?php
include_once 'db.php';
class User extends DataBase{

    private $nombre;
    private $password;

    public function __construct($nombre, $password){
        parent::__construct();
        $this->nombre = $nombre;
        $this->password = $password;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function userExists($currentUser): bool{
        $query = $this->conectar()->prepare('SELECT * FROM `usuario` WHERE `nombre` = :nombre LIMIT 1');
        $query->bindParam(':nombre',$currentUser,PDO::PARAM_STR);
        $query->execute();
        $exist = $query->rowCount();
        // echo "</br>query: ".$currentUser;
        // echo "</br>".boolval($exist);
        return boolval($exist);
    }

    public function insertUser(): User{
        $hash = password_hash($this->password, PASSWORD_BCRYPT);
        $query = $this->conectar()->prepare('INSERT INTO `usuario` (`nombre`, `password`) VALUES (?,?)');
        $query->bindParam(1,$this->nombre,PDO::PARAM_STR);
        $query->bindParam(2,$hash,PDO::PARAM_STR);
        $query->execute();
        return $this;
        //$query->execute([$nombre,  $hash]);
    }

    public function deleteUser(){
        $query = $this->conectar()->prepare('DELETE FROM `usuario` WHERE `nombre`= :nombre');
        $query->bindParam(':nombre',$this->nombre,PDO::PARAM_STR);
        $query->execute();
    }
    
    public function isValid(): bool{
        if (!($this->userExists($this->getNombre()))){
            return false;
        }

        return true;
    }

    public function countImages(): int{
        $query = $this->conectar()->prepare('SELECT COUNT(*) FROM `imagen` WHERE `idusuario` = (SELECT `idusuario` FROM `usuario` WHERE `nombre`= :nombre LIMIT 1)');///
        $query->execute(array(':nombre' => $this->nombre));
        return $query->rowCount();
    }

    public function getTags(): array{
        $query = $this->conectar()->prepare('SELECT nombre FROM etiqueta INNER JOIN usuario ON etiqueta.idusuario=usuario.idusuario WHERE usuario.nombre= :nombre');
        $query->bindParam(':nombre',$this->nombre,PDO::PARAM_STR);
        $fetch = $query->fetchAll();
        return $fetch;
    }

    public function getImages(): array{
        $query = $this->conectar()->prepare('SELECT nombre FROM imagen INNER JOIN usuario ON imagen.idusuario=usuario.idusuario WHERE usuario.nombre= :nombre');
        $query->bindParam(':nombre',$this->nombre,PDO::PARAM_STR);
        $fetch = $query->fetchAll();
        return $fetch;
        
    }

    public function getId(){
        $query = $this->conectar()->prepare('SELECT `idusuario` FROM `usuario` WHERE `nombre`= :nombre LIMIT 1');
        $query->bindParam(':nombre',$this->nombre,PDO::PARAM_STR);
        $fetch = $query->fetchAll();
        return $fetch;
    }
}