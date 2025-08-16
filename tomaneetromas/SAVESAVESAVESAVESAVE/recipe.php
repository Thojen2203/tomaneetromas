<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head><?php include 'rsc/head.php';?>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	</head>
	<body>
		<?php include 'rsc/header.php';
		include 'rsc/navmenu.php'; ?>
		<div class="title">
			<div>
				<?php
				include 'rsc/relative_time_ext.php';
				$q = $db -> prepare("SELECT * FROM recipes WHERE recipes.recipe_id=:r_id");
				$q -> execute([
					"r_id" => $_GET['id']
				]);
				$details = $q -> fetch();
				$c = $db -> prepare("UPDATE recipes SET views=:new_views_count WHERE recipe_id=:r_id");
				$c -> execute([
					"new_views_count" => $details['views']+1,
					"r_id" => $_GET['id']
				]);
				if(isset($_SESSION['userid'])){
					$d = $db -> prepare("INSERT INTO history (user_id, type, value) VALUES (:userid, :h_type, :h_value)");
					$d -> execute([
						"userid" => $_SESSION['userid'],
						"h_type" => "recipe_view",
						"h_value" => $_GET['id'] // identifiant de la recette
					]);
				}
				echo "<h1>" . $details['recipe_name'] . "</h1>";
				echo "<p>" . $details['views'] . " vue(s) &bull; Mise en ligne " . getRelativeTime($details['created']) . "</p>"?>
			</div>
			<div class="recipe-actions">
				<p class="recipe-action like-btn"><span id="like-icon" class="material-symbols-outlined fs-40">thumb_up</span></p><p class="like-count">27</p>
				<p class="recipe-action"><span id="bookmark-icon" class="material-symbols-outlined fs-40">bookmark_add</span></p>
			</div>
		</div>
		<div id="content">
			<div class="ingredients">
				<h1>Ingrédients nécessaires</h1>
				<?php
				$d = $db -> prepare("SELECT * FROM ingredients WHERE ingredients.recipe_id=:r_id");
				$d -> execute([
					"r_id" => $_GET['id']
				]);
				$ingredients = $d -> fetchAll();
				$units = array("x" => " ", "g" => "grammes de ", "ml" => "millilitres de ", "cl" => "centilitres de ", "dl" => "décilitres de ", "l" => "litres de ", "cac" => "cuillère(s) à café de ", "cas" => "cuillère(s) à soupe de ", "oz" => "onces de ", "bag" => "sachets de ", "glass" => "verre(s) de ", "pot" => "pot(s) de ");
				foreach($ingredients as $ingredient){

					echo "<p>" . $ingredient['quantity'] . " " . $units[$ingredient['unit']] . " " . $ingredient['name'] . "</p>";
				}
				?>
			</div>
			<div class="utensils">
				<h1>Ustensiles nécessaires</h1>
				<?php
				$e = $db -> prepare("SELECT * FROM utensils WHERE utensils.recipe_id=:r_id");
				$e -> execute([
					"r_id" => $_GET['id']
				]);
				$utensils = $e -> fetchAll();
				foreach($utensils as $utensil){
					echo "<p>" . $utensil['name'] . "</p>";
				}
				?>
			</div>
			<div class="recipe">
			<?php
			$f = $db -> prepare("SELECT * FROM preparations WHERE preparations.recipe_id=:r_id");
			$f -> execute([
				"r_id" => $_GET['id']
			]);
			$prep = $f -> fetch();
			echo "<h1>Préparation de la recette</h1>";
			echo "<p>" . $prep['preparation'] . "</p>";
			?>
			</div>
		</div>
		<?php include 'rsc/footer.php' ?>
		<script type="text/javascript">
/*function updateBookmark(recipeid, userid, action) {
    fetch('updateBookmark.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ recipeid: recipeid, userid: userid, action: action })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
*/
document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM fully loaded and parsed");
    let bookmarkIcon = document.getElementById('bookmark-icon');
    if (bookmarkIcon) {
        console.log("Bookmark icon found");
        bookmarkIcon.addEventListener('click', function() {
            console.log("Bookmark icon clicked");
            console.log("Current textContent:", bookmarkIcon.textContent);
            if (bookmarkIcon.textContent === 'bookmark_add') {
                bookmarkIcon.textContent = 'bookmark_remove';
                bookmarkIcon.style.fontVariationSettings = "'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 48";
                console.log("Changed to 'bookmark_remove'");
            } else {
                bookmarkIcon.textContent = 'bookmark_add';
                bookmarkIcon.style.fontVariationSettings = "'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48";
                console.log("Changed to 'bookmark_add'");
            }
            console.log("New textContent:", bookmarkIcon.textContent);
        });
    } else {
        console.log("Bookmark icon not found");
    }
});
$(document).ready(function() {
    // Obtenez les paramètres GET
    const urlParams = new URLSearchParams(window.location.search);
    const postId = urlParams.get('post_id');

    $('.like-btn').click(function() {
        var button = $(this);

        $.post('rsc/add_like.php', { post_id: postId }, function(response) {
            console.log(response); // Ajouté pour le débogage
            try {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    var likeCountSpan = button.siblings('.like-count');
                    var likeCount = parseInt(likeCountSpan.text());

                    if (data.action === 'liked') {
                        button.text('Unlike');
                        likeCount++;
                    } else {
                        button.text('Like');
                        likeCount--;
                    }

                    likeCountSpan.text(likeCount);
                } else {
                    alert(data.message);
                }
            } catch (e) {
                console.error("Erreur de parsing JSON:", e);
                console.error("Réponse du serveur:", response);
                alert("Une erreur est survenue. Veuillez réessayer plus tard.");
            }
        });
    });
});
		</script>
	</body>
</html>






<?php // $q = $db -> prepare("SELECT * FROM recipes LEFT JOIN ingredients ON recipes.recipe_id=ingredients.recipe_id JOIN utensils ON utensils.recipe_id=recipes.recipe_id JOIN preparations ON preparations.recipe_id=recipes.recipe_id WHERE recipes.recipe_id=:r_id"); ?>