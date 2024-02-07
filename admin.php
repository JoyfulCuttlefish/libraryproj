<!DOCTYPE html>
<html lang="fr">
	<head>
		<script src="admin.js" defer></script>
		<title>Administration</title>
	</head>

	<body>
    <?php
     include ('includes/head.php');
     include ('includes/nav.php');
     require('databases/connectDatabase.php');
    
     $bdd = connexionDB($host,$db_name,$login,$password);
	?>

		<div class="imagelibrary">
		<img src="Images/AustriaGoettweigAbbey.jpg" alt="Photo de la bibliothèque de l'abbaye de Gottweig en Autriche" title="Abbaye de Goettweig en Autriche" />
		</div>

			<h1>Administration</h1>
				<div class="intro">
				<p>Voici on peut créer, modifier ou supprimer un livre.</p>
				</div>

					
						<section id="create">
							<form id="createBook">
							<h2>Ajouter un livre</h2>
	
								<input name="newBookTitre"  type="text" placeholder="Titre ici (obligatoire)" id="titre">
								<input name="newSorti" type="text" placeholder="Année de parution" id="sorti">
								<input name="newSynopsis" type="textarea" placeholder="Ecrit un sommaire du livre" >
								<input name="newPages" type="text" placeholder="Combien de pages?" id="pages">

								<input type="submit" onclick = "createBook()" value="Ajoute" name="createButton" id="ajouter" >
							</form>
					
						</section>

						<section id="update">
							<form id="updateBook">		
							<h2>Modifier un livre</h2>
							
								<input name="IDtoModify"  type="text" placeholder="Entre l'ID du livre (obligatoire)" id="livreID">
								<input name="updateTitre"  type="text" placeholder="Titre ici (obligatoire)" id="titre">
								<input name="updateSorti" type="text" placeholder="An de parution (obligatoire)" id="sorti">
								<input name="updateSynopsis" type="textarea" placeholder="Ecrit un sommaire du livre" >
								<input name="updatePages" type="text" placeholder="Combien de pages?" id="pages">

								<input type="submit" onclick = "updateBook()" value="Modifie" name="modifieButton" id="modifier" >
							</form>
													
						</section>

						<section id="delete">
							<form id="deleteBook">
							<h2>Supprimer un livre</h2>

								<input name="IDtoDelete" type="text" placeholder="Entre l'ID du livre (obligatoire)" id="deleteTitle" >
							
								<input type="submit" onclick = "deleteBook()" value="Supprimer" name="deleteButton" id="supprimer" >					
							</form>
		
						</section>


	</body>
</html>
