<?php

declare(strict_types=1);

class Comment
{
  public string $username;
  public string $text;
  public int $likes;
  public int $score;


  public function __construct($m)
  {
    $this->likes = intval($m["likes"]);
    $this->score = intval($m["score"]);
    $this->username = $m["username"];
    $this->text = $m["text"];
  }
}
?>