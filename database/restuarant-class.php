<?php
declare(strict_types=1);

class Restaurant{
    public string $name;
    public string $title;
    public string $description;
    public float $reviewScore;
    private int  $id;

    public function __construct($r) {
    $this->name = $r["name"];
    $this->title = $r["title"];
    $this->description= $r["category"];
    $this->id = intval($r["id_restaurant"]);
    $this->reviewScore = floatval($r["review_score"]);
  }
}
?>