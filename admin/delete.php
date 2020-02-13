<?php
$page = "admin";
include("../header.php");
include("login.php");

	if($_SESSION["admin"] === TRUE){
		if(!empty($_GET['id'])){
			$sql="DELETE FROM portfolio WHERE id = :id";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([":id"=>$_GET['id']]);
		}
	}
	header('Location: index.php');
?>