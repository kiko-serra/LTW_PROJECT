<?php
    require_once("../database/restaurant-class.php");
    $restaurants = Restaurant::searchRestaurants($_GET['search'], 8);
    echo json_encode($restaurants);
?>