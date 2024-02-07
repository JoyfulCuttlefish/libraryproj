<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
     	<meta name="viewport" content="width=device-width, initial-scale=1.0">
     	<title>Livres - poésie</title>
     	<link rel="stylesheet" href="livres.css">
 	</head>

    <body>

	    <?php
         include ('includes/nav.php');
         require('databases/connectDatabase.php');
    

        $bdd = connexionDB($host,$db_name,$login,$password);

    	$requete= $bdd->prepare("SELECT l.titre,l.sorti, l.synopsis, l.pages, l.prix, a.id, a.nom, a.prenom, g.genreID 
		FROM livres AS l
		LEFT JOIN auteurs AS a
		ON l.auteur = a.id
		LEFT JOIN auteursGenres AS g
		ON l.auteur=g.auteurID
		WHERE g.genreID = 7
		");
     	$requete->execute();
     	$requete = $requete->fetchAll();
		?>

		<div class="imagelibrary">
		<img src="Images/AustriaGoettweigAbbey.jpg" alt="Photo de la bibliothèque de l'abbaye de Gottweig en Autriche" title="Abbaye de Goettweig en Autriche" />
		</div>
			
			<h1>Livres - poésie</h1>
				<div class="intro">
				<p>Voici les livres du genre poésie ma bibliothèque. Parcours la liste des titres ou choisis un autre genre du livre du menu.</p>
				</div>
				
				<div class="main">
				<div class = "dropdownList">
        			<button class="dropdownButton"
            		onclick="showList()">
            		Choisis genre
        			</button>
        
					<div id="genreID" class="genres">
						<a href="drame.php">drame</a>
						<a href="fiction.php">fiction</a>
						<a href="poesie.php">poésie</a>
						<a href="theatre.php">théatre</a>
						<a href="policier.php">policier</a>
					</div>
      			</div>
				</div>

				<script>
        			function showList() {
            		var genres = document.getElementById("genreID");
 
            		if (genres.style.display == "block") {
                	genres.style.display = "none";
            		} else {
                	genres.style.display = "block";
            		}
        			}
        			window.onclick = function (event) {
            		if (!event.target.matches('.dropdownButton')) {
                	document.getElementById('genreID')
                    .style.display = "none";
            		}
        			}   
				</script>		

				<div>
					<?php 
					foreach ($requete as $livre) {
					
					?>		   
					<section class = "book">

						<h2><a href="auteurs.php" target="_blank"><?= $livre["titre"]?></a></h2>
						<div>
                            <p>par <?= $livre['prenom']?> <?= $livre['nom']?></p>
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