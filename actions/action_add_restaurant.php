<?php
  declare(strict_types = 1);


  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.php');
  require_once(__DIR__ . '/../database/user.php');
  
  $db = getDatabaseConnection();

  $name = $_POST['name'];
  $address = $_POST['address'];
  $category = $_POST['category'];
  $reviewScore = $_POST['reviewScore'];
  $title = $_POST['title']; 

  // Don't allow certain characters
  if ( !preg_match ("/^[a-zA-Z0-9]+$/", $name)) {
    $session->addMessage('error', 'Username can only contain letters and numbers!');
    $next = '../pages/signup.php';
    die(header('Location: ' . $next));
  }

  try {
    if(User::checkEmailUsernamePhoneNumber($db,null,$email, $username, $phone_number)) {
      $session->addMessage('error', 'Email, username or phone number already exists!');
      $next = '../pages/signup.php';
      die(header('Location: ' . $next));
    }
    User::insertUser($db, $first_name, $last_name, $email, $address, $username, $phone_number, $password);
    $session->setId(intval($username));
    $session->addMessage('success', 'Signed up!');
    $session->setName($first_name);
    $next= '../pages/login.php';
    header('Location: ' . $next);
  } catch (PDOException $e) {
    die($e->getMessage());
    $session->addMessage('error', 'Failed to signup!');
    $next = '../pages/signup.php';
    header('Location: ' . $next);
  }
