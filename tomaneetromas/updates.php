	<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head><?php include 'rsc/head.php';?></head>
	<body>
		<?php
		include 'rsc/header.php';
		include 'rsc/navmenu.php';
		?>
		<div id="content">
			<div class="updates">
				<ul>
					<li><a href="whatsnew.php#1.x" class="level1">v1.x</a></li>
					<li><a href="whatsnew.php#1.1" class="level2">v1.1</a></li>
					<li><a href="whatsnew.php#1.0" class="level2">v1.0</a></li>
				</ul>
				<h1>Notes de mise à jour</h1>
				<h1 id="1.x" class="level1">Version 1.x</h1>
				<h2 id="1.1" class="level2">v1.1</h2>
				<h4>Nouvelles fonctionnalités</h4>
				<ol>
					<li>Notifications</li>
					<li>Score de réputation</li>
					<ul>
						<li>Chaque compte a un score de réputation de 100.</li>
						<li>Chaque signalement diminue le score de réputation de 8 points.</li>
						<li>Un point de réputation est récupéré toutes les 12 heures.</li>
						<li>Lorsqu'un compte atteint 0 point de réputation, il est suspendu de manière temporaire.</li>
						<li>Si un contenu signalé est supprimé par l'utilisateur, les points de réputation perdus ne sont pas récupérés immédiatement.</li>
					</ul>
					<li>Signalements</li>
					<ul>
						<li>Chaque utilisateur peut signaler un post ou un commentaire.</li>
						<li>Les utilisateurs sont limités à 8 signalements touets les 24 heures.</li>
						<li>Les signalements sont faits de manière anonyme.</li>
						<li>Le compte dont le contenu est signalé est informé du signalement.</li>
					</ul>
				</ol>
				<h2 id="1.0" class="level2">v1.0</h2>
				<h4>Nouvelles fonctionnalités</h4>
				<ol>
					<li>Signalement de bugs</li>
					<li>Suggestions</li>
					<li>Modification des détails du compte, possibilité d'ajouter une bio</li>
					<li>Refonte du site</li>
					<ul>
						<li>Moins de couleurs</li>
						<li>Couleurs moins flashies</li>
						<li>Suppression de boutons inutiles</li>
					</ul>
				</ol>
				<h4>Correction de bugs</h4>
				<ol>
					<li><a href="research.php">research.php</a> : problème d'affichage sur la page corrigé</li>
					<li>Site plus responsive sur les téléphones mobiles</li>
				</ol>
				<br>
			</div>
		</div>
		<?php
		include 'rsc/footer.php';
		?>
	</body>
</html>