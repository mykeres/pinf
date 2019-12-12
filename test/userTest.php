<?php 
    include_once __DIR__.'/../model/user.php'; 
    $user = new User();
    $user->setUser('Luis','123456789');
    $userID = $user->getId();
    var_dump($userID);

