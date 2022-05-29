<?php
require_once('../templates/auth-tpl.php');
require_once('../templates/common-tpl.php');
require_once('../utils/session.php');
$session= new Session();

  // Verify if user is logged in
  if ($session->isLoggedIn())
    die(header('Location: ../index.php'));

drawHeader($session);
drawSignUp();
drawFooter();

?>
