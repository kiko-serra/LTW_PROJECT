<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.php');
require_once(__DIR__ . '/../database/restaurant-class.php');
$session = new Session();
$db = getDatabaseConnection();
$_POST = json_decode(file_get_contents('php://input'), true);


$id_restaurant = intval($_POST['id']);
if (!$session->isLoggedIn() && Restaurant::getRestaurantOwner($db, $id_restaurant) != $session->getId()) die(json_encode("no"));

$name = $_POST['name'];
$address = $_POST['address'];
$category = $_POST['categories'];
$reviewScore = intval($_POST['reviewScore']);
$title = $_POST['title'];




$restaurant = Restaurant::getRestaurant($db, $id_restaurant);

if ($restaurant) {
  $restaurant->setName($name);
  $restaurant->setAddress($address);
  $restaurant->setCategories($categories);
  $restaurant->setReviewScore($reviewScore);
  $restaurant->setTitle($title);

  $restaurant->save();
  die(json_encode("Restaurante Saved"));
} else {
  die(json_encode("Error no restaurant"));
}
