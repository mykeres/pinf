<?php
    class DataBase{
        private $host;
        private $database;
        private $user;
        private $password;
        private $charset;

        public function __construct()
        {
            $this->host = 'localhost';    
            $this->database = 'pinf';
            $this->user = 'admin';
            $this->password = 'password';
            $this->charset = 'UTF-8';
        }

        public static function conectar()
        {
            try {
                $conexion = new PDO("mysql:host=localhost; dbname=pinf", 'admin','password');    
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            } catch (Error $e) {
                die('Error' . $e->getMessage());
                echo 'error en linea' . $e->getLine();
            }

            return $conexion;
        }
        // TODO asociar la conexion a atributos de la clase, separar atributos a un fichero de configuración
    }