<?php
require_once('../templates/auth-tpl.php');
require_once('../templates/common-tpl.php');
require_once('../utils/session.php');
$session= new Session();


drawHeader($session);
drawLogIn();
drawFooter();

?>