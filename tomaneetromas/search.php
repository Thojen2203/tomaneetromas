<?php session_start(); 

if (!isset($_GET['query'])){
	header("Location: search.php?query=");
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head><?php include 'rsc/head.php';?></head>
	<body>
		<?php include 'rsc/header.php';
		include 'rsc/navmenu.php'; ?>
		<div class="title">
			<h1>Résultats de la recherche : <?php echo $_GET['query']; ?></h1>
			<p>Pour faire une recherche, utilisez la barre en haut à gauche de l'écran.</p>
			<?php
			$q = $db -> prepare("SELECT * FROM recipes WHERE recipe_name LIKE :search");
			$q -> execute([
				"search" => "%" . $_GET['query'] . "%"
			]);
			if (isset($_GET['userid'])){		
				$c = $db -> prepare("INSERT INTO history (user_id, type, value) VALUES (:uid,:t,:v)");
				$c -> execute([
					"uid" => $_SESSION['userid'],
					"t" => "search",
					"v" => $_GET['query']
				]);
			}
			$results =$q -> fetchAll();
			echo "<h2>" . count($results) . " résultats</h2>";
			?>
		</div>
		<div id="content">
			<div class="half-box">
				<?php
				foreach($results as $result){
					echo "<h2>" . $result['recipe_name'] . "</h2>";
					echo "<h3>" . $result['views'] . " vues</h3>";
					echo "<hr>";
				}
				?>
			</div>
		</div>
		<?php include 'rsc/footer.php' ?>
	</body>
</html>