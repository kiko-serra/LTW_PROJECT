<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/connection.php');
  require_once(__DIR__ . '/../database/user.php');
  require_once(__DIR__ . '/../database/menu.php');
  require_once(__DIR__ . '/../templates/common-tpl.php');
  require_once(__DIR__ . '/../templates/user-tpl.php');
  require_once (__DIR__ . '/../templates/menus-tpl.php');
  $session = new Session();
  
  if (!$session->isLoggedIn()) {
    $session->addMessage('error', 'You must be logged in to view this page');
    die(header('Location: /'));
  }
  if ($_GET['id'] != $session->getId()) {
    $session->addMessage('error', 'You are not the owner of this account');
    die(header('Location: /'));
  }
  $db = getDatabaseConnection();

  if(!User::checkIfUserExists($db, intval($_GET['id']))) {
    $session->addMessage('error', 'User does not exist');
    die(header('Location: /'));
  } 

  $totalPrice = 0;

  $menuIds = $session->currentOrders();
  $menus = array();
  $count = array();

  foreach ($menuIds as $id) {
    $count[$id] = 0;
  }

  foreach ($menuIds as $id) {
    $count[$id] += 1;
  }

  if(!empty($menuIds))
    $menuIds = array_unique($menuIds);

  foreach ($menuIds as $id) {
 
    $stmt = $db->prepare('SELECT * from Menu JOIN Photo using (id_photo) where id_menu = ?');
    $stmt->execute(array($id));
    $menu = $stmt->fetch();

    
  
    $temp = new Menu($menu);
    $totalPrice += $temp->price * $count[$temp->id_menu];
    $menus[] = $temp;
  }



  drawHeader($session);
  drawNav($session);
  drawCheckout($menus, $session, $count, $totalPrice);
  drawFooter($session);

?>