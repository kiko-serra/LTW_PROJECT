<?php
  declare(strict_types = 1);

  class User {
    public int $id_user;
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $address;
    public string $username;
    public string $phone_number;

    public function __construct(int $id_user, string $first_name, string $last_name, string $email, string $address, string $username, string $phone_number){
      $this->id_user = $id_user;
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->email = $email;
      $this->address = $address;
      $this->username = $username;
      $this->phone_number = $phone_number;
    }

    function name() {
      return $this->first_name . ' ' . $this->last_name;
    }

    function save($db) {
      $stmt = $db->prepare('
        UPDATE User SET first_name = ?, last_name = ?
        WHERE id_user = ?
      ');

      $stmt->execute(array($this->first_name, $this->last_name, $this->id_user));
    }
    
    static function getUserWithPassword(PDO $db, string $username, string $password) : ?User {
			$stmt = $db->prepare('
			SELECT id_user, first_name, last_name, email, address, username, phone_number
			FROM User 
			WHERE username = ? AND password = ?
      ');

      $stmt->execute(array($username, $password));
      

      if ($user = $stmt->fetch()) {
				return new User(
					intval($user['id_user']),
          $user['first_name'],
          $user['last_name'],
          $user['email'],
          $user['address'],
          $user['username'],
          $user['phone_number']
        );
      } else return null;
    }

    static function getUser(PDO $db, int $id_user) : User {
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

		static function insertUser(PDO $db, string $username, string $password) {
	
			$options = ['cost' => 12];
	
			$stmt = $db->prepare('
			INSERT INTO User VALUES(?, ?)
			');
			$stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT, $options)));
		}
  }


?>