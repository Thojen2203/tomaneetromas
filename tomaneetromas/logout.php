<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head><?php include 'rsc/head.php';?></head>
	<body>
		<p>Vous allez être déconnecté... Veuillez patienter.</p>
		<?php unset($_SESSION['username']); unset($_SESSION['userid']); unset($_SESSION['font']);
		header('Location: welcome.php');
		?>
	</body>
</html>