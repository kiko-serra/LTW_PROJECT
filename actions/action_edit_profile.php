<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');

  $session = new Session();
  if (!$session->isLoggedIn()) die(header('Location: /'));

  require_once(__DIR__ . '/../database/connection.php');
  require_once(__DIR__ . '/../database/user.php');
  
  $next = '../pages/profile.php?id=' . urlencode($session->getId());


  $db = getDatabaseConnection();

  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $username = $_POST['username'];
  $phone_number = $_POST['phone_number'];
  $password = $_POST['password'];

  if(!preg_match('/^[a-zA-Z0-9]{3,20}$/', $username)) {
    $session->addMessage('error', 'Username must be between 3 and 20 characters and contain only letters and numbers and cannot be empty');
    die(header('Location: ' . $next));
  }
  if(!preg_match('/^[a-zA-Z0-9!\?]{3,20}$/', $password)) {
    $session->addMessage('error', 'Password must be between 3 and 20 characters and contain only letters and numbers and !? and cannot be empty');
    die(header('Location: ' . $next));
  }
  if(!preg_match('/^[a-zA-Z]+$/', $first_name) || !preg_match('/^[a-zA-Z]+$/', $last_name)) {
    $session->addMessage('error', 'First and Last names must contain only letters and cannot be empty');
    die(header('Location: ' . $next));
  }
  if(!preg_match('/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/', $email)) {
    $session->addMessage('error', 'Email must be in format: ___@___.___ and cannot be empty');
    die(header('Location: ' . $next));
  }
  if(!preg_match('/^[0-9]{,10}$/', $phone_number)) {
    $session->addMessage('error', 'Phone number can have at most 10 digits and cannot be empty');
    die(header('Location: ' . $next));
  }
  if(!preg_match('/^[a-zA-Z0-9]+$/', $address)) {
    $session->addMessage('error', 'Address must contain only letters and numbers and cannot be empty');
    die(header('Location: ' . $next));
  }

  $user = User::getUser($db, $session->getId());

  if ($user) {
    $user->setFirstName($first_name);
    $user->setLastName($last_name);
    $user->setEmail($email);
    $user->setAddress($address);
    $user->setUsername($username);
    $user->setPhoneNumber($phone_number);

    try {

      if(User::checkEmailUsernamePhoneNumber($db, $user->id_user,$user->email, $user->username, $user->phone_number)) {
        $session->addMessage('error', 'Email, username or phone number already exists!');
        die(header('Location: ' . $next));
      }
      else{
        $user->save($db);
        $session->addMessage('success', 'Changed  Successefully!');
      }

    }catch (PDOException $e) {
        $session->addMessage('error', 'Failed to edit profile!');      
        die($e->getMessage());
      }
      $session->setName($user->first_name);
  }

  header('Location: ' . $next);

?>  