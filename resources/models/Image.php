<?php

	class ImageTable extends DataBase{
		function insert(Image $image){
			$mysqli = $this->conn();
			$stmt = $mysqli->prepare("INSERT INTO `imagen` (`fecha`, `localizacion`,`nombre`, `camara`, `idusuario`) VALUES (?,?,?,?)");
			$stmt->bind_param("sssss", $image->getDate(),
				$image->getLocation(), $image->getName(),
				$image->getCamera(), $image->getIdUser());
			$stmt->execute();
		}
		
		function getImagesFromUser(User $user, array $params= null):array{
			if ($params['count'] === null){
				$params['count'] = 0;
			}
			if ($params['page'] === null){
				$params['page'] = 0;
			}
			$first = ($params['page'] * $params['count']);
			$count = $params['count'];
			$mysqli = $this->conn();
        	$stmt = $mysqli->prepare('SELECT nombre FROM imagen INNER JOIN usuario ON imagen.idusuario=usuario.idusuario WHERE usuario.nombre=? LIMIT ? OFFSET ?');
        	$stmt->bindParam("sii",$user->getNombre(), $first, $count);
        	$fetch = $query->fetchAll();
        	return $fetch;///mirar 
		}
		function countImages(User $user): int{
		    $mysqli = $this->conn();
	        $stmt = $mysqli->prepare('SELECT COUNT(*) FROM `imagen` WHERE `idusuario` = (SELECT `idusuario` FROM `usuario` WHERE `nombre`=? LIMIT 1)');///
	        $stmt->bindParam("s",$user->getNombre());
	        $stmt->execute();
	        return $query->rowCount();//mirar
    	}

	}

	class Image{

		private $idImagen;
		private $nombre;
		private $camara;
		private $fecha;
		private $localizacion;
		private $idUsuario;

		function __construct(){

		}
		public function getIdImagen()
		{
		    return $this->idImagen;
		}

		public function setIdImagen($idImagen)
		{
		    $this->idImagen = $idImagen;
		    return $this;
		}

	
		public function getNombre()
		{
		    return $this->nombre;
		}

		
		public function setNombre($nombre)
		{
		    $this->nombre = $nombre;
		    return $this;
		}

	
		public function getCamara()
		{
		    return $this->camara;
		}

	
		public function setCamara($camara)
		{
		    $this->camara = $camara;
		    return $this;
		}

	
		public function getFecha()
		{
		    return $this->fecha;
		}

	
		public function setFecha($fecha)
		{
		    $this->fecha = $fecha;
		    return $this;
		}

		public function getLocalizacion()
		{
		    return $this->localizacion;
		}

		public function setLocalizacion($localizacion)
		{
		    $this->localizacion = $localizacion;
		    return $this;
		}


		public function getIdUsuario()
		{
		    return $this->idUsuario;
		}

		public function setIdUsuario($idUsuario)
		{
		    $this->idUsuario = $idUsuario;
		    return $this;
		}	

		function extractMetadata(){

		}

		function upToServer(): bool {
			$path_upload = '/imagenes/'.$this->getIdUsuario();//mirar
			
		}



	
    
}