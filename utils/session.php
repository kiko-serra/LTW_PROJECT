<?php

require_once(__DIR__ . "/../database/menu.php");

class Session
{
  private array $messages;
  private array $orders;

  public function __construct()
  {
    session_start();
    $this->orders = isset($_SESSION['orders']) ? $_SESSION['orders'] : array();
    $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
    unset($_SESSION['messages']);
  }

  public function isLoggedIn(): bool
  {
    return isset($_SESSION['id']);
  }

  public function logout()
  {
    session_destroy();
  }

  public function addOrder(int $id_menu)
  {
    $_SESSION['orders'][] = $id_menu;
  }
  public function removeOrder(int $id_menu)
  {
    $key = array_search($id_menu, $_SESSION['orders']);
    if ($key !== false) {
      unset($_SESSION['orders'][$key]);
    }
  }
  public function getId(): ?int
  {
    return isset($_SESSION['id']) ? $_SESSION['id'] : null;
  }

  public function getName(): ?string
  {
    return isset($_SESSION['name']) ? $_SESSION['name'] : null;
  }

  public function setId(int $id)
  {
    $_SESSION['id'] = $id;
  }

  public function setName(string $name)
  {
    $_SESSION['name'] = $name;
  }

  public function addMessage(string $type, string $text)
  {
    $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
  }

  public function currentOrders()
  {
    return $this->orders;
  }
  public function getMessages()
  {
    return $this->messages;
  }
}
