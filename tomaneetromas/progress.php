<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head><?php include 'rsc/head.php';?></head>
	<body>
		<?php include 'rsc/header.php';
		include 'rsc/navmenu.php'; ?>
		<div>
			<h1>Comptes : </h1><progress value="1" max="1"></progress>
			<h1>Mise en ligne des recettes :</h1>
			<ul>
				<li><h2>Ajout de recettes</h2><progress value="0.1" max="1"></progress></li>
				<li><h2>Images</h2><progress></progress></li>
			</ul>
			<h1>Lecture/affichage des recettes :</h1>
			<ul>				
				<li><h2>Afficher les recettes</h2><progress value="0" max="1"></progress></li>
				<li><h2>Commentaires</h2><progress value="0" max="1"></progress></li>
			</ul>
		</div>
		<?php include 'rsc/footer.php' ?>
	</body>
</html>