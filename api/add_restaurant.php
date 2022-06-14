<?php

declare(strict_types=1);

$params = ["name","address","category","reviewScore","title","p_id"];
$_POST = json_decode(file_get_contents('php://input'), true);

foreach ($params  as $p) {
  if (!isset($_POST[$p]))
    die(json_encode("Missing Parameters cao " . $p ));
}


require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.php');
require_once(__DIR__ . '/../database/restaurant-class.php');
try{
$db = getDatabaseConnection();

$name = $_POST['name'];
$address = $_POST['address'];
$id_category = intval($_POST['category']);
$reviewScore = $_POST['reviewScore'];
$title = $_POST['title'];
$p_id = intval($_POST['p_id']);

// Don't allow certain characters
if (!preg_match("/^[a-zA-Z0-9]+$/", $name)) {
  die(json_encode(array("name" => 'Name for Restaurant can only contain letters and numbers!')));
}
$restaurant = Restaurant::insertRestaurant($db, $session->getId(), $name, $title, $id_category, $reviewScore, $address,$p_id);
/* Discover How to do this in js
 $session->addMessage('success', 'Restaurant added!');
$next = '../pages/restaurant-page.php?id=' . $restaurant->id . '&name=' . $restaurant->name;
header('Location: ' . $next);
*/
$next = '../pages/restaurant-page.php?id=' . $restaurant->id . '&name=' . $restaurant->name;
die(json_encode(array("restaurant" =>$next)));
}catch(Exception $e){
  die(json_encode("Error while accessing db"));
}
?>