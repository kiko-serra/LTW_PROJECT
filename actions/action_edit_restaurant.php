<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/connection.php');
  require_once(__DIR__ . '/../database/restaurant-class.php');
  $session = new Session();
  $db = getDatabaseConnection();


  $id_restaurant = intval($_POST['id']);
  if (!$session->isLoggedIn() && Restaurant::RestaurantOwner($db, $id_restaurant)!= $session->getId()) die(header('Location: /'));

  $next = '../pages/edit-restaurant.php?id=' . urlencode($id_restaurant);

  $name = $_POST['name'];
  $address = $_POST['address'];
  $category = intval($_POST['category']);
  $reviewScore = intval($_POST['reviewScore']);
  $title = $_POST['title'];

  if(!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $name)) {
    $session->addMessage('error', 'Restaurant Name must be between 3 and 20 characters long and cannot be empty');
    die(header('Location: ' . $next));
  }
  if(!preg_match('/^[a-zA-Z0-9]+$/', $address)) {
    $session->addMessage('error', 'Address must contain only letters and numbers and cannot be empty');
    die(header('Location: ' . $next));
  }
  if(!preg_match('/^[a-zA-Z]+$/', $title)) {
    $session->addMessage('error', 'Title must contain only letters');
    die(header('Location: ' . $next));
  }

  
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