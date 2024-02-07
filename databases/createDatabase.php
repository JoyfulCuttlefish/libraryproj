<?php
require('connectDatabase.php');

    $bdd = connexion($host, $login, $password);

    $livres = file_get_contents("https://filrouge.uha4point0.fr/V2/livres/livres");
    $apiLivres = json_decode($livres, true);
    
    $auteurs = file_get_contents("https://filrouge.uha4point0.fr/V2/livres/auteurs");
    $apiAuteurs = json_decode($auteurs, true);

    $sql = ("drop database if exists $db_name");
    $bdd->exec($sql);

    $sql = ("create database if not exists $db_name");
    $bdd->exec($sql);


    $bdd = connexionDB($host, $db_name, $login, $password);


    $sql = "CREATE TABLE IF NOT EXISTS auteurs (
        `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE,
        `nom` varchar(28),
        `prenom` varchar(28),
        `naissance` varchar(28),
        `mort` varchar(28),
        `biographie` TEXT,
        `photo` TEXT
        )";
    $bdd->exec($sql);
    

    $sql = "CREATE TABLE IF NOT EXISTS livres (
        `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE,
        `titre` varchar(255),
        `sorti` int(11),
        `synopsis` TEXT,
        `auteur` int(11),
        `pages` int(11),
        `prix` decimal(5,2),
        FOREIGN KEY (auteur) REFERENCES auteurs(id)
        )";
    $bdd->exec($sql);


    $sql = "CREATE TABLE IF NOT EXISTS genres (
        `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `genre` varchar(11) NOT NULL UNIQUE KEY
        )";
    $bdd->exec($sql);

    
    $sql = "CREATE TABLE IF NOT EXISTS auteursGenres (
        `genreID` int(11) NOT NULL,
        `auteurID` int(11) NOT NULL,
        FOREIGN KEY (auteurID) REFERENCES auteurs(id),
        FOREIGN KEY (genreID) REFERENCES genres(id),
        CONSTRAINT KEY_AuteursGenres PRIMARY KEY(genreID, auteurID)
        )";
    $bdd->exec($sql);

//TODO : l'architecture de la table est à revoir (voir mes remarques dans confluence)
    $sql = "CREATE TABLE IF NOT EXISTS emprunteLivre (
        `titreID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE,
        `titre` varchar(150),
        `auteurNom` varchar(28),
        `auteurPrenom` VARCHAR(28),
        `nomAmi` varchar(28),
        `prenomAmi` varchar(28),
        FOREIGN KEY (titreID) REFERENCES livres(id)
        )";
    $bdd->exec($sql);
    

    foreach ($apiAuteurs as $auteur) {
        $id = htmlspecialchars($auteur['id']);
        $nom = htmlspecialchars($auteur['nom']);
        $prenom = htmlspecialchars($auteur['prenom']);
        $naissance = htmlspecialchars($auteur['naissance']);
        $mort = htmlspecialchars($auteur['mort']);
        $biographie = htmlspecialchars(strip_tags($auteur['biographie']));
        $photo = htmlspecialchars($auteur['photo']);

        $requete = $bdd->prepare("INSERT IGNORE INTO auteurs (id, nom, prenom, naissance, mort, biographie, photo) VALUES (:id, :nom, :prenom, :naissance, :mort, :biographie, :photo)");
        $requete->execute(array(
            'id' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'naissance' => $naissance,
            'mort' => $mort,
            'biographie' => $biographie,
            'photo' => $photo
        ));
    }


    foreach ($apiLivres as $livre) {
        $id = htmlspecialchars($livre['id']);
        $titre = htmlspecialchars(strip_tags($livre['titre']));
        $sorti = htmlspecialchars($livre['sorti']);
        $synopsis = htmlspecialchars(strip_tags($livre['synopsis']));
        $auteur = htmlspecialchars($livre['auteur']);
        $pages = htmlspecialchars($livre['pages']);
        $prix = htmlspecialchars($livre['prix']);

        $requete = $bdd->prepare("INSERT INTO livres (id, titre, sorti, synopsis, auteur, pages, prix) VALUES (:id, :titre, :sorti, :synopsis, :auteur, :pages, :prix)");
        $requete->execute(array(
            'id' => $id,
            'titre' => $titre,
            'sorti' => $sorti,
            'synopsis' => $synopsis,
            'auteur' => $auteur,
            'pages' => $pages,
            'prix' => $prix
        ));
    }


    foreach ($apiAuteurs as $auteur) {
        foreach($auteur['genres'] as $genre) {
            $requete = $bdd->prepare('INSERT IGNORE INTO genres(genre) VALUES(:genres)');
            $requete->execute(array(
                'genres' =>htmlspecialchars($genre)
            ));
        }   
    }


    foreach($apiAuteurs as $auteur) {
        foreach($auteur['genres'] as $genre) {
            $sql = "SELECT id FROM genres WHERE genre = :genre";
            $requete = $bdd->prepare($sql);
            $requete->execute(array(
                ':genre' =>htmlspecialchars($genre)));
                $genreID = $requete->fetch();
            
            $sql ="INSERT INTO auteursGenres(genreID, auteurID) VALUES (:genreID, :auteurID)";
            $requete = $bdd->prepare($sql);
            $requete->execute(array(
                ':genreID'=>htmlspecialchars($genreID['id']),
                ':auteurID'=>htmlspecialchars($auteur['id'])));
        }   
    }

    $sql =("INSERT INTO emprunteLivre (titre, auteurNom, auteurPrenom, nomAmi, prenomAmi) VALUES
   ('Great Expectations', 'Dickens', 'Charles', 'Collins', 'Jennifer'),
   ('Notre Dame', 'Dickens', 'Charles', 'Schmidt', 'Amélie'),
   ('Les trois mousquetaires', 'Dickens', 'Charles', 'Adams', 'Ben'),
   ('L\'isle mystérieuse', 'Verne', 'Jules', 'Federer', 'Nicolas'),
   ('Wuthering Heights', 'Bronte', 'Emily', 'Kerner', 'Debra'),
   ('Frankenstein', 'Shelley', 'Mary', 'Collins', 'Jennifer'),
   ('Meine kleine Schmetterling', 'Muller', 'Heike', 'Braun', 'Marla')
    ");
   $bdd->exec($sql);   


        $requete->closeCursor();
  
header("location: ../index.php");
?>