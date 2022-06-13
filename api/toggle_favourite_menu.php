<?php

require_once(__DIR__ . "/../database/connection.php");
$params = ["id_menu", "id_user"];
$_POST= json_decode(file_get_contents('php://input'),true);

foreach($params  as $p){
    if(!isset($_POST[$p]))
        die(json_encode("Missing Parameters"));
} 

$id_menu = $_POST["id_menu"];
$id_user = $_POST["id_user"];

try {
    $db = getDatabaseConnection();

    $stmt = $db->prepare("select * from FavouriteMenu where id_user = ? and id_menu=?");
    $stmt->execute(array($id_user, $id_menu));
    $favourite = $stmt->fetch();
    if ($favourite) {
        $stmt = $db->prepare("Delete from  FavouriteMenu where id_user=? and id_menu=?");
        $stmt->execute(array($id_user, $id_menu));
        die(json_encode(array("removed" =>"Successefully removed menu from favourites")));
    } else {
        $stmt = $db->prepare("Insert into FavouriteMenu (id_user,id_menu) values (?,?)");
        $stmt->execute(array($id_user, $id_menu));
        die(json_encode(array("added" => "Successefully added menu to favourites")));
    }
} catch (Exception $e) {
    die(json_encode(array("error" =>"Error while acessing db :" . $e)));
}
