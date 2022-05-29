<?php
require_once('../templates/common-tpl.php');
require_once('../utils/session.php');
require_once('../templates/restaurant-tpl.php');
$session= new Session();

  // Verify if user is not logged in
  if (!$session->isLoggedIn())
    die(header('Location: ../pages/login.php'));

drawHeader($session);
drawAddRestaurant();
drawFooter($session);

?>
