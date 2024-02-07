<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../databases/Database.php';
  include_once '../../models/emprunteLivre.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate BorrowBook object
  $emprunteLivre = new BorrowBook($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $emprunteLivre->titreID = $data->titreID;

  $emprunteLivre->titre = $data->titre;
  $emprunteLivre->auteurNom = $data->auteurNom;
  $emprunteLivre->auteurPrenom = $data->auteurPrenom;
  $emprunteLivre->nomAmi = $data->nomAmi;
  $emprunteLivre->prenomAmi = $data->prenomAmi;

  // Update record
  if($emprunteLivre->update()) {
    echo json_encode(
      array('message' => 'Observation modifié') //TODO : dommage que ce message ne soit pas affiché pour l'utilisateur. Qu'est-ce qu'une Objservation ?
    );
  } else {
    echo json_encode(
      array('message' => 'Observation non modifié')
    );
  }

