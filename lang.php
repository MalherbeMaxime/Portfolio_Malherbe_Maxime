<?php
	$page = "accueil";
	include("header.php");
	
	$_SESSION['lang'] = $_GET['lang'];
	
	header('Location: index.php');
?>