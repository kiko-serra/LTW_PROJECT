<?php
    declare(strict_types = 1);


    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/connection.php');
    require_once(__DIR__ . '/../database/user.php');

    $db = getDatabaseConnection();

    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = User::getUserWithPassword($db, $username, $password);

    if($user){
        $session->setId($user->id_user);
        $session->setName($user->username);
        $session->addMessage('success', 'Login successful!');
    }
    else{
        $session->addMessage('error', 'Invalid username or password');
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);

?>