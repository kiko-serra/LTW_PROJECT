<?php
    //declare(strict_types = 1);

    session_start();

    $dbh = new PDO('sqlite:uber.db');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
        header('Location: ' . 'login.html');
        try{
            $stmt = $dbh->prepare("INSERT INTO User VALUES (3, 'OLE', 'SILVA', 'EMAIL', 'RUAU RUA', ?, '1234567', ?");
            $stmt->execute(array($username, $password));
            $client = $stmt->fetch();
        }
        catch(PDOException $e){
            echo "its here";
            echo $e->getMessage();
        }
    }


?>