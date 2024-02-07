<?php 
  // Headers; from headers to instantiate livre - same as read file
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../databases/Database.php';
  include_once '../../models/Livre.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $livre = new Livre($db);

  // Get ID - isset checks parameter; ? is ternary operator(like if); ':' means else
  $livre->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get livre - calls read_single method
  $livre->read_single();

  // Create array - bc info we get is in JSON
  $livre_arr = array(
    'id' => $livre->id,
    'titre' => $livre->titre,
    'sorti' => $livre->sorti,
    'synopsis' => $livre->synopsis,
    'auteur' => $livre->auteur,
    'pages' => $livre->pages,
    'prix' => $livre->prix
  );

  // Make JSON - print_r prints array,
  print_r(json_encode($livre_arr));