<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/connection.php');
  require_once(__DIR__ . '/../database/user.php');
  require_once(__DIR__ . '/../templates/common-tpl.php');
  require_once(__DIR__ . '/../templates/user-tpl.php');
  $session = new Session();
  
  if (!$session->isLoggedIn() || $_GET['id'] != $session->getId()) {
    $session->addMessage('error', 'You must be logged in to view this page');
    die(header('Location: /'));
  }


  $db = getDatabaseConnection();

  $userId =  $_GET['id'];
  $user = User::getUser($db, $session->getId());
  $restaurants = User::getUserRestaurants($db, $user->username);
  $orders = User::getUserOrders($db, $user->username);

  drawHeader($session);
  drawNav($session->isLoggedIn());
  drawProfilePage($user, $restaurants, $orders);
  drawFooter($session);
?>