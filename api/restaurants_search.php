<?php
    require_once("../database/restaurant-class.php");
    $artists = Restaurant::searchRestaurants($_GET['search'], 8);
    echo json_encode($artists);
?>