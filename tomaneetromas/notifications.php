<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head><?php include 'rsc/head.php';?></head>
	<body>
		<?php include 'rsc/header.php';
		include 'rsc/navmenu.php'; ?>
		<div class="title">Notifications</div>
		<div id="content">
			<?php
			$sql = "SELECT * FROM notifications WHERE recipient_id = ?";
			$q = $db -> prepare($sql);
			$q -> bindParam(1, $_SESSION['userid'], PDO::PARAM_INT);
			$q -> execute();
			foreach ($q -> fetchAll() as $notification) {
				echo "<p><h2>" . $notification['title'] . "</h2></p>";
			}
			?>
		</div>
		<?php include 'rsc/footer.php' ?>
	</body>
</html>