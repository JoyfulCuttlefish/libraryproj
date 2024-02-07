<?php 
  class BorrowBook {
    // DB connection, table access
    private $conn;
    private $table = 'emprunteLivre';

    // Livre Properties, initialises variables
    public $titreID;
    public $titre;
    public $auteurNom;
    public $auteurPrenom;
    public $nomAmi;
    public $prenomAmi;

    // Constructor with DB - method(fx within class) runs automatically when class instantiated
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get BorrowBook data - method
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table .''; //TODO : limiter le nombre d'éléments retournés par la BDD
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single BorrowBook
    public function read_single() {
          // Create query, use ? bc using bind param, limit 1 bc getting 1 record
          $query = 'SELECT * FROM ' . $this->table . ' e
                                    WHERE
                                      e.titreID = ?
                                    LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID to ? above, positional parameter, 1st param binds to id
          $stmt->bindParam(1, $this->titreID);

          // Execute query
          $stmt->execute();

          //fetches 1 row, 1 entry for livres
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->titreID = $row['titreID'];
          $this->titre = $row['titre'];
          $this->auteurNom = $row['auteurNom'];
          $this->auteurPrenom = $row['auteurPrenom'];
          $this->nomAmi = $row['nomAmi'];
          $this->prenomAmi = $row['prenomAmi'];
 
    }

    // Create BorrowBook
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' 
            SET titre = :titre, auteurNom = :auteurNom, auteurPrenom = :auteurPrenom, nomAmi = :nomAmi, prenomAmi = :prenomAmi';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->titre = htmlspecialchars(strip_tags($this->titre));
          $this->auteurNom = htmlspecialchars(strip_tags($this->auteurNom));
          $this->auteurPrenom = htmlspecialchars(strip_tags($this->auteurPrenom));
          $this->nomAmi = htmlspecialchars(strip_tags($this->nomAmi));
          $this->prenomAmi = htmlspecialchars(strip_tags($this->prenomAmi));

          // Bind data
          $stmt->bindParam(':titre', $this->titre);
          $stmt->bindParam(':auteurNom', $this->auteurNom);
          $stmt->bindParam(':auteurPrenom', $this->auteurPrenom);
          
          $stmt->bindParam(':nomAmi', $this->nomAmi);
          $stmt->bindParam(':prenomAmi', $this->prenomAmi);

          // Execute query , if it executes it adds BorrowBook as expected
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong, %s - placeholder, adds error msg
      printf("Error: %s.\n", $stmt->error); //TODO : peu d'intérêt pour les utilisateurs, utilise un logger ou retourne le message dans la fonction

      return false;
    }

    // Update BorrowBook
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET titre = :titre, auteurNom = :auteurNom, auteurPrenom = :auteurPrenom, nomAmi = :nomAmi, prenomAmi = :prenomAmi
                                WHERE titreID = :titreID';
                                

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->titreID = htmlspecialchars(strip_tags($this->titreID));
          $this->titre = htmlspecialchars(strip_tags($this->titre));
          $this->auteurNom = htmlspecialchars(strip_tags($this->auteurNom));
          $this->auteurPrenom = htmlspecialchars(strip_tags($this->auteurPrenom));
          $this->nomAmi = htmlspecialchars(strip_tags($this->nomAmi));
          $this->prenomAmi = htmlspecialchars(strip_tags($this->prenomAmi));


          // Bind data
          $stmt->bindParam(':titreID', $this->titreID);
          $stmt->bindParam(':titre', $this->titre);
          $stmt->bindParam(':auteurNom', $this->auteurNom);
          $stmt->bindParam(':auteurPrenom', $this->auteurPrenom);
          $stmt->bindParam(':nomAmi', $this->nomAmi);
          $stmt->bindParam(':prenomAmi', $this->prenomAmi);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);  //TODO : peu d'intérêt pour les utilisateurs, utilise un logger ou retourne le message dans la fonction

          return false;
    }

    // Delete BorrowBook record
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE titreID = :titreID';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->titreID = htmlspecialchars(strip_tags($this->titreID));

          // Bind data
          $stmt->bindParam(':titreID', $this->titreID);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);  //TODO : peu d'intérêt pour les utilisateurs, utilise un logger ou retourne le message dans la fonction

          return false;
    }
    
  }