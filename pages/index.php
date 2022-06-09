<?php

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();
require_once(__DIR__ ."/../templates/common-tpl.php");
require_once(__DIR__ ."/../templates/restaurant-tpl.php");
require_once(__DIR__ ."/../database/restaurant-class.php");
require_once(__DIR__ ."/../templates/menus-tpl.php");
require_once(__DIR__ ."/../database/connection.php");
require_once(__DIR__ ."/../templates/popup.php");
$res =  getRestaurants();
$cats = getFeaturedFoods();

drawHeader($session);
drawNav($session->isLoggedIn());
drawFeaturedFoods($cats);
drawRestaurants($res);
drawFooter($session);

?>