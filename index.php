<?php

require_once(__DIR__ . '/./utils/session.php');
$session = new Session();
require_once("templates/common-tpl.php");
require_once("templates/restaurant-tpl.php");
require_once("templates/get-restaurants.php");
require_once("database/restaurant-class.php");
require_once("templates/menus-tpl.php");
require_once("database/connection-db.php");

$res =  getRestaurants();

drawHeader($session);
drawNav(true);
drawFeaturedFoods();
drawRestaurants($res);
drawFooter();

?>