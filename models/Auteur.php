<?php 
  class Auteur { //TODO : cette classe ne semble pas utilisée
    // DB connection, table access
    private $conn;
    private $table = 'auteurs';

    // Auteur Properties, initialises variables
    public $id;
    public $nom;
    public $prenom;
    public $naissance;
    public $mort;
    public $biographie;
    public $photo;

    // Constructor with DB - method(fx within class) runs automatically when class instantiated
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Auteur - method
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table . '';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Auteur
    public function read_single() {
          // Create query, use ? bc using bind param, limit 1 bc getting 1 record
          $query = 'SELECT * FROM ' . $this->table . ' a
                                    WHERE
                                      a.id = ?
                                    LIMIT 0,1';
      
          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID to ? above, positional parameter, 1st param binds to id
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          //fetches 1 row, 1 entry for auteurs
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->id = $row['id'];
          $this->nom = $row['nom'];
          $this->prenom = $row['prenom'];
          $this->naissance = $row['naissance'];
          $this->mort = $row['mort'];
          $this->biographie = $row['biographie'];
          $this->photo = $row['photo'];
 
    }

    // Create Auteur
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' 
            SET nom = :nom, prenom = :prenom, naissance = :naissance, mort = :mort, biographie = :biographie, photo = :photo';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->nom = htmlspecialchars(strip_tags($this->nom));
          $this->prenom = htmlspecialchars(strip_tags($this->prenom));
          $this->naissance = htmlspecialchars(strip_tags($this->naissance));
        
          $this->mort = htmlspecialchars(strip_tags($this->mort));
          $this->biographie = htmlspecialchars(strip_tags($this->biographie));
          $this->photo = htmlspecialchars(strip_tags($this->photo));

          // Bind data
          $stmt->bindParam(':nom', $this->nom);
          $stmt->bindParam(':prenom', $this->prenom);
          $stmt->bindParam(':naissance', $this->naissance);
          
          $stmt->bindParam(':mort', $this->mort);
          $stmt->bindParam(':biographie', $this->biographie);
          $stmt->bindParam(':photo', $this->photo);

          // Execute query , if it executes it adds auteur as expected
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong, %s - placeholder, adds error msg
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Auteur
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
          SET nom = :nom, prenom = :prenom, naissance = :naissance, mort = :mort, biographie = :biographie, photo = :photo
          WHERE id = :id';
                                

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));
          $this->nom = htmlspecialchars(strip_tags($this->nom));
          $this->prenom = htmlspecialchars(strip_tags($this->sorti));
          $this->naissance = htmlspecialchars(strip_tags($this->synopsis));
          $this->mort  = htmlspecialchars(strip_tags($this->pages));
          $this->biographie = htmlspecialchars(strip_tags($this->biographie));
          $this->photo = htmlspecialchars(strip_tags($this->photo));


          // Bind data
          $stmt->bindParam(':id', $this->id);
          $stmt->bindParam(':nom', $this->nom);
          $stmt->bindParam(':prenom', $this->prenom);
          $stmt->bindParam(':naissance', $this->naissance);
          $stmt->bindParam(':mort', $this->mort);
          $stmt->bindParam(':biographie', $this->biographie);
          $stmt->bindParam(':photo', $this->photo);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete Auteur
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