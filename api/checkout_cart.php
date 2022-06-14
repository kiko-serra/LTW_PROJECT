<?php
require_once(__DIR__ . "/../database/connection.php");
require_once(__DIR__ . "/../utils/session.php");

$session = new Session();

try {
    $db = getDatabaseConnection();
    $total_price = 0;
    $stmt = $db->prepare("insert into Order2 (id_user,price) values (?,?)");
    $stmt->execute(array($session->getId(), $total_price));
    $id_order = $db->lastInsertId();
    foreach ($session->currentOrders() as $menu) {
        $stmt = $db->prepare("select * from MenuInOrder where id_menu= ? and id_order=?");
        $stmt->execute(array($menu, $id_order));
        $ordered = $stmt->fetch();
        if($ordered){
            $stmt = $db->prepare("update MenuInOrder set quantity=? where id_menu= ? and id_order=?");
            $stmt->execute(array(intval($ordered["quatity"])+1,$menu,$id_order));
            continue;
        }

        $stmt = $db->prepare("insert into MenuInOrder (id_menu,id_order) values (?,?)");
        $stmt->execute(array($menu, $id_order));
        $stmt = $db->prepare("select price  from Menu where id_menu = ?");
        $stmt->execute(array($menu));
        $total_price += intval($stmt->fetch()["price"]);
    }
    $stmt = $db->prepare("Update Order2 set price =? where id_order =?");
    $stmt->execute(array($total_price,$id_order));

    $_SESSION["orders"] =  array();
    die(json_encode("Checked out order"));
} catch (Exception $e) {
    die(json_encode("DB error" . $e));
}
