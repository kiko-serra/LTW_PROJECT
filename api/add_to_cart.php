<?php
require_once(__DIR__ ."/../database/connection.php");
require_once(__DIR__ ."/../utils/session.php");
$params = ["id_menu"];
$_POST= json_decode(file_get_contents('php://input'),true);

foreach($params  as $p){
    if(!isset($_POST[$p]))
        die(json_encode("Missing Parameters"));
}

$id_menu = $_POST["id_menu"];

$session = new Session();
$session->addOrder(intval($id_menu));
die(json_encode("Added Menu to order"));

?>