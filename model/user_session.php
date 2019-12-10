<?php
    class UserSession{
        public function __contruct(){
            session_start();
        }
        public function getCurrentUser(){
            return $_SESSION['user'];
        }
        public function setCurrentUser($user){
            $_SESSION['user'] = $user;
        }
        public function close(){
            session_unset();
            session_destroy();
        }
    }