<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
       
		<title>Rating</title>
	</head>
	<?php
		
     include ('includes/head.php');
     include ('includes/nav.php');
     require('databases/connectDatabase.php');


     $bdd = connexionDB($host,$db_name,$login,$password);

     $requete= $bdd->prepare("SELECT * FROM livres"); //TODO : limiter la quantité d'élément retournée par la BDD, éviter les select *
     $requete->execute();
     $requete = $requete->fetchAll();
				

	 ?>
	
	<body>
		<div class="imagelibrary">
				<img src="Images/AustriaGoettweigAbbey.jpg" alt="Photo de la bibliothèque de l'abbaye de Gottweig en Autriche" title="Abbaye de Goettweig en Autriche" />
		</div>

		<h1>Donne ton avis sur un livre/ Rate a book</h1>
		
			<div class="intro">
				<p>Voici les livres disponible dans ma bibliothèque:</p>
			</div>
			<div>
					<?php 
					foreach ($requete as $livre) {
						
					
					?>		   
					<section class = "ratings">
                    <ul>
    					<li><a href="livres.php" target="_blank"><em><?= $livre["titre"]?></em></a></li>
    					<li>Likes:</li>
    					<li id=<?= $livre['id']?>>0</li>
    					<button onclick="increment(<?= $livre['id']?>)" id ="increment-btn"> Clicks = Likes</button>
    					
    				</ul>

    				</section>
					<?php } ?>
    			 

   			</div>
   			 <script src="ratingsPage.js"></script>
	</body>
	</html>