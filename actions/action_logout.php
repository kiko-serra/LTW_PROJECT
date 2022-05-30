<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();
  $session->logout();
  $session = new Session();
  $session->addMessage("Success","Logout Successeful");

  header('Location: ' . '../index.php');
?>