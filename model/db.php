<?php
    class DataBase{
        private $host;
        private $database;
        private $user;
        private $password;
        private $charset;

        public function __construct()
        {
            $configConexion = require_once __DIR__.'/../includes/db.inc.php';
            $this->host     = $configConexion['host'];    
            $this->database = $configConexion['database'];
            $this->user     = $configConexion['user'];
            $this->password = $configConexion['password'];
            $this->charset  = $configConexion['charset'];
        }

        public function conectar()
        {
            try {
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