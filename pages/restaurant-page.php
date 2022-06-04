<?php

require_once("../templates/common-tpl.php");
require_once("../templates/restaurant-tpl.php");
require_once("../database/restaurant-class.php");
require_once("../templates/menus-tpl.php");
require_once("../database/connection.php");
require_once("../database/menu.php");
require_once("../utils/session.php");
$session = new Session();


$db = getDatabaseConnection();
$menu_res = array();
$restaurantId =  $_GET['id'];
try {


    $restaurant = Restaurant::getRestaurant($db, $restaurantId);
    $stmt = $db->prepare('SELECT * FROM Menu join Photo using (id_photo) where id_restaurant = ?');
    $stmt->execute(array($restaurantId));
    $menus = $stmt->fetchAll();


    foreach ($menus as $menu) {
        $temp = new Menu($menu);
        $menu_res[] = $temp;
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

drawHeader($session);
{ ?>
    <section class = "restaurant-banner" style = "background: linear-gradient(0deg, rgba(26, 19, 47, 0.7), rgba(26, 19, 47, 0.7)), url('<?= $restaurant-> img_url?>'); background-size: cover;">
        <h2 class="restaurant-name"> <?= $restaurant->name ?> </h2>
    </section>


<?php }

drawMenus($menu_res);
drawFooter($session);
?>