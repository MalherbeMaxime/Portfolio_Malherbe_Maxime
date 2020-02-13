<?php
$page = "admin";
include("../header.php");
include("login.php");

$sql="SELECT * FROM portfolio ORDER BY ordre ASC, id ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$articles = $stmt->fetchAll();

	if($_SESSION["admin"] === TRUE){
		
		foreach($articles AS $article){
			echo '<a class="lien" href=modify.php?id='.$article['id'].'>'.$article['titre'].'</a>';
		}
		
		echo '<p class="addp"><a class="adda" href="add.php">Ajouter</a></p>';
		echo '<p class="addp"><a class="adda" href="order.php">Ordre</a></p>';
	}
?>