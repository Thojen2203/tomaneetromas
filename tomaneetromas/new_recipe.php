<?php session_start();
if(!isset($_SESSION['userid'])){
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head><?php include 'rsc/head.php';?>
		<title>Ajouter une recette</title>
	</head>
	<body>
		<?php include 'rsc/header.php';
		include 'rsc/navmenu.php'; ?>
		<div>
            <?php
                $a = $db -> prepare("SELECT count(*) from recipes WHERE recipes.recipe_id=:r_id and sysdate()-recipes.created < 86400");
                $a -> execute([
                    'r_id' => $_SESSION['userid']
                ]);
                $recipescount = $a->fetch()[0];
                settype($recipescount, "integer");
                var_dump($recipescount);
                if($recipescount >= 10){
                    header("Location: limit.php");
                } else {
                    $recipes_count = 10 - $recipescount;
                    echo "<p>Vous pouvez publier encore <b>" . $recipescount . "</b> recettes aujourd'hui.</p><br>";
                }
            ?>
        </div>
        <div id="content">
			<form class="new-recipe" action="rsc/submit_recipe.php" method="POST">
				<div>
					<h1>1. Informations sur la recette</h1>
					<label for="recipe-name">Nom de la recette : </label>
					<input type="text" name="recipe-name" id="recipe-name" placeholder="Gâteau au chocolat" required><br><br>
					<label for="preparation-time">Temps de préparation : </label>
					<input type="number" name="preparation-time" id="preparation-time" required><br><br>
					<label for="cooking-time">Temps de cuisson : </label>
					<input type="number" name="cooking-time" id="cooking-time" required><br><br>
					<label for="pers-nb">Nombre de personnes : </label>
					<input type="number" name="pers-nb" id="pers-nb" required><br><br>
				</div>
				<div>
					<h1>2. Ingrédients nécessaires</h1>
					<button type="button" onclick="addIngredientField()"><span class="material-symbols-outlined">add</span>Ajouter un ingrédient</button>
					<button type="button" onclick="removeIngredientField()"><span class="material-symbols-outlined">remove</span>Supprimer un ingrédient</button>
					<div id="ingredients">
					</div>
				</div>
				<div>
					<h1>3. Ustensiles nécessaires</h1>					
					<button type="button" onclick="addUtensilField()"><span class="material-symbols-outlined">add</span>Ajouter un ustensile</button>
					<button type="button" onclick="removeUtensilField()"><span class="material-symbols-outlined">remove</span>Supprimer un ustensile</button>
					<div id="utensils">
					</div>
				</div>
				<div>
					<h1>4. Préparation</h1>
					<textarea name="preparation" id="preparation" rows="20" placeholder="Préparation de la recette"></textarea>
					<input type="submit" name="send-recipe" id="send-recipe" value="Mettre en ligne la recette">
				</div>
			</form>
		</div>
		<script type="text/javascript">
function addIngredientField() {
    const ingredientContainer = document.getElementById('ingredients');
    if (ingredientContainer) {
        const ingredientFields = document.getElementsByClassName('ingredient-field');
        if (ingredientFields.length < 40) {
            const newDiv=document.createElement('div');
            newDiv.setAttribute('class','ingredient-item');

            const newInputNumber = document.createElement('input');
            newInputNumber.setAttribute('type','number');
            newInputNumber.setAttribute('step','0.01');
            newInputNumber.setAttribute('name','qty[]');
            newInputNumber.setAttribute('class','qty');
            newInputNumber.setAttribute('placeholder','1');

            const newSelect = document.createElement('select');
            newSelect.setAttribute('name', 'ingredients-unit[]');
            newSelect.setAttribute('class', 'ingredient-field');
            
            // Liste des options d'ingrédients
            const options = [
                { value: '', text: 'Sélect. unité' },
                { value: 'x', text: 'x' },
                { value: 'g', text: 'Grammes (g)' },
                { value: 'ml', text: 'Millilitres (ml)' },
                { value: 'cl', text: 'Centilitres (cL)' },
                { value: 'dl', text: 'Décilitres (dL)' },
                { value: 'l', text: 'Litres (L)' },
                { value: 'cac', text: 'Cuillères à café (càc)' },
                { value: 'cas', text: 'Cuillères à soupe (càs)' },
                { value: 'oz', text: 'Onces (oz)' },
                { value: 'bag', text: 'Sachets' },
                { value: 'glass', text: 'Verres' },
                { value: 'pot', text: 'Pots de yaourt' },
                // Ajoutez d'autres options ici
            ];

            // Ajouter les options au <select>
            options.forEach(optionData => {
                const option = document.createElement('option');
                option.value = optionData.value;
                option.text = optionData.text;
                newSelect.appendChild(option);
            });

            // Ajouter le <select> au conteneur
            ingredientContainer.appendChild(newSelect);

            const newField = document.createElement('input');
            newField.setAttribute('type', 'text');
            newField.setAttribute('name', 'ingredients[]');
            newField.setAttribute('class', 'ingredient-field');
            newField.setAttribute('placeholder', 'Ingrédient');

            newDiv.appendChild(newInputNumber);
            newDiv.appendChild(newSelect);
            newDiv.appendChild(newField);

            ingredientContainer.appendChild(newDiv);
        } else {
            alert("Vous ne pouvez ajouter que 20 ingrédients.");
        }
    } else {
        alert("Une erreur est survenue : le conteneur d'ingrédients est introuvable.");
    }
}
function removeIngredientField(){
    const ingredientContainer = document.getElementById('ingredients');
    if (ingredientContainer) {
        const ingredientItems = ingredientContainer.getElementsByClassName('ingredient-item');
        if (ingredientItems.length > 0) {
            // Supprimer le dernier élément ajouté
            ingredientContainer.removeChild(ingredientItems[ingredientItems.length - 1]);
        } else {
            alert("Aucun ingrédient à supprimer.");
        }
    } else {
        alert("Une erreur est survenue : le conteneur d'ingrédients est introuvable.");
    }
}
function addUtensilField(){
    const utensilsContainer = document.getElementById('utensils');
    if(utensilsContainer){
        const utensilFields = document.getElementsByClassName('utensil-field');
        if (utensilFields.length < 20){
            const newDiv=document.createElement('div');
            newDiv.setAttribute('class','utensil-item');
            const newField = document.createElement('input');
            newField.setAttribute('type', 'text');
            newField.setAttribute('name', 'utensils[]');
            newField.setAttribute('class', 'utensil-field');
            newField.setAttribute('placeholder', 'Ustensile');

            newDiv.appendChild(newField);
            utensilsContainer.appendChild(newDiv);

        }
    }
}
function removeUtensilField(){
    const utensilsContainer = document.getElementById('utensils');
    if (utensilsContainer) {
        const utensilItems = utensilsContainer.getElementsByClassName('utensil-item');
        if (utensilItems.length > 0) {
            // Supprimer le dernier élément ajouté
            utensilsContainer.removeChild(utensilItems[utensilItems.length - 1]);
        } else {
            alert("Aucun ustensile à supprimer.");
        }
    } else {
        alert("Une erreur est survenue : le conteneur d'ustensiles est introuvable.");
    }
}
		</script>
		<?php include 'rsc/footer.php' ?>
	</body>
</html>