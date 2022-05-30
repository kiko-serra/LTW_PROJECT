<?php

    require_once("../templates/restaurant-tpl.php");

    drawRestaurant(json_decode($_GET["restaurant"]));
?>