<?php
	class TagTable extends DataBase{
		function insert(Tag $tag){
			$mysqli = $this->conn();
			$stmt = $mysqli->prepare("INSERT INTO `etiqueta` (`nombre`, `tipo`) VALUES (?,?)");
			$stmt->bind_param("ss", $tag->getNombre(), $tag->getTipo());
			$stmt->execute();
		}

		public function getTagsFromClass($tipo): array{
			$mysqli = $this->conn();
		    $stmt = $mysqli->prepare('SELECT nombre FROM etiqueta INNER JOIN usuario ON etiqueta.idusuario=usuario.idusuario WHERE usuario.nombre= :nombre AND etiqueta.tipo=?');
		    $stmt->bindParam("s",$tipo);
		    $stmt->execute();
		    //TODO
		}
		public function getTagsFromImage($image): array{
			$mysqli = $this->conn();
		    $stmt = $mysqli->prepare('SELECT nombre FROM (etiqueta INNER JOIN etiqueta_imagen ON etiqueta.idetiqueta=etiqueta_imagen.idetiqueta) INNER JOIN imagen ON etiqueta_imagen.idimagen=imagen.idimagen WHERE imagen.nombre= ?');
		    $stmt->bindParam("s",$image);
			$stmt->execute();
		    return $fetch;
		}
		public function getTagsFromUser(User $user): array{
		    $mysqli = $this->conn();
		    $stmt = $mysqli->prepare('SELECT etiqueta.nombre FROM etiqueta INNER JOIN usuario ON etiqueta.idusuario=usuario.idusuario WHERE usuario.nombre=?');
		    $stmt->bindParam("s",$user->getNombre());
		    $stmt->execute();
		    $result = $stmt->get_result();
		    $obj = $result->fetch_array();
		    return $obj['etiqueta.nombre'];
		}

		function __assign($array): Tag{
		    $tag = new Tag();
		    $tag->setName($array['nombre']);
		    $tag->setPassword($array['tipo']);
		    return $tag;
		}


	}

	class Tag{

		private $nombre;
		private $tipo;

		public function getNombre(){
			return $this->nombre;
		}
		public function setNombre($nombre){
			$this->nombre = $nombre;
		}
		public function getTipo(){
			return $this->tipo;
		}
		public function setTipo($tipo){
			$this->tipo = $tipo;
		}

	}