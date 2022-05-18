<?php

declare(strict_types=1);

class Restaurant
{

  public string $name;
  public string $title;
  public string $description;
  public float $reviewScore;
  private int  $id;
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
  public function setTitle(string $title){
    $this->title= $title;
    $this->changedList["title"]= $this->title;
  }
  public function setDescription(string $description){
    $this->description= $description;
    $this->changedList["category"]= $this->description;
  }
  public function setReviewScore(float $reviewScore){
    $this->reviewScore= $reviewScore;
    $this->changedList["review_score"]= $this->reviewScore;
  }

  public function save()
  {
    $dbh = new PDO('sqlite:database/uber.db');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    foreach ($this->changedList as $key => $value) {
      $stmt = $dbh->prepare('UPDATE Restaurant SET '. $key.' = ? WHERE id_restaurant = ?');
     
      $stmt->execute(array($value,$this->id));
    }
  }
}
?>



<?php
// Just a temporary function to test  
 function alterRestaurant(Restaurant $r ){
    $r->setName("Gusteau's"); 
    $r->setDescription("French Cuisine");
    $r->setReviewScore(10.5);
    $r->save();
} 
?>