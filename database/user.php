<?php

declare(strict_types=1);

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
    /*
    $stmt = $db->prepare('
    UPDATE User 
    SET first_name = ?, last_name = ?, email = ?, address = ?, username = ?, phone_number = ? 
    WHERE id_user = ?
    ');
    $stmt->execute(array($this->first_name, $this->last_name, $this->email, $this->address, $this->username, $this->phone_number, $this->id_user));
    */
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
