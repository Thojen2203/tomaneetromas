<?php
session_start();
include 'database.php';
global $db;

if (isset($_POST['font'])){
	$q = $db -> prepare("UPDATE users SET font=:new_font WHERE id=:uid");
	$q -> execute([
		"new_font" => $_POST['font'],
		"uid" => $_SESSION['userid']
	]);
	$_SESSION['font'] = $_POST['font'];
	header("Location: ../interface_settings.php");
}
if (isset($_POST['theme'])){
	$q = $db -> prepare("UPDATE users SET theme=:new_theme WHERE id=:uid");
	$q -> execute([
		"new_theme" => $_POST['theme'],
		"uid" => $_SESSION['userid']
	]);
	$_SESSION['theme'] = $_POST['theme'];
	header("Location: ../interface_settings.php");
}


?>