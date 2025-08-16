<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head><?php include 'rsc/head.php';?>
		<style>
			table.cookies-table{
				border-collapse: collapse;
			}
			table.cookies-table th, table.cookies-table td{
				border: 1px solid black;
			}
		</style>
	</head>
	<body>
		<?php include 'rsc/header.php';
		include 'rsc/navmenu.php'; ?>
		<h1>Informations à propos des cookies</h1>
		<h2>Cookies indispensables au fonctionnement :</h2>
		<table class="cookies-table">
			<tr>
				<th>Nom du cookie</th>
				<th>Description</th>
				<th>Durée de conservation</th>
			</tr>
			<tr>
				<td>PHPSESSID</td>
				<td>Identifiant de la session PHP</td>
				<td>Fin de la session</td>
			</tr>
		</table>
		<h2>Cookies permettant une meilleure expérience</h2>
		<table class="cookies-table">
			<tr>
				<th>Nom du cookie</th>
				<th>Description</th>
				<th>Durée de conservation</th>
			</tr>
			<tr>
				<td>add_email_warning_ignore</td>
				<td>Permet de mémoriser le choix de ne pas ajouter d'e-mail lors de la connexion si l'utilisateur a choisi de le rajouter plus tard.</td>
				<td>1 jour, 3 jours, 7 jours ou 14 jours</td>
			</tr>
			<tr>
				<td>add_phone_number_warning_ignore</td>
				<td>Permet de mémoriser le choix de ne pas ajouter de numéro de téléphone lors de la connexion si l'utilisateur a choisi de le rajouter plus tard.</td>
				<td>1 jour, 3 jours, 7 jours ou 14 jours</td>
			</tr>
		</table>
		<?php include 'rsc/footer.php' ?>
	</body>
</html>