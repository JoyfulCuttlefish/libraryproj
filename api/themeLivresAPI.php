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
        if (!empty($_GET['id'])) 
        {
            $id = intval($_GET["id"]);
            getLivre($id);
        }
        else if (!empty($_GET['page'])){
            $page = intval($_GET['page']);
           getLivresByPage($page);
        } 
        else 
        {
            getLivres();
        } 
        break;
        default:
    
        header("HTTP//1.0 405 Method Not Allowed");
        break;

    case 'POST':
        addLivre();
        break;

    case 'PUT':
        $variables = json_decode($variables, true);
        $id = $variables["id"];
        updateLivre($id);
        break;  

    case 'DELETE':
        $variables = json_decode($variables, true);
        $id = $variables["id"];
        deleteLivre($id);
    break;
}
function getLivresByPage($page=0){
    global $bdd;
    if(empty($page)){
        $page=1;
    }
    $getPage = 5;
    $offSet = ($page-1)*$getPage;

    $selectLivrePage = "SELECT * FROM livres LIMIT $offSet, $getPage";
    $selectedLivrePage= array();
    //Le resultat de la requête dans le tableau pour afficher en JSON - selectLivrePage.
    $resultLivrePage = $bdd->query($selectLivrePage);
    //On met le resultat de la requete dans le tab$id = intval($variables["id"]);leau pour afficher en JSON
    while($livreRow = $resultLivrePage->fetchAll(PDO::FETCH_ASSOC))
    {
        $selectedLivrePage[] = $livreRow;
    }
    echo json_encode($selectedLivrePage, JSON_PRETTY_PRINT);
}
function getLivres()
{ 
    global $bdd;
    $sql = $bdd->query("SELECT * FROM livres ORDER BY titre"); //TODO : voir mes remarques précédentes
    $api = $sql->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($api, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);      
}
function getLivre($id=0)
{
    global $bdd;
    if($id != 0) {
        $sql = $bdd->query("SELECT * FROM livres WHERE id = $id"); //TODO : idem
        $livre = $sql->fetch(PDO::FETCH_ASSOC);
    }
    else{
        $sql = $bdd->query("SELECT * FROM livres"); //TODO : idem
        $livre = $sql->fetch(PDO::FETCH_ASSOC);
    }
    if($livre) {
        echo json_encode($livre, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);   
    }
    else {
        echo "Aucune données !";
    }
}

//function addLivre sends warning with any input in integer type - 
function addLivre() 
{
    global $bdd;
    global $variables;

    $variables = json_decode($variables, true);

    if(!isset($variables["titre"]) || !isset($variables["sorti"]) || !isset($variables["synopsis"]) || !isset($variables["pages"])) return;

    $titre = $variables["titre"];
    $sorti = $variables["sorti"];
    $synopsis = $variables["synopsis"];
    $pages = $variables["pages"];

    $addLivre = $bdd -> prepare('INSERT INTO livres(titre, sorti, synopsis, pages) VALUES(:titre, :sorti, :synopsis, :pages)'); //TODO : limiter la quantité d'élément retournée par la BDD
    $addLivre -> bindValue('titre', $titre);
    $addLivre -> bindValue('sorti', $sorti, PDO::PARAM_INT);
    $addLivre -> bindValue('synopsis', $synopsis);
    $addLivre -> bindValue('pages', $pages, PDO::PARAM_INT);

    $addLivre -> closeCursor();

    $result = $addLivre -> execute();

     if ($result) {
        $result = array(

            'status' => 1,
            'status_message' => "Le livre a été ajouté avec succès.",
            
        );
    } else {
        $result = array(
            'status' => 0,
            'status_message' => "Il y a eu une erreur lors de l'ajout !."
        );
    }
    echo json_encode($result);
}

function updateLivre($id)
 { 
    global $bdd;
    global $variables;    


    if(!isset($variables["id"]) || !isset($variables["titre"]) || !isset($variables["sorti"]) || !isset($variables["synopsis"]) || !isset($variables["pages"])) return;

    $titre = htmlspecialchars($variables['titre']);
    $sorti = htmlspecialchars($variables['sorti']);
    $synopsis = htmlspecialchars($variables['synopsis']);
    $pages = htmlspecialchars($variables['pages']);

    $updateLivre = $bdd -> prepare('UPDATE livres SET titre = :titre, sorti= :sorti, synopsis= :synopsis, pages=:pages WHERE id = :id ');
    
    $updateLivre -> bindValue('id', $id, PDO::PARAM_INT);
    $updateLivre -> bindValue('titre', $titre);
    $updateLivre -> bindValue('sorti', $sorti);
    $updateLivre -> bindValue('synopsis', $synopsis);
    $updateLivre -> bindValue('pages', $pages, PDO::PARAM_INT);

    $updateLivre -> closeCursor();

    $result = $updateLivre -> execute();
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

function deleteLivre($id) 
{ 
    global $bdd;
     $deleteLivre = "DELETE FROM livres WHERE id =" . $id;
     
     if ($DeleteLivre  = $bdd->query($deleteLivre)) { //TODO : même remarque que dans le fichier précédent
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
