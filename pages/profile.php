<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/connection.php');
  require_once(__DIR__ . '/../database/user.php');
  require_once(__DIR__ . '/../templates/common-tpl.php');
  require_once(__DIR__ . '/../templates/user-tpl.php');
  $session = new Session();
  
  if (!$session->isLoggedIn()) {
    $session->addMessage('error', 'You must be logged in to view this page');
    die(header('Location: /'));
  }
  if ($_GET['id'] != $session->getId()) {
    $session->addMessage('error', 'You are not the owner of this account');
    die(header('Location: /'));
  }
  $db = getDatabaseConnection();

  if(!User::checkIfUserExists($db, intval($_GET['id']))) {
    $session->addMessage('error', 'User does not exist');
    die(header('Location: ../actions/action_logout.php'));
  } 

  $userId =  $_GET['id'];
  $user = User::getUser($db, $session->getId());
  $restaurants = User::getUserRestaurants($db, $user->username);
  $orders = User::getUserOrders($db, $user->username);
  $favourites = User::getUserFavourites($db, $user->username);

  drawHeader($session);
  drawNav($session);
  drawProfilePage($session, $restaurants, $orders, $favourites, $db);
  drawFooter($session);
?>