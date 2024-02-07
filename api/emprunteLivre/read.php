<?php 
  // Headers(functions)
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  //../../ = up 2 directories, Database.php = connect to db,pdo, model post gets db data
  include_once '../../databases/Database.php';
  include_once '../../models/emprunteLivre.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate BorrowBook object (put in db object)
  $emprunteLivre = new BorrowBook($db);

  // BorrowBook query - reads table
  $result = $emprunteLivre->read();
  // Get row count - method
  $num = $result->rowCount();

  // Check if any records in table - check num = records,
  if($num > 0) {
    // emprunteLivres array - initialised, will help pages later
    $emprunteLivres_arr = array();
    $emprunteLivres_arr['data'] = array();

    //can fetch as different things, here associative array
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $emprunteLivre_item = array(
        'titreID' => $titreID,
        'titre' =>htmlspecialchars($titre),
        'auteurNom' => $auteurNom,
        'auteurPrenom' => htmlspecialchars($auteurPrenom),
        'nomAmi' => $nomAmi,
        'prenomAmi' => $prenomAmi
      );

      // Push to "data", php method, takes array and item
      //array_push($livres_arr, $livre_item);
       array_push($emprunteLivres_arr['data'], $emprunteLivre_item);
    }

    // - now outside loop - Turn to JSON & output
    echo json_encode($emprunteLivres_arr);

  } else {
    // No livres - if num = 0
    echo json_encode(
      array('message' => 'Pas de livre emprunté')
    );
  }
