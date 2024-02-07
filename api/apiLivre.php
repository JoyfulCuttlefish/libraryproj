<?php

//Defini la charte de l'API
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, PUT, DELETE, POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//inclure la connexion a la BDD
include("../databases/connectDatabase.php");

$bdd = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $login, $password);
$variables = file_get_contents('php://input', true); 

$request_method = $_SERVER["REQUEST_METHOD"];

//Switch entre les differentes methodes CRUD
switch($request_method)
{
    case 'GET':
        if(!empty($_GET['id']))
        {
            $id = intval ($_GET["id"]);
            getLivre ($id);
        }
        elseif(!empty($_GET["page"])){
            $numeroPage = intval($_GET["page"]);
            getLivresByPage($numeroPagevariables);
        }
        else
        {
            getLivres();
        }
        break;


    case 'POST':
        addLivre();
        break;

    case 'PUT':
        if(!empty($_GET['id']))
        {
            $id = intval ($_GET["id"]);
            updateLivre ($id);
        }
        break;
     
    case 'DELETE':
        $id = intval($_GET["id"]);
        deleteLivre($id);
        break  ;  

    default:
        header("HTTP/1.0 405 Method Not Allowed");    
        break;    
}

//fonction qui récupères tous les livres (GET)
function getLivres()
  {
    global $bdd;
    $selectLivres = "SELECT * FROM livres ORDER BY titre"; //TODO : limiter le nombre d'élément retourné par la bdd, éviter les select *
    $reponse = array();
    $result = $bdd->query($selectLivres);
    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
        $reponse[] = $row;
    }
    echo json_encode($reponse, JSON_PRETTY_PRINT);

  }


//fonction qui récupères tous les livres par page (GET)  
  function getLivresByPage($numeroPage=0){
    global $bdd;
    
    if(empty($numeroPage)){
        $numeroPage=1;
}
    $LivreByPage = 5;
    $offset = ($numeroPage-1)*$LivreByPage;
//Récupère les livres
    $selectLivreByPage = "SELECT *  FROM livres LIMIT $offset, $LivreByPage";
    $selectedLivreByPage= array();
    $resultLivreByPage = $bdd->query($selectLivreByPage);
//On met le resultat de la requete dans le tableau pour afficher en JSON
    while($livresRow = $resultLivreByPage->fetchAll(PDO::FETCH_ASSOC)) 
    {
        $selectedLivreByPage[] = $livresRow;
    }
    echo json_encode($selectedLivreByPage, JSON_PRETTY_PRINT);
}  

//fonction qui récupères les livres en fonction de l'id du livre (GET(id))
function getLivre($id=0)
{
    global $bdd;
    $selectLivresid = "SELECT * FROM livres"; //TODO : limiter le nombre d'élément retourné par la bdd, éviter les select *
    if($id != 0)
    {
        $selectLivresid .= " WHERE id =".$id." LIMIT 5 ";
    }
    $reponse = array();
    $resultLivresid = $bdd->query($selectLivresid);
    while($row = $resultLivresid->fetch(PDO::FETCH_ASSOC))
    {
        $reponse[] = $row;
    }
    echo json_encode($reponse, JSON_PRETTY_PRINT);
}

//fonction qui ajoute un livre (POST)
  function addLivre()
{
    global $bdd;
   
    
    $titre = isset($_POST["titre"]); //TODO : ne pas utiliser de variable globale ($_POST) dans une fonction, passez les en paramètres
    $sorti = isset($_POST["sorti"]);
    $synopsis = isset($_POST['synopsis']);
    $pages = isset($_POST["pages"]);
    $prix = isset($_POST["prix"]);

    echo $addLivre = "INSERT INTO livres(titre,sorti, synopsis ,pages,prix) VALUES('$titre','$sorti', '$synopsis', '$pages', '$prix')";

    if ($bdd->query($addLivre)) {
        $reponse = array(
            'status' => 1,
            'status_message' => 'Livre ajouté avec succès'
        );
    } else {
        $reponse = array(
            'status' => 0,
            'status_message' => "Le livre n'a pas été ajouté."
        );
    }
    echo json_encode($reponse);
}

//fonction qui met à jour un livre (PUT)
function updateLivre($id){ //TODO : $id ne semble pas utilisé dans la fonction
    global $bdd;

    $_PUT = array();
    parse_str(file_get_contents('php://input'), $_PUT); //TODO : ne pas utiliser de variable globale ($_POST) dans une fonction, passez les en paramètres
    
    $updateTitre = isset($_PUT["titre"]);
    $updateSorti = isset($_PUT["sorti"]); //TODO : ces variables ne semblent pas utilisées.
    $updateSynopsis = isset($_PUT["synopsis"]);
    $updatePages = isset($_PUT["pages"]);
    $updatePrix = isset($_PUT["prix"]);
    $updateLivre = "UPDATE livres SET titre='".$updateTitre."', sorti='4561', synopsis='once upon', pages=451 WHERE id=17";
   
   
    if($bdd->query($updateLivre)){
        $reponse = array (
            'status' => 1,
            'status_message' => 'Le livre a été modifié.'
        );
    }
    else {
        $reponse = array(
            'status' => 0,
            'status_message' => 'Il y a eu une erreur lors de la modification.'
        );
    }
    echo json_encode($reponse);
}

//fonction qui supprime un livre (DELETE)
function deleteLivre($id)
{
    global $bdd;
    $deleteLivre = "DELETE FROM livres WHERE id=" . $id;
    if ($bdd->query($deleteLivre)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Le details à été supprimé avec succes'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Erreur.'
        );
    }
    echo json_encode($response);
}


?>
