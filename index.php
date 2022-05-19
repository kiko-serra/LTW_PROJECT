<?php

require_once("templates/common-tpl.php");
require_once("templates/restaurant-tpl.php");
require_once("database/restuarant-class.php");
require_once("templates/menus-tpl.php");
require_once("database/connection-db.php");
session_start();

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

    drawHeader();
    drawNav(true);
    drawFeaturedFoods();
    drawRestaurants($res);
    drawFooter();
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>