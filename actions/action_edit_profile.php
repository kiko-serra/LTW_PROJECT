<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  if (!$session->isLoggedIn()) die(header('Location: /'));

  require_once(__DIR__ . '/../database/connection.php');
  require_once(__DIR__ . '/../database/user.php');

  $db = getDatabaseConnection();

  $user = User::getUser($db, $session->getId());

  if ($user) {
    $user->first_name = $_POST['first_name'];
    $user->last_name = $_POST['last_name'];
    
    $user->save($db);

    $session->setName($user->name());
  }

  header('Location: ../pages/profile.php');
?>