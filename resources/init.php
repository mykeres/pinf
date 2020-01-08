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
                        if(!empty(self::$user)){
                                return true;
                        }
			if (empty($_COOKIE['user'])){
                                return false;
                        }
                        $userTable = new userTable();
                        $user = $userTable->getByName($_COOKIE['user']);
                        if(empty($user)){
                                return false;
                        }
                        self::$user = $user; //cacheamos 
                        return true;
		}
	}
