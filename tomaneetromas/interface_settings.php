<?php session_start();
if (!isset($_SESSION['username'])){
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head><?php include 'rsc/head.php';?></head>
	<body>
		<?php include 'rsc/header.php';
		include 'rsc/navmenu.php'; ?>
		<div class="title">
			<h1>Paramètres de l'interface</h1>
		</div>
		<div id="content">
			<div class="full">
				<form action="rsc/update_interface_settings.php" method="POST">
					<h2>Affichage</h2>
					<label for="font">Police d'écriture</label>
					<select name="font" id="font">
						<option value="Arial">Arial</option>
						<option value="Barlow">Barlow</option>
						<option value="Inter">Inter</option>
						<option value="Lilita One">Lilita One</option>
						<option value="Manrope">Manrope</option>
						<option value="Overpass">Overpass</option>
						<option value="PT Sans">PT Sans</option>
						<option value="Quicksand">Quicksand</option>
						<option value="Roboto">Roboto</option>
						<option value="Rubik">Rubik</option>
						<option value="SourceSans">Source Sans 3</option>
						<option value="system-ui">System UI</option>
						<option value="Ubuntu">Ubuntu</option>
						<option value="Yantramanav">Yantramanav</option>
					</select><br>
					<label for="theme">Thème</label>
					<select name="theme" id="theme">
						<option value="light">Thème clair</option>
						<option value="dark">Thème sombre</option>
					</select>
					<h2>Page d'accueil</h2>
					<p>Paramètres disponibles bientôt</p>
					<input type="submit" name="save" id="save" value="Enregistrer les préférences">
				</form>
			</div>
		</div>
		<?php include 'rsc/footer.php' ?>
	</body>
</html>