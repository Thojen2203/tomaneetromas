<?php session_start();
if(!isset($_SESSION['userid'])){
	header("Location: welcome.php");
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head><?php include 'rsc/head.php';?></head>
	<body>
		<?php include 'rsc/header.php'; ?>
		<?php include 'rsc/navmenu.php'; ?>
		<div id="content">
			<div class="user-news">
				<h1>Nouveautés !</h1>
				<div class="news">
					<h3>Recettes mises en ligne récemment</h3>
					<?php
					$q = $db -> prepare("SELECT * FROM recipes ORDER BY created DESC LIMIT 10");
					$q -> execute();
					include 'rsc/relative_time_ext.php';
					while ($recipe = $q -> fetch()){
						echo "<div><h2><a href='recipe.php?id=" . $recipe['recipe_id'] . "'>" . $recipe['recipe_name'] . "</a></h2><p>" . getRelativeTime($recipe['created']) . " &bull; " . $recipe['views'] . " <span class='material-symbols-outlined fs-20'>visibility</span> &bull; " . $recipe['likes'] . " <span class='material-symbols-outlined fs-20'>thumb_up</span> &bull; " . $recipe['dislikes'] . " <span class='material-symbols-outlined fs-20'>thumb_down</span></p></div>";
					}
					?>
				</div>
			</div>
			<div class="favorites">
				<h1>Vos favoris</h1>
			</div>
			<div class="recent-recipes">
				<h1>Recettes lues récemment</h1>
				<?php
				$c = $db -> prepare("SELECT DISTINCT recipes.recipe_name, history.value, history.created FROM history JOIN recipes ON history.value=recipes.recipe_id WHERE type=:t AND user_id=:i ORDER BY history.created DESC LIMIT 8");
				$c -> execute([
					"t" => "recipe_view",
					"i" => $_SESSION['userid']
				]);
				$viewed = array();
				while ($history = $c -> fetch()){
					if (!in_array($history['value'], $viewed)){
						echo "<div><h2><a href='recipe.php?id=" . $history['value'] . "'>" . $history['recipe_name'] . "</a></h2></div>";
						$viewed[] = $history['value'];
					}
				}
				?>
			</div>
		</div>
		<?php include 'rsc/footer.php'; ?>
	</body>
</html>