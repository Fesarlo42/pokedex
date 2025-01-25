<?php
/**
 * Connects to the database
 * Is an extension of the PDO class
 */

class DatabaseConnection extends PDO {
    protected $conexion;

    public function __construct() {
        $this->conexion = new PDO('mysql:host=' . Config::$db_hostname . ';dbname=' . Config::$db_name . '', Config::$db_user, Config::$db_pass);
        // Connects to the databse with the utf-8 charset
        $this->conexion->exec("set names utf8");
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

}

?>