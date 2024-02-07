<?php 
  class Livre {
    // DB connection, table access
    private $conn;
    private $table = 'livres';

    // Livre Properties, initialises variables
    public $id;
    public $titre;
    public $sorti;
    public $synopsis;
    public $auteur;
    public $pages;
    public $prix;

    // Constructor with DB - method(fx within class) runs automatically when class instantiated
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Livres - method
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table . ' l
                    ORDER BY l.titre'; //TODO : limiter le nombre d'éléments retournés par la BDD
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Livre
    public function read_single() {
          // Create query, use ? bc using bind param, limit 1 bc getting 1 record
          $query = 'SELECT * FROM ' . $this->table . ' l
                                    WHERE
                                      l.id = ?
                                    LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID to ? above, positional parameter, 1st param binds to id
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          //fetches 1 row, 1 entry for livres
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->id = $row['id'];
          $this->titre = $row['titre'];
          $this->sorti = $row['sorti'];
          $this->synopsis = $row['synopsis'];
          $this->auteur = $row['auteur'];
          $this->pages = $row['pages'];
          $this->prix = $row['prix'];
 
    }

    // Create Livre
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' 
            SET titre = :titre, synopsis = :synopsis, pages = :pages, prix = :prix';

          // Prepare statement
          $stmt = $this->conn->prepare($query);
          

          // Bind data
          $stmt->bindParam(':titre', $this->titre);
          $stmt->bindParam(':synopsis', $this->synopsis);
          
          $stmt->bindParam(':pages', $this->synopsis);
          $stmt->bindParam(':prix', $this->synopsis);

        

          // Execute query , if it executes it adds livre as expected
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong, %s - placeholder, adds error msg
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Livre
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET titre = :titre, sorti = :sorti, synopsis = :synopsis, pages = :pages, prix = :prix
                                WHERE id = :id';
                                

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));
          $this->titre = htmlspecialchars(strip_tags($this->titre));
          $this->sorti = htmlspecialchars(strip_tags($this->sorti));
          $this->synopsis = htmlspecialchars(strip_tags($this->synopsis));
          $this->pages = htmlspecialchars(strip_tags($this->pages));
          $this->prix = htmlspecialchars(strip_tags($this->prix));


          // Bind data
          $stmt->bindParam(':id', $this->id);
          $stmt->bindParam(':titre', $this->titre);
          $stmt->bindParam(':sorti', $this->sorti);
          $stmt->bindParam(':synopsis', $this->synopsis);
          $stmt->bindParam(':pages', $this->pages);
          $stmt->bindParam(':prix', $this->prix);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete Livre
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
    
  }