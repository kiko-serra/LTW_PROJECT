<?php
    declare(strict_types = 1);


    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/connection.php');
    require_once(__DIR__ . '/../database/user.php');

    $db = getDatabaseConnection();

    $username= $_POST['username'];
    $password = $_POST['password'];

    if(!preg_match('/^[a-zA-Z0-9]{3,20}$/', $username)) {
        $session->addMessage('error', 'Username must be between 3 and 20 characters long and cannot be empty');
        die(header('Location: /'));
    }
    if(!preg_match('/^[a-zA-Z0-9!\?]{3,20}$/', $password)) {
        $session->addMessage('error', 'Password must be between 3 and 20 characters long and contain only letters and numbers and !? and cannot be empty');
        die(header('Location: /'));
    }

    $options = ['cost' => 12];
    $user = User::getUserWithPassword($db, $username, $password);


    if($user){
        $session->setId($user->id_user);
        $session->setName($user->username);
        $session->addMessage('success', 'Login successful!');
        $next= '../index.php';
    }
    else{
        $session->addMessage('error', 'Invalid username or password');
        $next = '../pages/login.php';
    }

    header('Location: ' . $next); 

?>