<?php
require_once('../templates/common-tpl.php');
require_once('../utils/session.php');
require_once('../templates/menus-tpl.php');
require_once(__DIR__ . '/../database/restaurant-class.php');
$session= new Session();

$db = getDatabaseConnection();
$id_restaurant = intval($_GET['id']);
$menu_type = intval($_GET["type"]);
$ownership = $session->isLoggedIn() && Restaurant::getRestaurantOwner($db, $id_restaurant) == $session->getId();

if (!$session->isLoggedIn()) {
  $session->addMessage('error', 'You must be logged in to view this page');
  die(header('Location: /'));
}

    if(!$ownership) {
        $session->addMessage('error', 'You are not the owner of this restaurant');
        die(header('Location: /'));
        }

drawAddMenu($id_restaurant,$menu_type);
drawFooter($session);

?>
