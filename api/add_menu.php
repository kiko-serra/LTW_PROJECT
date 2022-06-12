<?php

require_once(__DIR__ ."/../database/connection.php");
$params = ["r_id","p_id","name","price","type","description"];
$_POST= json_decode(file_get_contents('php://input'),true);

foreach($params  as $p){
    if(!isset($_POST[$p]))
        die(json_encode("Missing Parameters"));
}

$name = $_POST["name"];
$price = $_POST["price"];
$description = $_POST["description"];
$type= $_POST["type"];
$r_id = $_POST["r_id"];
$p_id = $_POST["p_id"];
try{

$db = getDatabaseConnection();

$stmt = $db->prepare("insert into Menu (name,price,description,id_menu_type,id_restaurant,id_photo) 
    values (?,?,?,?,?,?)");
$stmt->execute(array($name,$price,$description,$type,$r_id,$p_id));
die(json_encode(array("success" =>"Sucessefully Added Menu")));

}catch(Exception $e){
    die(json_encode("Error while accessing DB"));
}

?>

