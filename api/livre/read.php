<?php 
  // Headers(functions)
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  //../../ = up 2 directories, Database.php = connect to db,pdo, model post gets db data
  include_once '../../databases/Database.php';
  include_once '../../models/Livre.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate livre object (put in db object)
  $livre = new Livre($db);

  // Livre query - reads
  $result = $livre->read();
  // Get row count - method
  $num = $result->rowCount();

  // Check if any livres - check num = livres,
  if($num > 0) {
    // Livres array - initialised, will help pages later
    $livres_arr = array();
    $livres_arr['data'] = array();

    //can fetch as different things, here associative array
    while($row = $result->fetch(PDO::FETCH_ASSOC)) { //TODO : utilise fetch_all
      extract($row);

      $livre_item = array(
        'id' => $id,
        'titre' => $titre,
        'sorti' => $sorti,
        'synopsis' => htmlspecialchars($synopsis),
        'auteur' => $auteur,
        'pages' => $pages,
        'prix' => $prix
      );

      // Push to "data", php method, takes array and item
      //array_push($livres_arr, $livre_item);
       array_push($livres_arr['data'], $livre_item);
    }

    // - now outside loop - Turn to JSON & output
    echo json_encode($livres_arr);

  } else {
    // No livres - if num = 0
    echo json_encode(
      array('message' => 'Pas de livre')
    );
  }
