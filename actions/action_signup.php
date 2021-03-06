<?php
  declare(strict_types = 1);


  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.php');
  require_once(__DIR__ . '/../database/user.php');
  $next='../pages/signup.php';
  $db = getDatabaseConnection();
  print_r($_POST);
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $username = $_POST['username'];
  $phone_number = $_POST['phone_number'];
  $password = $_POST['password'];

  // Don't allow certain characters
  if(!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
    $session->addMessage('error', 'Username must be between 3 and 20 characters and contain only letters and numbers and cannot be empty');
    die(header('Location: ' . $next));
  }
  if(!preg_match('/^[a-zA-Z0-9!\?]{3,20}$/', $password)) {
    $session->addMessage('error', 'Password must be between 3 and 20 characters and contain only letters and numbers and !? and cannot be empty');
    die(header('Location: ' . $next));
  }
  if(!preg_match('/^[a-zA-Z ]+$/', $first_name) || !preg_match('/^[a-zA-Z ]+$/', $last_name)) {
    $session->addMessage('error', 'First and Last names must contain only letters and cannot be empty');
    die(header('Location: ' . $next));
  }
  if(!preg_match('/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/', $email)) {
    $session->addMessage('error', 'Email must be in format: ___@___.___ and cannot be empty');
    die(header('Location: ' . $next));
  }
  if(!preg_match('/^[0-9]{1,10}$/', $phone_number)) {
    $session->addMessage('error', 'Phone number can have at most 10 digits and cannot be empty');
    die(header('Location: ' . $next));
  }
  if(!preg_match('/^[a-zA-Z0-9 ]+$/', $address)) {
    $session->addMessage('error', 'Address must contain only letters and numbers and cannot be empty');
    die(header('Location: ' . $next));
  }

  try {
    if(User::checkEmailUsernamePhoneNumber($db,null,$email, $username, $phone_number)) {
      $session->addMessage('error', 'Email, username or phone number already exists!');
      $next = '../pages/signup.php';
      die(header('Location: ' . $next));
    }
    User::insertUser($db, $first_name, $last_name, $email, $address, $username, $phone_number, $password);
    $session->setId(intval($db->lastInsertId()));
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
