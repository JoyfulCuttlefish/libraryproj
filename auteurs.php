<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Auteurs</title>
	</head>

	<body>

	<?php
     include ('includes/head.php');
     include ('includes/nav.php');
     require('databases/connectDatabase.php');
    
     $bdd = connexionDB($host,$db_name,$login,$password);

     $requete= $bdd->prepare("SELECT DISTINCT id, nom, prenom, naissance, mort, biographie, photo FROM auteurs"); //TODO : j'ai enlevé  GROUP BY nom;
     $requete->execute();
     $requete = $requete->fetchAll();
	 $auteur_id = "0";
	 if(isset($_GET["id"])) {
		$auteur_id = htmlspecialchars($_GET["id"]);
		}
	?>

		<div class="imagelibrary">
		<img src="Images/AustriaGoettweigAbbey.jpg" alt="Photo de la bibliothèque de l'abbaye de Gottweig en Autriche" title="Abbaye de Goettweig en Autriche" />
		</div>

			<h1>Auteurs</h1>
				<div class="intro">
				<p>Voici la liste des auteurs de tous les livres dans ma bibliothèque.</p>
				</div>

				<div class="Authors">
					<?php
					$boolean = false;
					foreach ($requete as $auteur) {
						if (htmlspecialchars($auteur["id"]) == $auteur_id) {
							$boolean = true;
						}
					
					?>
						<section class="Auteur">

							<h2><?= htmlspecialchars($auteur["prenom"])?> <?= htmlspecialchars($auteur["nom"])?></a></h2>
							<a href='<?= $auteur["photo"]?>'><img src='<?= $auteur["photo"]?>' alt="Photo de l'auteur" title="Clique pour agrandir" width="150" /></a>
							<div>
								<p>Naissance : <?= htmlspecialchars($auteur['naissance'])?></p>
								<p>Mort : <?= htmlspecialchars($auteur['mort'])?></p>
								<p>Biographie: <?= strip_tags($auteur['biographie'])?></p>
							</div>

							<div class="booksButton">
								<?php
								echo '<button id="info" onclick="showLivres('.$auteur["id"].')">Livres de cet auteur</button>';
								echo '<div class="livres'.strip_tags($auteur["id"]).'"></div';
								?>
							</div>


						</section>

					<?php }
					?>

    			</div>
	<script src="bibscript.js"></script>
	</body>
</html>
