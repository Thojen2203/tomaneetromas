<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head><?php include 'rsc/head.php';?></head>
	<body>
		<?php include 'rsc/header.php';
		include 'rsc/navmenu.php'; ?>
		<div id="content">
			<div class="center">
				<h1>Créer un compte</h1>
				<hr>
				<form method="post">
					<label for="username">Nom d'utilisateur :</label>
					<input type="text" name="username" id="username" placeholder="Nom d'utilisateur (requis)" required>
					<br><br>
					<label for="first_name">Prénom :</label>
					<input type="text" name="first_name" id="first_name" placeholder="Prénom (requis)" required>
					<br><br>
					<label for="last_name">Nom de famille :</label>
					<input type="text" name="last_name" id="last_name" placeholder="Nom de famille (requis)" required>
					<br><br>
					<label for="birth_date">Date de naissance :</label>
					<input type="date" name="birth_date" id="birth_date" placeholder="Date de naissance" min="1901-01-01" max="2038-01-19" required>
					<br><br>
					<label for="password">Mot de passe :</label>
					<input type="password" name="password" id="password" placeholder="Mot de passe (requis)" required>
					<br><br>
					<label for="passwordconfirm">Confirmez le mot de passe :</label>
					<input type="password" name="passwordconfirm" id="passwordconfirm" placeholder="Confirmez le mot de passe (requis)" required>
					<br><br>
					<label for="send">Créer le compte :</label>
					<input type="submit" name="send" id="send" value="Créer mon compte">
				</form>
				<p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous.</a></p>
			</div>
		</div>
		<?php 
		// $q = $db->query("SELECT * FROM users ORDER BY created DESC");
		// while ($user = $q->fetch()){
		// 	echo "created : " . $user['created'] . " username : " . $user['username'] . "<br>";
		// }
		if(isset($_POST['send'])){
			if(($_POST['passwordconfirm']=$_POST['password']) && !empty($_POST['username'])){
				$c = $db->prepare("SELECT username FROM users WHERE username = :username");
				$c->execute([
					'username'=> $_POST['username']
				]);
				$result = $c->rowCount();
				if ($result == 0){
					$q = $db->prepare("INSERT INTO users(username,password,first_name,last_name,bday, font, theme) VALUES(:username,:password,:first_name,:last_name,:birth_day, :font, :theme)");
					$hashpw = password_hash($_POST['password'], PASSWORD_BCRYPT);
					$q->execute([
						'username' => $_POST['username'],
						'password' => $hashpw,
						'first_name' => $_POST['first_name'],
						'last_name' => $_POST['last_name'],
						'birth_day' => $_POST['birth_date'],
						'font' => "Inter",
						'theme' => "light"
					]);
/*					$notif_icon = "person_add";
					$notif_title = "Compte créé";
					$notif_content = "Votre compte a été créé avec succès.";
					$a = $db -> prepare("INSERT INTO notifications(user_id,icon,title,content,is_read) VALUES (:userid, :icon, :titre, :contenu, 0)");
					$a -> execute([
						"userid" => $_SESSION['userid'],
						"icon" => $notif_icon,
						"titre" => $notif_title,
						"contenu" => $notif_content
					]);*/

				echo "Votre compte a été créé !";
				}
				else {
					echo "Un compte utilisateur existe déjà avec ce nom d'utilisateur.";
				}
			}
			else {
				echo "Un ou des champs sont vides, ou les mots de passe entrés ne sont pas les mêmes. Veuillez réessayer.";
			};
		}
		?>
		<?php include 'rsc/footer.php'; ?>
	</body>
</html>