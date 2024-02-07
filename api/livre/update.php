<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../databases/Database.php';
  include_once '../../models/Livre.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate livre object
  $livre = new Livre($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $livre->id = $data->id;

  $livre->titre = $data->titre;
  $livre->sorti = $data->sorti;
  $livre->synopsis = $data->synopsis;
  $livre->pages = $data->pages;
  $livre->prix = $data->prix;

  // Update livre
  if($livre->update()) {
    echo json_encode(
      array('message' => 'Livre modifié')
    );
  } else {
    echo json_encode(
      array('message' => 'Livre non modifié')
    );
  }

