<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../databases/Database.php';
  include_once '../../models/emprunteLivre.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate BorrowBook object
  $emprunteLivre = new BorrowBook($db);

  // Get raw posted data - id
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update - delete
  $emprunteLivre->titreID = $data->titreID;

  // Delete BorrowBook record
  if($emprunteLivre->delete()) {
    echo json_encode(
      array('message' => 'Le livre marqué emprunté a été supprimé') //TODO : dommage que ce message ne soit pas affiché pour l'utilisateur
    );
  } else {
    echo json_encode(
      array('message' => 'Le livre marqué emprunté n\'a pas été supprimé')
    );
  }

