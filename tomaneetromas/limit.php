<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head><?php include 'rsc/head.php';?></head>
	<body>
		<?php include 'rsc/header.php';
		include 'rsc/navmenu.php'; ?>
		<h1 style="color: red;">Erreur</h1>
		<p style="color: red;">Vous avez atteint la limite quotidienne de publication de recettes. Réessayez plus tard.</p>
		<?php include 'rsc/footer.php' ?>
	</body>
</html>