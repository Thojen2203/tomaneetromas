<?php
session_start();
include 'database.php';
global $db;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipe_name = $_POST['recipe-name'] ?? '';
    $preparation_time = $_POST['preparation-time'] ?? 0;
    $cooking_time = $_POST['cooking-time'] ?? 0;
    $pers_nb = $_POST['pers-nb'] ?? 0;
    $ingredients = $_POST['ingredients'] ?? [];
    $quantities = $_POST['qty'] ?? [];
    $units = $_POST['ingredients-unit'] ?? [];
    $utensils = $_POST['utensils'] ?? [];

    // Validation des données (à implémenter selon vos besoins)

    // Commencer une transaction
    $db->beginTransaction();

    try {
        // Insertion dans la table recipes
        $stmt = $db->prepare("INSERT INTO recipes (recipe_name, prep_time, cooking_time, pers, userid) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$recipe_name, $preparation_time, $cooking_time, $pers_nb, $_SESSION['userid']]);
        $recipe_id = $db->lastInsertId();
        // $stmt->close();

        // Préparer les valeurs pour la requête des ingrédients
        $ingredient_values = [];
        foreach ($ingredients as $index => $ingredient) {
            $quantity = $quantities[$index];
            $unit = $units[$index];
            $ingredient_values[] = "($recipe_id, ?, ?, ?)";
        }

        // Insertion en une seule requête dans la table ingredients
        if (!empty($ingredient_values)) {
            $ingredient_values_str = implode(", ", $ingredient_values);
            $stmt = $db->prepare("INSERT INTO ingredients (recipe_id, quantity, unit, name) VALUES $ingredient_values_str");
            foreach ($ingredients as $index => $ingredient) {
                $stmt->bindValue(($index * 3) + 1, $quantities[$index]);
                $stmt->bindValue(($index * 3) + 2, $units[$index]);
                $stmt->bindValue(($index * 3) + 3, $ingredient);
            }
            $stmt->execute();
        }

        // Préparer les valeurs pour la requête des ustensiles
        $utensil_values = [];
        foreach ($utensils as $utensil) {
            $utensil_values[] = "($recipe_id, ?)";
        }

        // Insertion en une seule requête dans la table utensils
        if (!empty($utensil_values)) {
            $utensil_values_str = implode(", ", $utensil_values);
            $stmt = $db->prepare("INSERT INTO utensils (recipe_id, name) VALUES $utensil_values_str");
            foreach ($utensils as $index => $utensil) {
                $stmt->bindValue($index + 1, $utensil);
            }
            $stmt->execute();
        }

        // Insertion de la préparation dans la table des préparations
        $q = $db -> prepare("INSERT INTO preparations (recipe_id, preparation) VALUES (:recipe_id,:preparation)");
        $q -> execute([
            "recipe_id" => $recipe_id,
            "preparation" => $_POST['preparation']
        ]);

        // Committer la transaction
        $db->commit();

        echo "Recette ajoutée avec succès!";
    } catch (Exception $e) {
        // En cas d'erreur, annuler la transaction
        $db->rollBack();
        echo "Erreur lors de l'ajout de la recette : " . $e->getMessage();
    }
}
