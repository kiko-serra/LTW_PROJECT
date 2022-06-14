<?php


class Comment
{
    public int $id_comment;
    public string $comment;
    public int $id_user;
    public int $id_restaurant;
    public int $id_response;
    public string $username;
    public string $title;

    public function __construct($c)
    {
        $this->id_comment = intval($c["id_comment"]);
        $this->comment = $c["comment"];
        $this->id_user = intval($c["id_user"]);
        $this->id_restaurant = intval($c["id_restaurant"]);
        $this->id_response = intval($c["id_response"]);
        $this->username = $c["username"];
        $this->title = $c["title"] ?? "Comment";
    }

    static function  getRestaurantComments(PDO $db, int $id_restaurant)
    {
        $stmt = $db->prepare('SELECT id_restaurant,id_user,id_response,title,
        id_comment,comment,User.username FROM Comment Join User using (id_user) WHERE id_restaurant = ?');
        $stmt->execute(array($id_restaurant));
        $aux = $stmt->fetchAll();
        $res = [];
        foreach ($aux as $comment) {
            $res[] = new Comment($comment);
        }
        return $res;
    }
}
