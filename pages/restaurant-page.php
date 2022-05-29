<?php

require_once("../templates/common-tpl.php");
require_once("../templates/restaurant-tpl.php");
require_once("../database/restaurant-class.php");
require_once("../templates/menus-tpl.php");
require_once("../database/connection.php");
require_once("../database/menu.php");
require_once("../utils/session.php");
$session = new Session();


$db= getDatabaseConnection();
$res = array();
$restaurantId =  $_GET['id'];
$restaurantName =  $_GET['name'];

try {

    $stmt = $db->prepare('SELECT * FROM Menu where id_restaurant = ?');
    $stmt->execute(array($restaurantId));
    $menus = $stmt->fetchAll();

    foreach ($menus as $menu) {
        $temp = new Menu($menu);
        $res[] = $temp;
    }
    
} catch (PDOException $e) {
    echo $e->getMessage();
}

drawHeader($session);
drawNav(true);

{ ?>

<header>
    <h2> <?php $_GET['name'] ?> </h2>

</header>



<?php }

drawMenus($res);

drawFooter($session);
?>