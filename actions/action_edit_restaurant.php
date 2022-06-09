<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/connection.php');
  require_once(__DIR__ . '/../database/restaurant-class.php');
  $session = new Session();
  $db = getDatabaseConnection();
  $id_restaurant = intval($_GET['id']);
  if (!$session->isLoggedIn() && Restaurant::RestaurantOwner($db, $id_restaurant)!= $session->getId()) die(header('Location: /'));

  $next = '../pages/edit-restaurant.php?id=' . $id_restaurant;

  if (trim($_GET['name']) === '' || trim($_GET['address']) === '' || 
      trim($_GET['category']) === ''  || trim($_GET['reviewScore']) === '' || 
      trim($_GET['title']) === '' ) 
      {
    $session->addMessage('error', 'Information cannot be empty');
    die(header('Location: ' . $next));
  }

  $name = $_GET['name'];
  $address = $_GET['address'];
  $category = intval($_GET['category']);
  $reviewScore = intval($_GET['reviewScore']);
  $title = $_GET['title'];
  $restaurant = Restaurant::getRestaurant($db, $id_restaurant);

  if ($restaurant) {
    $restaurant->setName($name);
    $restaurant->setAddress($address);
    $restaurant->setCategory($category);
    $restaurant->setReviewScore($reviewScore);
    $restaurant->setTitle($title);
    
    $restaurant->save();
    $session->addMessage('success', 'Changed  Successefully!');
      
  }
  else {
    $session->addMessage('error', 'Restaurant not found');
  }

  header('Location: ' . $next);

?>  