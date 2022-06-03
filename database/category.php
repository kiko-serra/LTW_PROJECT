<?php

declare(strict_types=1);

class Category
{
  public int $id_category;
  public string $name;
  public string $img_url;


  public function __construct($m)
  {
    $this->id_category = intval($m["id_category"]);
    $this->name = $m["name"];
    $this->img_url = $m["link"];
  }
}
?>