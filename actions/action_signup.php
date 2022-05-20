<?php
  declare(strict_types = 1);


  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.php');
  require_once(__DIR__ . '/../database/user.php');
  
  $db = getDatabaseConnection();

  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $username = $_POST['username'];
  $phone_number = $_POST['phone_number'];
  $password = $_POST['password'];

  // Don't allow certain characters
  if ( !preg_match ("/^[a-zA-Z0-9]+$/", $username)) {
    $session->addMessage('error', 'Username can only contain letters and numbers!');
    $next = '../pages/signup.html';
    die(header('Location: ' . $next));
  }

  try {
    if(User::checkEmailUsernamePhoneNumber($db, $email, $username, $phone_number)) {
      $session->addMessage('error', 'Email, username or phone number already exists!');
      $next = '../pages/signup.html';
      die(header('Location: ' . $next));
    }
    User::insertUser($db, $first_name, $last_name, $email, $address, $username, $phone_number, $password);
    $session->setId(intval($username));
    $session->addMessage('success', 'Signed up and logged in!');
    $next= '../index.php';
    header('Location: ' . $next);
  } catch (PDOException $e) {
    die($e->getMessage());
    $session->addMessage('error', 'Failed to signup!');
    $next = '../pages/signup.html';
    header('Location: ' . $next);
  }
?>