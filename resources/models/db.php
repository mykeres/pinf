<?php
    class DataBase{
        private $host;
        private $database;
        private $user;
        private $pass;
        private $charset;

	private static $conn = null;

        public function __construct()
        {
            $configConexion = require_once $_SERVER['DOCUMENT_ROOT'].'/resources/db.inc.php';
            $this->host     = $configConexion['host'];    
            $this->database = $configConexion['database'];
            $this->user     = $configConexion['user'];
            $this->pass     = $configConexion['password'];
            $this->charset  = $configConexion['charset'];
        }

	function conn(){
		if (!empty($this->conn)) {
			return $this->conn;
		}

		try {
			$this->conn = new mysqli($this->host, $this->user, $this->pass, "pinf");
		} catch (Error $e) {
			die('Error' . $e->getMessage());
			echo 'error en linea' . $e->getLine();
		}
		return $this->conn;
	}

        public function conectar()
        {
            try {
                echo '<br/>host:'.$this->host;
                echo '<br/>user:'.$this->user;
                echo '<br/>password:'.$this->password;
                $conexion = new PDO("mysql:host=$this->host; dbname=$this->database", $this->user, $this->password);
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            } catch (Error $e) {
                die('Error' . $e->getMessage());
                echo 'error en linea' . $e->getLine();
            }

            return $conexion;
        }
        // TODO asociar la conexión a atributos de la clase, separar atributos a un fichero de configuración
        // HECHO__
        
    }
