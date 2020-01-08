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
				$newUser = new User();
				$newUser->setPassword($password);
				$newUser->setEmail($email);
				$newUser->setNombre($nombre);
				$userTable = new UserTable();
				$userTable->insert($newUser);

				// probaturas
				echo "<h1>prueba</h1>";
				$getbyname=$userTable->getByName($nombre);
				print_r($getbyname);
				exit;
			}
			$this->_render('registro');
			// echo 'hola';
			// exit;
		}
		function wall(){
			if (!_app::isLogged()) {
				$this->login();// enviamos al login
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
				$this->output['user'] = $user;
				return $this->_render('welcome');
			}

			if(!empty($_POST)){
				$nombre = $_POST['nombre'];
				$password = $_POST['password'];

				$userTable = new UserTable();
				$currentUser = $userTable->getByName($nombre);
				if (empty($currentUser)) {
					return $this->_render('login.invalid');
				}
				if ($userTable->userMatches($currentUser, $password)){
					setcookie('user',$nombre,time() + 360000,'/');
					return $this->_render('welcome');
				}
				return $this->_render('login.invalid');
			}

			$this->_render('login');
		}

		function formularioImagenes(){
			if (!_app::isLogged()) {
				return $this->render('registro');
			}
			$user = _app::getUser();
			if(!empty($_POST)){
				if (isset($_FILES['files'])) {
        			$errors = [];
			        $path = '../imageUpload/'.$user;
					$extensions = ['jpg', 'jpeg', 'png', 'gif'];
			        $all_files = count($_FILES['files']['tmp_name']);

			        for ($i = 0; $i < $all_files; $i++) {  
						$fileName = $_FILES['files']['name'][$i];
						$fileTmp = $_FILES['files']['tmp_name'][$i];
						$fileType = $_FILES['files']['type'][$i];
						$fileSize = $_FILES['files']['size'][$i];
						$fileExt = strtolower(end(explode('.', $_FILES['files']['name'][$i])));
						$file = $path . $fileName;
						if (!in_array($fileExt, $extensions)) {
							$errors[] =  $fileName . ' ' . $fileType . " No es una imagen.";
						}
						if ($fileSize > (2 * 1024 * 1024)){
							$errors[] =  $fileName . ' ' . $fileType . " Excede el tamaño máximo.";
						}
						if (empty($errors)) {
							move_uploaded_file($fileTmp, $file);
						}
					}
				if ($errors) print_r($errors);
			}


			$this->_render('formImagenes');
		}
	}
}
