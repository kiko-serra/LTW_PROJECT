<?php
require_once(__DIR__ ."/../database/connection.php");
require_once(__DIR__ ."/../utils/session.php");

$params = ["id_restaurant","title","comment"];
$_POST= json_decode(file_get_contents('php://input'),true);

foreach($params  as $p){
    if(!isset($_POST[$p]))
        die(json_encode("Missing Parameters"));
}
$id_restaurant = $_POST["id_restaurant"];
$title = $_POST["title"];
$comment = $_POST["comment"];

$session = new Session();

// Needs to be filtered
try{

    $db = getDatabaseConnection();
    $stmt = $db->prepare("insert into comment (id_user,id_restaurant,comment,title) values (?,?,?,?)");
    $stmt->execute(array($session->getId(),$id_restaurant,$comment,$title));
    die(json_encode("Successefully added comment"));

}catch(Exception $e){
    die(json_encode("Database Error:" . $e ));
}
?>