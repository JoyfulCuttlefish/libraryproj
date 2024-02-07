<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: "application/json"');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include("../databases/connectDatabase.php");


$bdd = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $login, $password);
$variables = file_get_contents('php://input', true); 

$request_method= $_SERVER["REQUEST_METHOD"];

switch($request_method)
{
    case 'GET':
        if (!empty($_GET['titreID'])) 
        {
            $titreID = intval($_GET["titreID"]);
            getEmprunteLivre($titreID);
        }
        else if (!empty($_GET['page'])){
            $page = intval($_GET['page']);
           getEmprunteLivresByPage($page);
        } 
        else 
        {
            getEmprunteLivres();
        } break;
        default:
    
        header("HTTP//1.0 405 Method Not Allowed");
        break;

    case 'POST':
        addEmprunteLivre();
        break;

    case 'PUT':
        $variables = json_decode($variables, true);

        $titreID = $variables["titreID"];
        updateEmprunteLivre($titreID);
        break;   

    case 'DELETE':
        $variables = json_decode($variables, true);

        $titreID = $variables["titreID"];
        deleteEmprunteLivre($titreID);
    break;
}
function getEmprunteLivresByPage($page=0){
    global $bdd; //TODO : éviter les variables globales, passe les en paramètres de ta fonction
    if(empty($page)){
        $page=1;
    }
    $getPage = 5;
    $offSet = ($page-1)*$getPage;

    $selectEmprunteLivrePage = "SELECT * FROM emprunteLivre LIMIT $offSet, $getPage";
    $selectedEmprunteLivrePage= array();
    //Stock le resultat de la requête selectEmprunteLivrePage.
    $resultEmprunteLivrePage = $bdd->query($selectEmprunteLivrePage);
    //On met le resultat de la requete dans le tableau pour afficher en JSON
    while($emprunteLivreRow = $resultEmprunteLivrePage->fetchAll(PDO::FETCH_ASSOC))
    {
        $selectedEmprunteLivrePage[] = $emprunteLivreRow;
    }
    echo json_encode($selectedEmprunteLivrePage, JSON_PRETTY_PRINT);
}
function getEmprunteLivres()
{ 
    global $bdd; //TODO : éviter les variables globales, passe les en paramètres de ta fonction
    $sql = $bdd->query("SELECT * FROM emprunteLivre");
    $api = $sql->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($api, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);      
}
function getEmprunteLivre($titreID=0)
{
    global $bdd; //TODO : éviter les variables globales, passe les en paramètres de ta fonction
    if($titreID != 0) {
        $sql = $bdd->query("SELECT * FROM emprunteLivre WHERE titreID = $titreID");
        $emprunteLivre = $sql->fetch(PDO::FETCH_ASSOC);
    }
    else{
        $sql = $bdd->query("SELECT * FROM emprunteLivre");
        $emprunteLivre = $sql->fetch(PDO::FETCH_ASSOC);
    }
    if($emprunteLivre) {
        echo json_encode($emprunteLivre, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);   
    }
    else {
        echo "Aucune données !";
    }
}


function addEmprunteLivre() 
{
    global $bdd; //TODO : éviter les variables globales, passe les en paramètres de ta fonction
    global $variables;//TODO : éviter les variables globales, passe les en paramètres de ta fonction

    $variables = json_decode($variables, true);

    if(!isset($variables["titre"]) || !isset($variables["auteurNom"]) || !isset($variables["auteurPrenom"]) || !isset($variables["nomAmi"]) || !isset($variables["prenomAmi"])) return;


    $titre = $variables['titre'];
    $auteurNom = $variables['auteurNom'];
    $auteurPrenom = $variables['auteurPrenom'];
    $nomAmi = $variables['nomAmi'];
    $prenomAmi = $variables['prenomAmi'];

    $addEmprunteLivre = $bdd -> prepare('INSERT INTO emprunteLivre(titre, auteurNom, auteurPrenom, nomAmi, prenomAmi) VALUES(:titre, :auteurNom, :auteurPrenom, :nomAmi, :prenomAmi)');
    $addEmprunteLivre -> bindValue('titre', $titre);
    $addEmprunteLivre -> bindValue('auteurNom', $auteurNom);
    $addEmprunteLivre -> bindValue('auteurPrenom', $auteurPrenom);
    $addEmprunteLivre -> bindValue('nomAmi', $nomAmi);
    $addEmprunteLivre -> bindValue('prenomAmi', $prenomAmi);

    $addEmprunteLivre -> closeCursor();

    $result = $addEmprunteLivre -> execute();

     if ($result) {
        $result = array(
            'status' => 1,
            'status_message' => "Le livre emprunté a été ajouté avec succès.",
            
        );
    } else {
        $result = array(
            'status' => 0,                                      
            'status_message' => "Il y a eu une erreur lors de l'ajout !."
        );
    }
    echo json_encode($result);
}


function updateEmprunteLivre($titreID)
 {
    global $bdd; //TODO : éviter les variables globales, passe les en paramètres de ta fonction
    global $variables; //TODO : éviter les variables globales, passe les en paramètres de ta fonction

    if(!isset($variables["titreID"]) || !isset($variables["titre"]) || !isset($variables["auteurNom"]) || !isset($variables["auteurPrenom"]) || !isset($variables["nomAmi"]) || !isset($variables["prenomAmi"])) return;

    $titre = htmlspecialchars($variables['titre']);
    $auteurNom = htmlspecialchars($variables['auteurNom']);
    $auteurPrenom = htmlspecialchars($variables['auteurPrenom']);
    $nomAmi = htmlspecialchars($variables['nomAmi']);
    $prenomAmi = htmlspecialchars($variables['prenomAmi']);
   
    $updateEmprunteLivre = $bdd -> prepare('UPDATE emprunteLivre SET titre = :titre, auteurNom = :auteurNom, auteurPrenom = :auteurPrenom, nomAmi = :nomAmi, prenomAmi = :prenomAmi WHERE titreID = :titreID ');
    $updateEmprunteLivre -> bindValue('titreID', $titreID, PDO::PARAM_INT);
    $updateEmprunteLivre -> bindValue('titre', $titre);
    $updateEmprunteLivre -> bindValue('auteurNom', $auteurNom);
    $updateEmprunteLivre -> bindValue('auteurPrenom', $auteurPrenom);
    $updateEmprunteLivre -> bindValue('nomAmi', $nomAmi);
    $updateEmprunteLivre -> bindValue('prenomAmi', $prenomAmi);

    $updateEmprunteLivre -> closeCursor();

    $result = $updateEmprunteLivre -> execute();
    if ($result) {
        $result = array(
            'status' => 1,
            'status_message' => "Le livre a été modifié avec succès."
        );
    } else {
        $result = array(
            'status' => 0,
            'status_message' => "Il y a eu une erreur lors de la modification !."
        );
    }
    echo json_encode($result);
}

function deleteEmprunteLivre($titreID) 
{ 
    global $bdd; //TODO : éviter les variables globales, passe les en paramètres de ta fonction
     $deleteEmprunteLivre = "DELETE FROM emprunteLivre WHERE titreID =" . $titreID;
     
     if ($DeleteEmprunteLivre  = $bdd->query($deleteEmprunteLivre)) { //TODO : la variabel $DeleteEmprunteLivre ne semble pas utlisé : éviter de déclarer une variable dans une condition
        $result = array(
            'status' => 1,
            'status_message' => 'Le livre a été supprimé avec succes'
        );
    } else {
        $result = array(
            'status' => 0,
            'status_message' => 'Il y a eu une ERREUR lors de la suppression!.'
        );
    }
    echo json_encode($result);
}
?>
