<?php


class Comment{
    public int $id_comment;
    public string $comment;
    public int $id_user;
    public int $id_restaurant;
    public int $id_response;
    

    public function __construct($c)
    {
    $this->id_comment = $c["id_comment"];
    $this->comment = $c["comment"];
    $this->id_user = $c["id_user"];
    $this->id_restaurant = $c["id_restaurant"];
    $this->id_response = $c["id_response"];
        
    }
}

?>