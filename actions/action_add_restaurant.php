<?php
  declare(strict_types = 1);


  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.php');
  require_once(__DIR__ . '/../database/restaurant-class.php');
  
  $db = getDatabaseConnection();

  $name = $_POST['name'];
  $address = $_POST['address'];
  $category = $_POST['category'];
  $reviewScore = $_POST['reviewScore'];
  $title = $_POST['title']; 

  // Don't allow certain characters
  if ( !preg_match ("/^[a-zA-Z0-9]+$/", $name)) {
    $session->addMessage('error', 'Name for Restaurant can only contain letters and numbers!');
    $next = '../pages/add-restaurant.php';
    die(header('Location: ' . $next));
  }
    $restaurant = Restaurant::insertRestaurant($db, $session->getId(), $name, $title, $category, $reviewScore, $address);
    $session->addMessage('success', 'Restaurant added!');
    $next= '../pages/restaurant-page.php?id=' . $restaurant->id . '&name=' . $restaurant->name;
    header('Location: ' . $next);

?>
