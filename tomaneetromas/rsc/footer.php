<footer>
	<div>
	<table class="table">
		<tr>
			<th>Infos sur le site</th>
		</tr>
		<tr>
			<td>A propos de TomaneetRomas</td>
		</tr>
		<tr>
			<td><a href="whatsnew.php">Notes de mise à jour</a></td>
		</tr>
		<tr>
			<td><a href="progress.php">Progression du développement</a></td>
		</tr>
		<tr>
			<td><a href="cookies_info.php">Informations sur les cookies</a></td>
		</tr>
	</table>
</div>
<div>
	<p>
		Thojen2203 - Site commencé en 2024 - version 1.0
		<?php
		echo "<br>";
		if (!empty($_SESSION['username'])){
			echo "Vous êtes connecté en tant que " . $_SESSION['username'] . ".";
		}
		else {
			echo "Vous n'êtes pas connecté.";
		}
		?></p>
</div>
</footer>