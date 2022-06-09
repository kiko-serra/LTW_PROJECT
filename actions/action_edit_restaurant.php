<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/connection.php');
  require_once(__DIR__ . '/../database/restaurant-class.php');
  $session = new Session();
  $db = getDatabaseConnection();

 
  print_r($_POST);
  $id_restaurant = intval($_POST['id']);
  if (!$session->isLoggedIn() && Restaurant::RestaurantOwner($db, $id_restaurant)!= $session->getId()) die(header('Location: /'));

  $next = '../pages/edit-restaurant.php?id=' . $id_restaurant;

  if (trim($_POST['name']) === '' || trim($_POST['address']) === '' || 
      trim($_POST['category']) === ''  || trim($_POST['reviewScore']) === '' || 
      trim($_POST['title']) === '' ) 
      {
    $session->addMessage('error', 'Information cannot be empty');
    die(header('Location: ' . $next));
  }

  $name = $_POST['name'];
  $address = $_POST['address'];
  $category = intval($_POST['category']);
  $reviewScore = intval($_POST['reviewScore']);
  $title = $_POST['title'];
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