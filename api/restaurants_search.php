<?php
    require_once("../database/restaurant-class.php");
    $filters = json_decode($_GET["filters"],true);
    $restaurants = Restaurant::searchRestaurants($_GET['search'], $filters,8);
    
    echo json_encode($restaurants);
?>