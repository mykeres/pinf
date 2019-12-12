<?php 
    include_once __DIR__.'/../model/user.php'; 
    $user = new User('Pepe');
    // $user->setUser('123456789');
    $userID = $user->getId();
    var_dump($userID);
    echo '</br>Oscar->'.$user->userExists('Oscar');
    echo '</br>Luis->'.$user->userExists('Luis');
    echo '</br>Jaime->'.$user->userExists('Jaime');

