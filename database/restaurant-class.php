<?php

declare(strict_types=1);
require_once(__DIR__ ."/connection.php");
class Restaurant
{

  public string $name;
  public string $title;
  public string $category;
  public float $reviewScore;
  public int  $id;
  private $changedList;

  public function __construct($r)
  {
    $this->name = $r["name"];
    $this->title = $r["title"];
    $this->description = $r["category"];
    $this->id = intval($r["id_restaurant"]);
    $this->reviewScore = floatval($r["review_score"]);
  }


  public function setName(string $name)
  {
    $this->name = $name;
    $this->changedList["name"] = $this->name;
  }
  public function setTitle(string $title)
  {
    $this->title = $title;
    $this->changedList["title"] = $this->title;
  }
  public function setCategory(string $category){
    $this->category= $category;
    $this->changedList["category"]= $this->category;
  }
  public function setReviewScore(float $reviewScore)
  {
    $this->reviewScore = $reviewScore;
    $this->changedList["review_score"] = $this->reviewScore;
  }

  public function save(){
    $db = getDatabaseConnection();
    foreach ($this->changedList as $key => $value) {
      $stmt = $db->prepare('UPDATE Restaurant SET ' . $key . ' = ? WHERE id_restaurant = ?');

      $stmt->execute(array($value, $this->id));
    }
  }

  static function searchRestaurants(string $search, int $count){
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT * FROM Restaurant WHERE Name LIKE ? LIMIT ?');
    $stmt->execute(array($search . '%', $count));
    $result = $stmt->fetchAll();
    $restaurants = array();
    foreach ($result as $restaurant) {
      $restaurants[] = new Restaurant($restaurant);
    }
    return $restaurants;
  }

  static function insertRestaurant($db, $name, $title, $category, $reviewScore, $address) : Restaurant{

    $stmt = $db->prepare('INSERT INTO Restaurant (name, title, category, review_score, address) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute(array($name, $title, $category, $reviewScore, $address));
    $stmt = $db->prepare('SELECT * FROM Restaurant WHERE name = ? AND title = ? AND category = ? AND review_score = ? AND address = ?');
    $stmt->execute(array($name, $title, $category, $reviewScore, $address));
    $r = $stmt->fetch();
    insertRestaurantOwner($db, $id_user, $r["id_restaurant"]);
    return new Restaurant($r);
  }

  static function insertRestaurantOwner($db, $id_user, $id_restaurant){
    $stmt = $db->prepare('INSERT INTO RestaurantOwner (id_user, id_restaurant) VALUES (?, ?)');
    $stmt->execute(array($id_user, $id_restaurant));
  }



}
?>




<?php
// Just a temporary function to test  
function alterRestaurant(Restaurant $r)
{
  $r->setName("Gusteau's");
  $r->setDescription("French Cuisine");
  $r->setReviewScore(10.5);
  $r->save();
}
?>