<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/connection.php');
  require_once(__DIR__ . '/../database/user.php');
  require_once(__DIR__ . '/../templates/common-tpl.php');
  require_once(__DIR__ . '/../database/restaurant-class.php');
  require_once(__DIR__ . '/../templates/restaurant-tpl.php');
  $session = new Session();
  
  $db = getDatabaseConnection();
  $id_restaurant = intval($_GET['id']);
  
  if (!$session->isLoggedIn()) {
    $session->addMessage('error', 'You must be logged in to view this page');
    die(header('Location: /'));
  }
  ?> <h2> <?=$session->getId()?></h2> <?php
  if(Restaurant::getRestaurantOwner($db, $id_restaurant)!=$session->getId()) {
    $session->addMessage('error', 'You are not the owner of this restaurant');
    die(header('Location: /'));
  }


  $user = User::getUser($db, $session->getId());
  $restaurant = Restaurant::getRestaurant($db, $id_restaurant);

  drawHeader($session);
  drawRestaurantForm($restaurant);
  drawFooter($session);
?>