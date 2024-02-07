<?php 
  class Database {
    // DB Params - private - only available in class Database
    private $host = 'localhost';
    private $db_name = 'webibliotheque';
    private $login = 'root';
    private $password = '';
    private $conn;

    // DB Connect - method to connect
    // $this->conn creates new PDO object (contains connect info: host etc)
    //PDO has DSN = database type (mysql) & host (+ login info)
    //mysql:host= . $this->host . (those dots mean concatenate info)
    //PDO exception parameter variable e, exception var
    public function connect() {
      $this->conn = null;

      try { 
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->login, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }
  }