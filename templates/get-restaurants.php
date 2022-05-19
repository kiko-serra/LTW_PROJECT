<?php

require_once("database/connection-db.php");
require_once("database/restaurant-class.php");

$dbo= getDatabaseConnection();
$res = array();

try {

    $stmt = $dbo->prepare('SELECT * FROM Restaurant');
    $stmt->execute();
    $restaurants = $stmt->fetchAll();
    foreach ($restaurants as $restaurant) {
        $temp = new Restaurant($restaurant);
        $res[] = $temp;
    }


    
} catch (PDOException $e) {
    echo $e->getMessage();
}

$_SESSION['res'] = json_encode($res, true);

?>