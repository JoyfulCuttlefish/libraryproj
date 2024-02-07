<!DOCTYPE html>
<html lang="fr">
	<head>
		<script src="emprunteLivre.js" defer></script>
		<title>Emprunte Livre</title>
	</head>

	<body>

	<?php
     include ('includes/head.php');
     include ('includes/nav.php');
     require('databases/connectDatabase.php');
    
     $bdd = connexionDB($host,$db_name,$login,$password);

	 $requete= $bdd->prepare("SELECT * FROM emprunteLivre"); 
     	$requete->execute(); //TODO : attention à l'indention
     	$requete = $requete->fetchAll();	 

	?>

		<div class="imagelibrary">
		<img src="Images/AustriaGoettweigAbbey.jpg" alt="Photo de la bibliothèque de l'abbaye de Gottweig en Autriche" title="Abbaye de Goettweig en Autriche" />
		</div>

			<h1>Emprunte Livre</h1>
				<div class="intro">
				<p>Voici on peut noter le livre que l'on a emprunté, modifier ou supprimer les empruntes.</p>
				</div>	

					<div>
					
						<section id="create">
							<form id="createRecord">
							<h2>Ajouter le livre emprunté</h2>
						
								<label for="titre">Livre:</label>
								<input name="newEmprunteTitre" type="text" placeholder="Titre ici (obligatoire)">
								<input  name="newEmprunteAuteurNom" type="text" placeholder="Nom de l'auteur">
								<input  name="newEmprunteAuteurPrenom" type="text" placeholder="Prenom de l'auteur?">
								<label for="emprunte">Emprunté par:</label>
								<input  name="newEmprunteNomAmi" type="text" placeholder="Ton nom (obligatoire)">
								<input  name="newEmpruntePrenomAmi" type="text" placeholder="Ton prenom (obligatoire)">


								<input type="submit" onclick = "createRecord(event)" name="createButton" value="Ajouter">
							</form>
						</section>
					
						<h2> Voici les livres empruntés :</h2>
						<?php 
					foreach ($requete as $emprunteLivre) {
					
					?>	

						<section class = "book">
							<h2><a href="livres.php" target="_blank"><?= $emprunteLivre["titre"]?></a></h2>
							<div>
							<p>un livre par <?= $emprunteLivre["auteurPrenom"]?> <?= $emprunteLivre["auteurNom"]?></p>
							<p>Voici l'ID du titre<br> (utilise pour modifier ou supprimer le livre) :<strong> <?= $emprunteLivre['titreID']?></strong></p>
							<p>a été emprunté par : <?= $emprunteLivre['prenomAmi']?> <?= $emprunteLivre['nomAmi']?></p>
							<p>Bonne lecture!</p>
							</div>

						</section>

					<?php } ?>
					</div>


						

					<section id="update">
							<form id="updateRecord">
							<h2>Modifier le livre emprunté</h2>
								
								<label for="titreIDduLivre">ID du titre:</label>
								<input name="IDduTitre" type="text" placeholder="ID du titre (obligatoire)">
								<label for="titre">Livre:</label>
								<input name="updateTitre" type="text" placeholder="Modifie le titre ici (obligatoire)">
								<input  name="updateAuteurNom" type="text" placeholder="Nom de l'auteur">
								<input  name="updateAuteurPrenom" type="text" placeholder="Prenom de l'auteur?">
								<label for="emprunte">Emprunté par:</label>
								<input  name="updateNomAmi" type="text" placeholder="Ton nom (obligatoire)">
								<input  name="updatePrenomAmi" type="text" placeholder="Ton prenom (obligatoire)">


								<input type="submit" onclick = "updateRecord()" name="updateButton" value="Modifier">
							</form>
						</section>

						<section id="delete">
							<form id="deleteRecord">
							<h2>Supprimer un livre</h2>

								<input name="IDtoDelete" type="text" placeholder="Entre l'ID du livre (obligatoire)" id="deleteTitle" >
							
								<input type="submit" onclick = "deleteRecord()" value="Supprimer" name="deleteButton" id="supprimer" >					
							</form>
		
						</section>

	</body>
</html>
