<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="livres.css">
		<script src="livres.js"></script>
		<title>Livres</title>
	</head>
	
    <body>

	    <?php
         include ('includes/nav.php');
         require('databases/connectDatabase.php');
    
        $bdd = connexionDB($host,$db_name,$login,$password);

     	/*$requete= $bdd->prepare("SELECT l.titre,l.sorti, l.synopsis, l.pages, l.prix, a.id, a.nom, a.prenom
        FROM livres AS l
	 	LEFT JOIN auteurs AS a 
	 	ON l.auteur = a.id GROUP BY `titre`");*/ //TODO : le GROUP BY est inutile et peut poser problème
        //TODO : correction
        $requete= $bdd->prepare("SELECT l.titre,l.sorti, l.synopsis, l.pages, l.prix, a.id, a.nom, a.prenom 
        FROM livres AS l
	 	LEFT JOIN auteurs AS a 
	 	ON l.auteur = a.id"); //TODO : limiter la quantité d'information envoyée par la BDD
     	$requete->execute();
     	$requete = $requete->fetchAll();	 

		?>

		<div class="imagelibrary">
		<img src="Images/AustriaGoettweigAbbey.jpg" alt="Photo de la bibliothèque de l'abbaye de Gottweig en Autriche" title="Abbaye de Goettweig en Autriche" />
		</div>
			<!--TODO : attention à l'indentation -->
			<h1>Livres</h1>
				<div class="intro">
				<p>Voici la liste des livres dans ma bibliothèque dans l'ordre alphabétique. Parcours la liste des titres ou choisis un genre du livre dans le menu.</p>
				</div>

				<div class="main">
					<div class = "dropdownList">
						<button class="dropdownButton" onclick="showList()"> Choisis Genre </button>
						<div id="genreID" class="genres">
							<a href="drame.php">drame</a>
							<a href="fiction.php">fiction</a>
							<a href="poesie.php">poésie</a>
							<a href="theatre.php">théatre</a>
							<a href="policier.php">policier</a>
						</div>
					</div>
				</div>

				<div>
					<?php 
					foreach ($requete as $livre) {
					
					?>		   
					<section class = "book">

						<h2><a href="auteurs.php" target="_blank"><?= $livre["titre"]?></a></h2>
						<div>
                            <p>par <?= $livre["prenom"]?> <?= $livre["nom"]?></p>
							<p>Année de parution : <?= $livre['sorti']?></p>
                        	<p>Pages : <?= $livre['pages']?></p>
                        	<p>Synopsis: <?= $livre['synopsis']?></p>
                        	<p>Prix : €<?= $livre['prix']?></p>
                        </div>

    				</section>
		<?php } ?>
    			</div>
		
	</body>
</html>
