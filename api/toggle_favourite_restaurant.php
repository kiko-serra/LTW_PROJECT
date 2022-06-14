<?php

require_once(__DIR__ . "/../database/connection.php");
require_once(__DIR__ ."/../utils/session.php");
$params = ["id_restaurant"];
$_POST= json_decode(file_get_contents('php://input'),true);
foreach($params  as $p){
    if(!isset($_POST[$p]))
        die(json_encode("Missing Parameters"));
} 

$session = new Session();
$id_restaurant = $_POST["id_restaurant"];
$id_user = $session->getID();
try {
    $db = getDatabaseConnection();

    $stmt = $db->prepare("select * from FavouriteRestaurant where id_user = ? and id_restaurant=?");
    $stmt->execute(array($id_user, $id_restaurant));
    $favourite = $stmt->fetch();
    if ($favourite) {
        $stmt = $db->prepare("Delete from  FavouriteRestaurant where id_user=? and id_restaurant=?");
        $stmt->execute(array($id_user, $id_restaurant));
        die(json_encode(array("removed" =>"Successefully removed restaurant from favourites")));
    } else {
        $stmt = $db->prepare("Insert into FavouriteRestaurant (id_user,id_restaurant) values (?,?)");
        $stmt->execute(array($id_user, $id_restaurant));
        die(json_encode(array("added" => "Successefully added restaurant to favourites")));
    }
} catch (Exception $e) {
    die(json_encode(array("error" =>"Error while acessing db :" . $e)));
}
