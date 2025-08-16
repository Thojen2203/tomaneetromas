 <?php session_start();
?>
<!DOCTYPE html>
<html lang="fr">
	<head><?php include 'rsc/head.php';?></head>
	<body>
		<?php include 'rsc/header.php';
		include 'rsc/navmenu.php'; ?>
		<div id="content">
			<div class="center">
				<h1>Connexion à un compte existant</h1>
				<hr>
				<form method="post">
					<label for="lusername">Nom d'utilisateur : </label>
					<input type="text" name="lusername" id="lusername" placeholder="Nom d'utilisateur" required>
					<br>
					<br>
					<label for="lpassword">Mot de passe : </label>
					<input type="password" name="lpassword" id="lpassword" placeholder="Mot de passe" required>
					<br>
					<br>
					<input type="submit" name="login" id="login" value="Se connecter">
					<br><br>
					<!-- <select name="site_login" id="site_login" disabled>
						<optgroup label="Sites">
							<option value="thoweb" selected>Thoweb</option>
							<option value="blog">Blog de Thojen2203</option>
						</optgroup>
						<optgroup label="Autres">
							<option value="support_redirect" disabled>Rediriger vers le support</option>
						</optgroup>
					</select> -->
				</form>
				<p>Vous n'avez pas de compte ? <a href="signup.php">Créez-en un.</a></p>
				<?php
				if(isset($_POST['login'])){
					if (!empty($_POST['lusername']) && !empty($_POST['lpassword'])){
						$q = $db->prepare("SELECT * FROM users WHERE username = :username");
						$q->execute(['username'=> $_POST['lusername']]);
						$result = $q->fetch();
// 						$_USER_INFO = $q -> fetch();
						if ($result == true){
							if (password_verify($_POST['lpassword'], $result['password'])){
								echo "<p>Mot de passe correct.</p><br/>";
								$_SESSION['username'] = $_POST['lusername'];
								$_SESSION['userid'] = $result['id'];
								$_SESSION['font'] = $result['font'];
								echo "<meta http-equiv='Refresh' content='2;URL=index.php'><h1>Mot de passe correct</h1> <a href='index.php'>Y aller maintenant</a></p>";
							}
							else {
								echo "<p>Mot de passe incorrect !</p>";
							}
						}
						else {
							echo "<p>Le compte ayant comme nom d'utilisateur " . $_POST['lusername'] . " n'existe pas.</p>";
						}
					}
					else{
						echo "<p>Vérifiez bien que vous avez entré le nom d'utilisateur et le mot de passe !</p>";
					}
				};
				?>
			</div>
		</div>
		<?php include 'rsc/footer.php'; ?>
	</body>
</html>