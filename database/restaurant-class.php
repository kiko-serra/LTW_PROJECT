<?php

declare(strict_types=1);
require_once(__DIR__ . "/comment.php");


require_once(__DIR__ . "/connection.php");
class Restaurant
{

  public string $name;
  public string $title;
  public $categories;
  public float $reviewScore;
  public int  $id;
  public string $address;
  public ?string $img_url;
  private $changedList;

  public function __construct($r)
  {
    $this->name = $r["name"];
    $this->title = $r["title"];
    $this->id = intval($r["id_restaurant"]);
    $this->reviewScore = floatval($r["review_score"]);
    $this->address = $r["address"];
    $this->img_url = $r["link"] ?? null;

    $this->categories = Restaurant::getCategories(getDatabaseConnection(), $this->id);
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
  public function setCategory(int $category)
  {
    $this->category = $category;
    $this->changedList["category"] = $this->category;
  }
  public function setReviewScore(float $reviewScore)
  {
    $this->reviewScore = $reviewScore;
    $this->changedList["review_score"] = $this->reviewScore;
  }
  public function setAddress(string $address)
  {
    $this->address = $address;
    $this->changedList["address"] = $this->address;
  }

  public function save()
  {
    $db = getDatabaseConnection();
    foreach ($this->changedList as $key => $value) {
      $stmt = $db->prepare('UPDATE Restaurant SET ' . $key . ' = ? WHERE id_restaurant = ?');
      $stmt->execute(array($value, $this->id));
    }
  }

  static function searchRestaurants(string $search, $filters, int $count)
  {
    $filterQuery = "";
    if ($filters) {
      $filterQuery  = $filterQuery . " AND (";
      for ($i = 0; $i < count($filters); $i++) {
        $filterQuery = $filterQuery . "id_category =" . $filters[$i];
        if ($i < (sizeof($filters) - 1))
          $filterQuery = $filterQuery . " OR ";
      }
      $filterQuery  = $filterQuery . ")";
    }

    $db = getDatabaseConnection();
    if ($filterQuery) {
      $query = 'SELECT id_restaurant, Restaurant.name,address, review_score, title, Photo.link FROM Restaurant left JOIN Photo using (id_photo) JOIN RestaurantCategory using (id_restaurant) WHERE Name LIKE ? ' . $filterQuery . '
    UNION SELECT id_restaurant, Restaurant.name,address, review_score, title, Photo.link FROM Restaurant JOIN Photo using (id_photo) JOIN RestaurantCategory using (id_restaurant) JOIN Menu using (id_restaurant) WHERE Menu.name LIKE ?' . $filterQuery . 'LIMIT ?';
    } else {
      $query = 'SELECT id_restaurant, Restaurant.name,address, review_score, title, Photo.link  FROM Restaurant left JOIN Photo using (id_photo) WHERE Name LIKE ?  UNION
       SELECT id_restaurant, Restaurant.name,address, review_score, title, Photo.link FROM Restaurant left JOIN Photo using (id_photo) JOIN RestaurantCategory using (id_restaurant) JOIN Menu using (id_restaurant) WHERE Menu.name LIKE ? LIMIT ?';
    }
    $stmt = $db->prepare($query);
    $stmt->execute(array($search . '%', $search . '%',  $count));
    $result = $stmt->fetchAll();
    $restaurants = array();

    foreach ($result as $restaurant) {
      $restaurants[] = new Restaurant($restaurant);
    }
    return $restaurants;
  }

  static function getCategories(PDO $db, int $id_restaurant)
  {
    $stmt = $db->prepare("select id_category from RestaurantCategory where id_restaurant = ?");
    $stmt->execute(array($id_restaurant));
    $categories = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    return $categories;
  }
  static function insertRestaurantOwner(PDO $db, int $id_user, int $id_restaurant)
  {
    $stmt = $db->prepare('INSERT INTO RestaurantOwner (id_user, id_restaurant, balance) VALUES (?, ?, 0)');
    $stmt->execute(array($id_user, $id_restaurant));
  }

  static function insertRestaurant(PDO $db, int $id_user, string $name, string $title,  $categories, string $reviewScore, string $address, int $id_photo): Restaurant
  {
    $stmt = $db->prepare('INSERT INTO Restaurant (name, title, review_score, address,id_photo) VALUES (?, ?, ?, ?,?)');
    $stmt->execute(array($name, $title, $reviewScore, $address, $id_photo));
    $id_restaurant = intval($db->lastInsertId());
    foreach ($categories as $category) {
      $stmt = $db->prepare('INSERT INTO RestaurantCategory (id_restaurant, id_category) VALUES (?, ?)');
      $stmt->execute(array($id_restaurant, intval($category)));
    }

    Restaurant::insertRestaurantOwner($db, $id_user, $id_restaurant);
    return Restaurant::getRestaurant($db, $id_restaurant);
  }

  static function getRestaurantOwner(PDO $db, int $id_restaurant): ?int
  {
    $stmt = $db->prepare('SELECT id_user FROM RestaurantOwner WHERE id_restaurant = ?');
    $stmt->execute(array($id_restaurant));
    $aux = $stmt->fetch();
    if ($aux) {
      return intval($aux["id_user"]);
    }
    return null;
  }

  // Just a temporary function to test  
  function alterRestaurant(Restaurant $r)
  {
    $r->setName("Gusteau's");
    $r->setDescription("French Cuisine");
    $r->setReviewScore(10.5);
    $r->save();
  }

  static function getRestaurants()
  {

    $dbo = getDatabaseConnection();
    $res = array();

    try {
      $stmt = $dbo->prepare('SELECT * FROM Restaurant join Photo using (id_photo)');
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



  static function getRestaurant(PDO $db, int $id_restaurant): ?Restaurant
  {
    $stmt = $db->prepare('SELECT * FROM Restaurant left join Photo using (id_photo) WHERE id_restaurant = ?');
    $stmt->execute(array($id_restaurant));
    $aux = $stmt->fetch();
    if ($aux)
      return new Restaurant($aux);
    return null;
  }
}
