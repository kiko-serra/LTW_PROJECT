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
    if(!isset($_POST["id_response"])){
    $stmt = $db->prepare("insert into comment (id_user,id_restaurant,comment,title) values (?,?,?,?)");
    $stmt->execute(array($session->getId(),$id_restaurant,$comment,$title));
    }
    else{
    $stmt = $db->prepare("insert into comment (id_user,id_restaurant,comment,title,id_response) values (?,?,?,?,?)");
    $stmt->execute(array($session->getId(),$id_restaurant,$comment,$title,$_POST["id_response"]));

    }
    $id_comment = $db->lastInsertId();
    $stmt = $db->prepare("Select username from User where id_user =?");
    $stmt->execute(array($session->getId()));
    $username = $stmt->fetch()["username"];
    die(json_encode(array("id"=>$id_comment,"id_restaurant"=>$id_restaurant,
    "comment"=>$comment , "title" =>$title,"username"=>$username)));

}catch(Exception $e){
    die(json_encode("Database Error:" . $e ));
}
