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
    $stmt = $db->prepare('SELECT * FROM Menu where id_restaurant = ?');
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
drawNav($session->isLoggedIn()); { ?>

    <header>
        <h2 class="restaurant-name"> <?= $restaurant->name ?> </h2>
    </header>

    <a href="../pages/edit-restaurant.php?id=<?= $_GET['id'] ?>">Edit</a>

    </form>


<?php }

drawMenus($menu_res);
drawFooter($session);
?>