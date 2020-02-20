<?php
//Page de redirection passant la langue de GET à SESSION
	$page = "accueil";
	include("header.php");
	
	$_SESSION['lang'] = $_GET['lang'];
	
	header('Location: index.php');
	
	include("footer.php");
?>