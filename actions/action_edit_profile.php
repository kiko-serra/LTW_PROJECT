<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  if (!$session->isLoggedIn()) die(header('Location: /'));

  require_once(__DIR__ . '/../database/connection.php');
  require_once(__DIR__ . '/../database/user.php');
  $first_name = $_POST['first_name'];
  var_dump($first_name);
  echo $first_name;

  /*if (trim($_POST['first_name']) === '' || trim($_POST['last_name']) === '' || trim($_POST['email']) === '' || trim($_POST['address']) === '' || trim($_POST['username']) === '' || trim($_POST['phone_number']) === '') {
    $session->addMessage('error', 'Information cannot be empty');
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }*/

  $db = getDatabaseConnection();

  $user = User::getUser($db, $session->getId());

  if ($user) {
    $user->setFirstName($_POST['first_name']);
    $user->setLastName($_POST['last_name']);
    $user->setEmail($_POST['email']);
    $user->setAddress($_POST['address']);
    $user->setUsername($_POST['username']);
    $user->setPhoneNumber($_POST['phone_number']);

    try {
      if(User::checkEmailUsernamePhoneNumber($db, $user->email, $user->username, $user->phone_number)) {
        $session->addMessage('error', 'Email, username or phone number already exists!');
        $next = '../pages/signup.html';
        die(header('Location: ' . $next));
      }
    }catch (PDOException $e) {
        die($e->getMessage());
        $session->addMessage('error', 'Failed to edit profile!');
        $next = '../pages/profile.php';
    $user->save($db);

    $session->setName($user->name());
    }
  }
  header('Location: ' . $next);
?>