<?php
    declare(strict_types = 1);

    session_start();

    $dbh = new PDO('sqlite:../database/uber.db');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //ive been getting this error
    //Fatal error: Uncaught Error: Call to a member function setAttribute() on null in /Users/FranciscoSerra/Desktop/FEUP/2º Ano/2º Semestre/LTW/ltw-t09-g03/src/action_login.php:7
    //Stack trace: #0 {main} thrown in /Users/FranciscoSerra/Desktop/FEUP/2º Ano/2º Semestre/LTW/ltw-t09-g03/src/action_login.php on line 7

    $username = $_POST['username'];
    $password = $_POST['password'];

    try {

        $stmt = $dbh->prepare('SELECT * FROM User WHERE username = ? and password = ?');
        $stmt->execute(array($username, $password));
        $client = $stmt->fetch();

    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }

    if (!empty($client)) {
        header('Location: ' . 'index.html');
    }
    else {
        
        try{
            $stmt = $dbh->prepare("INSERT INTO User VALUES (3, 'OLE', 'SILVA', 'EMAIL', 'RUAU RUA', ?, '1234567', ?");
            $stmt->execute(array($username, $password));
            $client = $stmt->fetch();
            header('Location: ' . 'login.html');
            echo "cheguei";
        }
        catch(PDOException $e){
            echo "its here";
            echo $e->getMessage();
        }
        
    }


?>