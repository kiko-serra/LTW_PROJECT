<?php
    declare(strict_types = 1);

  function getDatabaseConnection() : PDO {
    $dbo = new PDO('sqlite:./uber.db');
    $dbo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $dbo;
  }
?>