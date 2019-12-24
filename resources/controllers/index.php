<?php
	class _controller_index extends _controller{
		function main(...$params){
			$this->_render('main');
		}
		function registro(){
			if(!empty($_POST)){
				print_r($_POST);
				$nombre = $_POST['nombre'];
				$password = $_POST['password'];
				$email = $_POST['email'];
				$newUser = new UserOld($nombre);
				$newUser->setPassword($password);
				$newUser->setEmail($email);
				$newUser->insertUser();
				exit;
			}
			$this->_render('registro');
			// echo 'hola';
			// exit;
		}
		function wall(){
			if (!_app::isLogged()) {
				// Enviamos al login
				exit;
			}





			session_start();
			if(!$_SESSION['user']){
				exit;
			}
			if(!empty($_FILES['imagen'])){
				$tipo=$_FILES["imagen"]["type"];
				if($tipo=="image/jpeg"){
					$exif = exif_read_data($_FILES['imagen']['tmp_name']);
					print_r($exif);
				}
				exit;
			}
			$this->_render('wall');
		}
		function login(){
			if (_app::isLogged()) {
				$user = _app::getUser();
$this->output['text'] = 'Buenos días';
$this->output['text2'] = [
	'pos1'=>'valor'
];

$this->output['debo_pintar_mensaje'] = false;

$GLOBALS['lalala'] = 'asd';

				$this->output['user'] = $user;
				return $this->_render('welcome');
			}

			if(!session_id()){
				session_start();
			}
			if(!empty($_POST)){
				$nombre = $_POST['nombre'];
				$password = $_POST['password'];
				$currentUser = new UserOld($nombre);
				if ($currentUser->userMatches($password)){
					setcookie('user',$nombre,time() + 360000,'/');
					return $this->_render('welcome');
				}
			}

			$this->_render('login');
		}

		

	}
