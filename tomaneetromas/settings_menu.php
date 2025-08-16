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
					<h1>Paramètres</h1>
				</div>
				<div class="choices-list">
					<div class="choicebox">
						<a href="interface_settings.php" class="choice">
						<div class="choicebox-content">
							<h1><span class="material-symbols-outlined fs-120">
							display_settings
							</span></h1>
							<h1>Interface</h1>
						</div>
						</a>
					</div>
					<div class="choicebox">
						<a href="browse_recipes.php" class="choice">
						<div class="choicebox-content">
							<h1><span class="material-symbols-outlined fs-120">
							manage_accounts
							</span></h1>
							<h1>Paramètres de votre compte</h1>
						</div>
						</a>
					</div>
					<div class="choicebox">
						<a href="history_settings.php" class="choice">
						<div class="choicebox-content">
							<h1>
							<span class="material-symbols-outlined fs-120">
							history
							</span>
							</h1>
							<h1>Historique des recherches, recettes...</h1>
						</div>
						</a>
					</div>
					<div class="choicebox">
						<a href="login.php" class="choice">
						<div class="choicebox-content">
							<h1>
							<span class="material-symbols-outlined fs-120">
							lock_person
							</span>
							</h1>
							<h1>Modération de votre compte</h1>
						</div>
						</a>
					</div>
					<div class="choicebox">
						<a href="your_stats.php" class="choice">
						<div class="choicebox-content">
							<h1>
							<span class="material-symbols-outlined fs-120">
							analytics
							</span>
							</h1>
							<h1>Vos statistiques</h1>
						</div>
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php include 'rsc/footer.php'; ?>
	</body>
</html>