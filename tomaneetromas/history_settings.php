<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head><?php include 'rsc/head.php';?></head>
	<body>
		<?php include 'rsc/header.php';
		include 'rsc/navmenu.php'; ?>
		<div class="title">
			<h1>Paramètres de l'historique</h1>
		</div>
		<div id="content">
			<div class="half-box">
				<h2>Historique des recettes visionnées</h2><button id="show-recipe-history" type="button" onclick="showRecipesHistory()">Afficher</button>
				<div id="recipes-history" style="display: none;">
				<?php
				$q = $db -> prepare("SELECT * FROM history JOIN recipes ON history.value=recipes.recipe_id WHERE type='recipe_view' AND user_id=:uid ORDER BY history.created DESC");
				$q -> execute([
					"uid" => $_SESSION['userid']
				]);
				while ($history_element = $q -> fetch()){
					echo "<h3>" . $history_element['recipe_name'] . "</h3>";
				}
				?>
				</div>
				<h2>Historique des recherches</h2><button id="show-search-history" type="button" onclick="showSearchHistory()">Afficher</button>
				<div id="search-history" style="display: none;">
				<?php
				$q = $db -> prepare("SELECT * FROM history WHERE type='search' AND user_id=:uid ORDER BY history.created DESC");
				$q -> execute([
					"uid" => $_SESSION['userid']
				]);
				while ($history_element = $q -> fetch()){
					echo "<h3>" . $history_element['value'] . "</h3>";
				}
				?>
				</div>
			</div>
		</div>
		<script type="text/javascript">
function showRecipesHistory(){
    if (document.getElementById("recipes-history").style.display === "none"){
        document.getElementById("recipes-history").style.display = "block";
        document.getElementById("show-recipe-history").innerText = "Masquer";
    } else {
        document.getElementById("recipes-history").style.display = "none";
        document.getElementById("show-recipe-history").innerText = "Afficher";
    }
}
function showSearchHistory(){
    if (document.getElementById("search-history").style.display === "none"){
        document.getElementById("search-history").style.display = "block";
        document.getElementById("show-search-history").innerText = "Masquer";
    } else {
        document.getElementById("search-history").style.display = "none";
        document.getElementById("show-search-history").innerText = "Afficher";
    }
}
		</script>
		<?php include 'rsc/footer.php' ?>
	</body>
</html>