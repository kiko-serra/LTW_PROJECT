<?php
    declare(strict_types = 1);

    session_start();

    $db = new PDO('sqlite:../database/uber.db');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $username = $_POST['username'];
    $password = $_POST['password'];
    $next = 'index.html';

    try {

        $stmt = $db->prepare('SELECT * FROM User WHERE username = ? and password = ?');
        $stmt->execute(array($username, $password));
        $client = $stmt->fetch();

    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
    if (!empty($client)) {
        $next='index.html';
    }
    else {
        
        try{

            $stmt = $db->prepare("INSERT INTO User VALUES (345 ,'o', 'VA', 'EL', 'U RUA', ?, '164', ?)");

            $stmt->execute(array($username, $password));


            $next='login.html';
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
        
    }
    header('Location: ' . $next);

?>