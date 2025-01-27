<?php
/**
 * Connects to the database
 * Is an extension of the PDO class
 */

class DatabaseConnection extends PDO {
  protected $connection;

  public function __construct() {
    try {
      $this->connection = new PDO('mysql:host=' . Config::$db_hostname . ';dbname=' . Config::$db_name . '', Config::$db_user, Config::$db_pass);
      // Connects to the databse with the utf-8 charset
      $this->connection->exec("set names utf8");
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      error_log("Connection failed: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
    }
      
  }

}

?>