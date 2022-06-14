<?php

declare(strict_types=1);


require_once('../database/restaurant-class.php');
require_once('../database/connection.php');
require_once('../database/menu.php');

class User
{
  public int $id_user;
  public string $first_name;
  public string $last_name;
  public string $email;
  public string $address;
  public string $username;
  public string $phone_number;
  private $changedList;

  public function __construct(int $id_user, string $first_name, string $last_name, string $email, string $address, string $username, string $phone_number)
  {
    $this->id_user = $id_user;
    $this->first_name = $first_name;
    $this->last_name = $last_name;
    $this->email = $email;
    $this->address = $address;
    $this->username = $username;
    $this->phone_number = $phone_number;
  }

  function name()
  {
    return $this->first_name . ' ' . $this->last_name;
  }

  function save($db)
  {
    $db = getDatabaseConnection();
    foreach ($this->changedList as $key => $value) {
      $stmt = $db->prepare('UPDATE User SET ' . $key . ' = ? WHERE id_user = ?');

      $stmt->execute(array($value, $this->id_user));
    }
  }

  static function getUserWithPassword(PDO $db, string $username, string $password): ?User
  {
    $stmt = $db->prepare('
			SELECT id_user, first_name, last_name, email, address, username, phone_number,password
			FROM User 
			WHERE username = ?
      ');

    $stmt->execute(array($username));


    if ($user = $stmt->fetch()) {
      if (password_verify($password, $user["password"])) {
        return new User(
          intval($user['id_user']),
          $user['first_name'],
          $user['last_name'],
          $user['email'],
          $user['address'],
          $user['username'],
          $user['phone_number']
        );
        // Wrong password
      } else return null;
      // No user
    } else return null;
  }
  static function checkIfUserExists(PDO $db, int $id_user): bool
  {
    $stmt = $db->prepare('
        SELECT 1 
        FROM User 
        WHERE id_user = ?
        ');
    $stmt->execute(array($id_user));
    $aux = $stmt->fetch();
    return $aux != null;
  }


  static function getUser(PDO $db, int $id_user): User
  {
    $stmt = $db->prepare('
        SELECT id_user, first_name, last_name, email, address, username, phone_number
        FROM User 
        WHERE id_user = ?
      ');
    $stmt->execute(array($id_user));
    $user = $stmt->fetch();
    return new User(
      intval($user['id_user']),
      $user['first_name'],
      $user['last_name'],
      $user['email'],
      $user['address'],
      $user['username'],
      $user['phone_number']
    );
  }

  static function getUserId(PDO $db, string $username): int
  {
    $stmt = $db->prepare('
        SELECT id_user
        FROM User 
        WHERE username = ?
      ');

    $stmt->execute(array($username));
    $user = $stmt->fetch();

    return intval($user['id_user']);
  }

  static function getUserFavourites(PDO $db, string $username) {

    $res = array();

    try {
      $stmt = $db->prepare('SELECT * FROM Menu join Photo using (id_photo) join FavouriteMenu using (id_menu) where id_user = ? LIMIT 8');
      $stmt->execute(array(User::getUserId($db, $username)));
      $menus = $stmt->fetchAll();
      foreach ($menus as $menu) {
        $temp = new Menu($menu);
        $res[] = $temp;
      }

    } catch (PDOException $e) {
      echo $e->getMessage();
    }

    return $res;


  }


  public function isMenuFavourite(int $id_menu) {

    $db = getDatabaseConnection();
    $res = array();

    try {
      $stmt = $db->prepare('SELECT * FROM Menu join Photo using (id_photo) join FavouriteMenu using (id_menu) where id_user = ? and id_menu = ? LIMIT 8');
      $stmt->execute(array($this->id_user, $id_menu));
      $menus = $stmt->fetchAll();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }

    if(empty($menus))
      return false;
    return true;


  }

  static function getUserRestaurants (PDO $db, string $username)
  {
    $res = array();

    try {
      $stmt = $db->prepare('SELECT * FROM Restaurant join Photo using (id_photo) join RestaurantOwner using (id_restaurant) where id_user = ?');
      $stmt->execute(array(User::getUserId($db, $username)));
      $restaurants = $stmt->fetchAll();
      foreach ($restaurants as $restaurant) {
        $temp = new Restaurant($restaurant);
        $res[] = $temp;
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $res;
  }

  static function getUserOrders (PDO $db, string $username) 
  {   
    
    $orders = array();

    try {
      $stmt = $db->prepare('SELECT * FROM Menu join Photo using (id_photo) join MenuInOrder using (id_menu), ORDER2 where id_user = ? and MenuInOrder.id_order = ORDER2.id_order LIMIT 8');
      $stmt->execute(array(User::getUserId($db, $username)));
      $orders = $stmt->fetchAll();
      foreach ($orders as $order) {
        $temp = new Menu($order);
        $orders[] = $temp;
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $orders;

  }
  static function insertUser(PDO $db, string $first_name, string $last_name, string $email, string $address, string $username, string $phone_number, string $password)
  : int {
    $options = ['cost' => 12];

    $stmt = $db->prepare('
			INSERT INTO User VALUES(NULL, ?, ?, ?, ?, ?, ?, ?)
			');
    $stmt->execute(array($first_name, $last_name, $email, $address, $username, $phone_number, password_hash($password, PASSWORD_DEFAULT, $options)));
    return User::getUserId($db, $username);
  }

  static function checkEmailUsernamePhoneNumber(PDO $db, ?int $id, string $email, string $username, string $phone_number): bool
  {
    $check_user = ($id)? "and (id_user <> $id)"  : ' --?';

    $id ??= 0; 
    $stmt = $db->prepare('
    SELECT *
    FROM User 
    WHERE (email = ? OR username = ? OR phone_number = ?)
    ' . $check_user);

    $stmt->execute(array($email, $username, $phone_number ));
    $user = $stmt->fetch();

    if ($user) {
      return true;
    } else return false;
  }

  public function setFirstName(?string $first_name)
  {
    if ($first_name != NULL && $first_name != $this->first_name) {
      $this->first_name = $first_name;
      $this->changedList['first_name'] = $first_name;
    }
  }

  public function setLastName(?string $last_name)
  {
    if ($last_name != NULL && $last_name != $this->last_name) {
      $this->last_name = $last_name;
      $this->changedList['last_name'] = $last_name;
    }
  }

  public function setEmail(?string $email)
  {
    if ($email != NULL && $email != $this->email) {
      $this->email = $email;
      $this->changedList['email'] = $email;
    }
  }

  public function setAddress(?string $address)
  {
    if ($address != NULL && $address != $this->address) {
      $this->address = $address;
      $this->changedList['address'] = $address;
    }
  }

  public function setUsername(?string $username)
  {
    if ($username != NULL && $username != $this->username) {
      $this->username = $username;
      $this->changedList['username'] = $username;
    }
  }

  public function setPhoneNumber(?string $phone_number)
  {
    if ($phone_number != NULL && $phone_number != $this->phone_number) {
      $this->phone_number = $phone_number;
      $this->changedList['phone_number'] = $phone_number;
    }
  }
}
