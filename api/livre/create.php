<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../databases/Database.php';
  include_once '../../models/Livre.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate livre object
  $livre = new Livre($db);

  // Get raw posted data - gets info that was submitted
  $data = json_decode(file_get_contents("php://input"));

  $livre->titre = $data->titre; 
  $livre->synopsis = $data->synopsis;  
  
  $livre->pages = $data->pages;
  $livre->prix = $data->prix;

  // Create post
  if($livre->create()) {
    echo json_encode(
      array('message' => 'Livre créé')
    );
  } else {
    echo json_encode(
      array('message' => 'Livre non créé')
    );
  }

