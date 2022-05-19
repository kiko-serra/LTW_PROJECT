<?php
    declare(strict_types = 1);


    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/connection.php');
    require_once(__DIR__ . '/../database/user.php');

    $db = getDatabaseConnection();


    $user = User::getUserWithPassword($db, $_POST['username'], $_POST['password']);


    print_r($user);
    echo "hehe";
 
    if($user){
        $session->setId($user->id_user);
        $session->setName($user->username);
        $session->addMessage('success', 'Login successful!');
        $next= '../index.html';
    }
    else{
        $session->addMessage('error', 'Invalid username or password');
        $next = '../pages/login.html';
    }

    header('Location: ' . $next); 

?>