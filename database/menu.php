<?php

declare(strict_types=1);

class Menu
{
  public int $id_menu;
  public int $price;
  public int $id_restaurant;
  public int $id_photo;
  public string $name;


  public function __construct($m)
  {
    $this->id_menu = intval($m["id_menu"]);
    $this->name = $m["name"];
    $this->price = intval($m["price"]);
    $this->id_restaurant = intval($m["id_restaurant"]);
    $this->id_photo = intval($m["id_photo"]);
    $this->id_menu_type = intval($m["id_menu_type"]);
  }
}
?>