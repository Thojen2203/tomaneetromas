<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head><?php include 'rsc/head.php';?></head>
	<body>
		<?php include 'rsc/header.php'; ?>
		<?php include 'rsc/navmenu.php'; ?>
		<div id="content">
			<div class="welcome-page">
				<div class="toptext">
					<h1>Bienvenue sur TomaneEtRomas.</h1>
					<h3>Voici ce que vous pouvez faire dès maintenant.</h3>
				</div>
				<div class="choices-list">
					<div class="choicebox">
						<a href="search.php" class="choice">
						<div class="choicebox-content">
							<h1><span class="material-symbols-outlined fs-120">
							menu_book
							</span></h1>
							<h1>Rechercher des recettes de cuisine</h1>
						</div>
						</a>
					</div>
					<div class="choicebox">
						<a href="browse_recipes.php" class="choice">
						<div class="choicebox-content">
							<h1><span class="material-symbols-outlined fs-120">
							travel_explore
							</span></h1>
							<h1>Parcourir les recettes et les catégories</h1>
						</div>
						</a>
					</div>
					<div class="choicebox">
						<a href="login.php" class="choice">
						<div class="choicebox-content">
							<h1>
							<span class="material-symbols-outlined fs-120">
							account_circle
							</span>
							</h1>
							<h1>Créer un compte ou se connecter</h1>
						</div>
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php include 'rsc/footer.php'; ?>
	</body>
</html>