<?php
	spl_autoload_register(function ($name) {
		switch ($name) {
			case 'User':
			case 'UserTable':
			case 'UserOld':                          	include('models/User.php');break;
			case 'DataBase':                          	include('models/db.php');break;
		}
	});


	class _app{
		private static $user = null;
		public static function getUser(){
			return self::$user;
		}
		public static function isLogged(): bool{
			if (empty($_COOKIE['user'])) {return false;}
			$ouser = new UserOld($_COOKIE['user']);
			$obj = $ouser->userExists();
			if (!empty($obj)) {
				self::$user = $obj;
			}
			return !empty($obj);
		}
	}
