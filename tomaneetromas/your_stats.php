<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head><?php include 'rsc/head.php';?></head>
	<body>
		<?php include 'rsc/header.php';
		include 'rsc/navmenu.php'; ?>
		<div class="title">
			<h1>Statistiques de votre compte</h1>
		</div>
		<div id="content">
			<div class="half-box">
				<?php
				if (!isset($_SESSION['userid'])){
					header("Location: login.php");
				}
				$q = $db -> prepare("SELECT * FROM recipes WHERE userid=:uid ORDER BY views DESC");
				$q -> execute([
					"uid" => $_SESSION['userid']
				]);
				$c = $db -> prepare("SELECT sum(views) FROM recipes WHERE userid=:uid");
				$c -> execute([
					"uid" => $_SESSION['userid']
				]);
				$views = $c -> fetch();
				$results=$q->fetchAll();
				echo "<h1>Nombre total de vues : " . $views[0] . "</h1>";
				foreach ($results as $recipe_stats) {
					echo "<h1>" . $recipe_stats['recipe_name'] . "</h1><h2>" . $recipe_stats['views'] . " vues</h2>";
				}
				?>
			</div>
		</div>
		<?php include 'rsc/footer.php' ?>
	</body>
</html>