<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  if (!$session->isLoggedIn()) die(header('Location: /'));

  require_once(__DIR__ . '/../database/connection.php');
  require_once(__DIR__ . '/../database/user.php');
  

  /*if (trim($_POST['first_name']) === '' || trim($_POST['last_name']) === '' || trim($_POST['email']) === '' || trim($_POST['address']) === '' || trim($_POST['username']) === '' || trim($_POST['phone_number']) === '') {
    $session->addMessage('error', 'Information cannot be empty');
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }*/

  $db = getDatabaseConnection();

  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $username = $_POST['username'];
  $phone_number = $_POST['phone_number'];
  $next = '../pages/profile.php';
  $user = User::getUser($db, $session->getId());

  echo $user->id_user;

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
        //echo "<p> User already exists</p>";
        die(header('Location: ' . $next));
      }
      else{
        $user->save($db);
        $session->addMessage('success', 'Changed  Successefully!');
      }
    }catch (PDOException $e) {
        die($e->getMessage());
        $session->addMessage('error', 'Failed to edit profile!');      
      }
      $session->setName($user->name());
  }

  header('Location: ' . $next);

?>  