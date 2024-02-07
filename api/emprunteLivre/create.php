<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../databases/Database.php';
  include_once '../../models/emprunteLivre.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate BorrowBook object
  $emprunteLivre = new BorrowBook($db);

  // Get raw posted data - gets info that was submitted
  $data = json_decode(file_get_contents("php://input"));

  $emprunteLivre->titre = $data->titre;
  $emprunteLivre->auteurNom = $data->auteurNom;  
  $emprunteLivre->auteurPrenom = $data->auteurPrenom;  
  $emprunteLivre->nomAmi = $data->nomAmi;
  $emprunteLivre->prenomAmi = $data->prenomAmi;

  // Create post
  if($emprunteLivre->create()) {
    echo json_encode(
      array('message' => 'Ton livre est marqué emprunté. Merci!') //TODO : dommage que ce message ne soit pas affiché pour l'utilisateur
    );
  } else {
    echo json_encode(
      array('message' => 'Ton livre n\'est pas marqué emprunté..')
    );
  }

