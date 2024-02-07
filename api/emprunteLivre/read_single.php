<?php 
  // Headers; from headers to instantiate livre - same as read file
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../databases/Database.php';
  include_once '../../models/emprunteLivre.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate BorrowBook object
  $emprunteLivre = new BorrowBook($db);

  // Get ID - isset checks parameter; ? is ternary operator(like if); ':' means else
  $emprunteLivre->titreID = isset($_GET['titreID']) ? $_GET['titreID'] : die();

  // Get a single record - calls read_single method
  $emprunteLivre->read_single();

  // Create array - bc info we get is in JSON
  $emprunteLivre_arr = array(
    'titreID' => $emprunteLivre->titreID,
    'titre' => $emprunteLivre->titre,
    'auteurNom' => $emprunteLivre->auteurNom,
    'auteurPrenom' => $emprunteLivre->auteurPrenom,
    'nomAmi' => $emprunteLivre->nomAmi,
    'prenomAmi' => $emprunteLivre->prenomAmi
  );

  // Make JSON - print_r prints array,
  print_r(json_encode($emprunteLivre_arr));