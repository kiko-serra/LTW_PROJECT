<?php

declare(strict_types=1);
require_once(__DIR__ ."/connection.php");
class Restaurant
{

  public string $name;
  public string $title;
  public int $category;
  public float $reviewScore;
  public int  $id;
  public string $address;
  private $changedList;

  public function __construct($r)
  {
    $this->name = $r["name"];
    $this->title = $r["title"];
    $this->category = intval($r["category"]);
    $this->id = intval($r["id_restaurant"]);
    $this->reviewScore = floatval($r["review_score"]);
    $this->address = $r["address"];

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
      $stmt = $db->prepare('UPDATE Restaurant SET '. $key.' = ? WHERE id_restaurant = ?');
      $stmt->execute(array($value,$this->id));
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

  static function insertRestaurantOwner(PDO $db, int $id_user, int $id_restaurant)
  {
    $stmt = $db->prepare('INSERT INTO RestaurantOwner (id_user, id_restaurant, balance) VALUES (?, ?, 0)');
    $stmt->execute(array($id_user, $id_restaurant));
  }

  static function insertRestaurant(PDO $db, int $id_user, string $name, string $title, string $category, string $reviewScore, string $address) : Restaurant
  {
    $stmt = $db->prepare('INSERT INTO Restaurant (name, title, category, review_score, address) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute(array($name, $title, $category, $reviewScore, $address));
    $stmt = $db->prepare('SELECT * FROM Restaurant WHERE name = ? AND title = ? AND category = ? AND review_score = ? AND address = ?');
    $stmt->execute(array($name, $title, $category, $reviewScore, $address));
    $aux = $stmt->fetch();
    $r = intval($aux["id_restaurant"]);
    Restaurant::insertRestaurantOwner($db, $id_user, $r);
    return Restaurant::getRestaurant($db, $r);
  }

  static function getRestaurantOwner(PDO $db, int $id_restaurant): ?int{
    $stmt = $db->prepare('SELECT id_user FROM RestaurantOwner WHERE id_restaurant = ?');
    $stmt->execute(array($id_restaurant));
    $aux = $stmt->fetch();
    if($aux){
      return intval($aux["id_user"]);
    }
    return null;
  }
  
  // Just a temporary function to test  
  function alterRestaurant(Restaurant $r ){
    $r->setName("Gusteau's"); 
    $r->setDescription("French Cuisine");
    $r->setReviewScore(10.5);
    $r->save();
  } 

  static function getRestaurants() {
    
    $dbo= getDatabaseConnection();
    $res = array();
    
    try {
      $stmt = $dbo->prepare('SELECT * FROM Restaurant');
      $stmt->execute();
      $restaurants = $stmt->fetchAll();
      foreach ($restaurants as $restaurant) {
        $temp = new Restaurant($restaurant);
        $res[] = $temp;
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    
    $_SESSION['res'] = json_encode($res, true);
    return $res;
  } 
  
  
  
  static function getRestaurant(PDO $db, int $id_restaurant) : Restaurant{
    $stmt = $db->prepare('SELECT * FROM Restaurant WHERE id_restaurant = ?');
    $stmt->execute(array($id_restaurant));
    $aux = $stmt->fetch();
    $r = new Restaurant($aux);
  return $r;
}


}
?>