<?php
class UserTable extends DataBase{
	function getByNombre(string $nombre){
		$mysqli = $this->conn();
		$stmt = $mysqli->prepare("SELECT * FROM usuario WHERE usuario.nombre=? LIMIT 1");
		$stmt->bind_param("s", $nombre);

		$stmt->execute();
		$result = $stmt->get_result();

		$obj = $result->fetch_array();
		if (empty($obj)) {
			return false;
		}

		$user = new User();
		$user->setNombre($obj['nombre']);

		return $user;
	}

	function getTodos(): array{
		$mysqli = $this->conn();
		$stmt = $mysqli->prepare("SELECT * FROM usuario");
		$stmt->execute();
		$result = $stmt->get_result();

		$users = array();
		while ($obj = $result->fetch_array()) {
			$user = new User();
			$user->setNombre($obj['nombre']);

			$users[] = $user;
		}

		return $users;
	}

	function salvar(User $user){
		$mysqli = $this->conn();
		$stmt = $mysqli->prepare("INSERT INTO `usuario` (`nombre`, `password`,`email`) VALUES (?,?,?)");
		$stmt->bind_param("s", $user->getNombre());
		$stmt->bind_param("s", $user->getPassword());
		$stmt->bind_param("s", $user->getEmail());
		$stmt->execute();

		//FIXME: comprobar
	}
}

class User{
	private $nombre;
	private $password;
	private $email;
	public function getNombre(){
		return $this->nombre;
	}
	public function getPassword(){
		return $this->password;
	}
	public function getEmail(){
		return $this->email;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
}

class UserOld extends DataBase{

    private $nombre;
    private $password;
    private $email;

    public function __construct($nombre){
        parent::__construct();
        $this->nombre = $nombre;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function userExists(){
	$mysqli = $this->conn();
	$stmt = $mysqli->prepare("SELECT * FROM usuario WHERE usuario.nombre=? LIMIT 1");
	$stmt->bind_param("s", $this->nombre);

	$stmt->execute();
	$result = $stmt->get_result();

	$obj = $result->fetch_array();
	return $obj;
    }

    public function insertUser(): User{
        $hash = password_hash($this->password, PASSWORD_BCRYPT);
        $query = $this->conectar()->prepare('INSERT INTO `usuario` (`nombre`, `password`,`email`) VALUES (?,?,?)');
        $query->bindParam(1,$this->nombre,PDO::PARAM_STR);
        $query->bindParam(2,$hash,PDO::PARAM_STR);
        $query->bindParam(3,$this->email,PDO::PARAM_STR);

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
    /*$mysqli = $this->conn();
	$stmt = $mysqli->prepare("SELECT usuario.password FROM usuario WHERE usuario.nombre=? LIMIT 1");
	$stmt->bind_param("s", $this->nombre);

	$stmt->execute();
	$result = $stmt->get_result();

	$obj = $result->fetch_array();*/

    
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

    public function getTagsFromImage($image): array{
        $query = $this->conectar()->prepare('SELECT nombre FROM (etiqueta INNER JOIN etiqueta_imagen ON etiqueta.idetiqueta=etiqueta_imagen.idetiqueta) INNER JOIN imagen ON etiqueta_imagen.idimagen=imagen.idimagen WHERE imagen.nombre= :nombre');
        $query->bindParam(':nombre',$image,PDO::PARAM_STR);
        $fetch = $query->fetchAll();
        return $fetch;
    }

    public function getTagsFromClass($tipo): array{
        $query = $this->conectar()->prepare('SELECT nombre FROM etiqueta INNER JOIN usuario ON etiqueta.idusuario=usuario.idusuario WHERE usuario.nombre= :nombre AND etiqueta.tipo= :tipo');
        $query->bindParam(':nombre',$this->nombre,PDO::PARAM_STR);
        $query->bindParam(':tipo',$tipo,PDO::PARAM_STR);
        $fetch = $query->fetchAll();
        return $fetch;
    }

    public function userMatches(string $password): bool{
	$mysqli = $this->conn();
	$stmt = $mysqli->prepare("SELECT usuario.password FROM usuario WHERE usuario.nombre=? LIMIT 1");
	$stmt->bind_param("s", $this->nombre);

	$stmt->execute();
	$result = $stmt->get_result();

	$obj = $result->fetch_array();
	return password_verify($password, $obj['password']);
    }
}
