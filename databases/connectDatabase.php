<?php
$host="localhost";
$db_name="webibliotheque";
$login="root";
$password="12345678"; //TODO : indiquer qu'il faut modifier ce fichier

function connexion($host,$login,$password){
    try
    {     
        $bdd = new PDO("mysql:host=$host;charset=utf8", $login, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }
}

function connexionDB($host,$db_name,$login,$password){
    try
    {     
        $bdd = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $login, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;

    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }
}


