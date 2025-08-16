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
				include 'rsc/numbers.php';
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
				echo "<p>" . numberToString($details['views']) . " vue(s) &bull; Mise en ligne " . getRelativeTime($details['created']) . "</p>";


				$sql_likes = "SELECT user_id FROM likes WHERE post_id = ?";
				$q = $db -> prepare($sql_likes);
				$q -> bindParam(1, $_GET['id'], PDO::PARAM_INT);
				$q -> execute();
				// $likes_request_result = $q -> fetchAll();
				$user_ids_like = array();
				while($user_id = $q -> fetch()){
					$user_ids_like[] = $user_id[0];
				}
				$recipe_likes = count($user_ids_like);



				$sql_dislikes = "SELECT user_id FROM dislikes WHERE post_id = ?";
				$q = $db -> prepare($sql_dislikes);
				$q -> bindParam(1, $_GET['id'], PDO::PARAM_INT);
				$q -> execute();
				// $likes_request_result = $q -> fetchAll();
				$user_ids_dislike = array();
				while($user_id = $q -> fetch()){
					$user_ids_dislike[] = $user_id[0];
				}
				$recipe_dislikes = count($user_ids_dislike);

				?>
			</div>
			<div class="recipe-actions">
				<p class="recipe-action material-symbols-outlined fs-30" style="color: red;">flag</span></p>
				<?php
					if (isset($_SESSION['userid'])){
						if ($_SESSION['userid'] == $details['userid']){
							echo "<p class='recipe-action material-symbols-outlined fs-30' style='color: red;'>delete</p>";
							echo "<p class='recipe-action material-symbols-outlined fs-30'>edit</p>";
						}
					}
				?>
				<p class="recipe-action material-symbols-outlined like-btn fs-30"<?php if(isset($_SESSION['userid'])){
				if (in_array($_SESSION['userid'],$user_ids_like)){
				 	echo 'style="font-variation-settings: \'FILL\' 1, \'wght\' 400, \'GRAD\' 0, \'opsz\' 48; color: blue;"';
				}
				}?>><span id="like-icon">thumb_up</span></p><p class="recipe-action-legend like-count"><?php echo $recipe_likes; ?></p>
				<p class="recipe-action material-symbols-outlined dislike-btn fs-30"<?php if(isset($_SESSION['userid'])){
				if (in_array($_SESSION['userid'],$user_ids_dislike)){
				 	echo 'style="font-variation-settings: \'FILL\' 1, \'wght\' 400, \'GRAD\' 0, \'opsz\' 48; color: red;"';
				}
				}?>><span id="dislike-icon">thumb_down</span></p><p class="recipe-action-legend dislike-count"><?php echo $recipe_dislikes ?></p>
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
$(document).ready(function() {
    // Obtenez les paramètres GET
    const urlParams = new URLSearchParams(window.location.search);
    const postId = urlParams.get('id');

    $('.bookmark-icon').click(function() {
        var button = $(this);

        $.post('rsc/add_bookmark.php', { post_id: postId }, function(response) {
            console.log(response); // Ajouté pour le débogage
            try {
                //var data = JSON.parse(response);
                var data = response;
                if (data.status === 'success') {
                    var likeCountSpan = button.siblings('.like-count');
                    var likeCount = parseInt(likeCountSpan.text());

                    if (data.action === 'liked') {
                        button.css('fontVariationSettings',"'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 48");
                        button.css('color',"blue");
                        likeCount = data.likes;
                    } else {
                        button.css('fontVariationSettings',"'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48");
                        button.css('color',"black");
                        likeCount = data.likes;
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
$(document).ready(function() {
    // Obtenez les paramètres GET
    const urlParams = new URLSearchParams(window.location.search);
    const postId = urlParams.get('id');

    $('.like-btn').click(function() {
        var button = $(this);

        $.post('rsc/add_like.php', { post_id: postId }, function(response) {
            console.log(response); // Ajouté pour le débogage
            try {
                //var data = JSON.parse(response);
                var data = response;
                if (data.status === 'success') {
                    var likeCountSpan = button.siblings('.like-count');
                    var likeCount = parseInt(likeCountSpan.text());

                    if (data.action === 'liked') {
                        button.css('fontVariationSettings',"'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 48");
                        button.css('color',"blue");
                        likeCount = data.likes;
                    } else {
                        button.css('fontVariationSettings',"'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48");
                        button.css('color',"black");
                        likeCount = data.likes;
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
$(document).ready(function() {
    // Obtenez les paramètres GET
    const urlParams = new URLSearchParams(window.location.search);
    const postId = urlParams.get('id');

    $('.dislike-btn').click(function() {
        var button = $(this);

        $.post('rsc/add_dislike.php', { post_id: postId }, function(response) {
            console.log(response); // Ajouté pour le débogage
            try {
                //var data = JSON.parse(response);
                var data = response;
                if (data.status === 'success') {
                    var likeCountSpan = button.siblings('.dislike-count');
                    var likeCount = parseInt(likeCountSpan.text());

                    if (data.action === 'liked') {
                        button.css('fontVariationSettings',"'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 48");
                        button.css('color',"red");
                        likeCount = data.dislikes;
                    } else {
                        button.css('fontVariationSettings',"'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48");
                        button.css('color',"black");
                        likeCount = data.dislikes;
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