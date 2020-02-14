<?php
$page = "admin";
include("../header.php");
include("login.php");

	if($_SESSION["admin"] === TRUE){

	if(empty($_POST['titre'])){
		$_POST['titre']="";	
	}
	if(empty($_POST['image'])){
		$_POST['image']="";	
	}
	if(empty($_POST['contenu'])){
		$_POST['contenu']="";	
	}

	if($_POST['titre']!="" AND $_POST['image']!="" AND $_POST['contenu']!=""){
		$titre = $_POST['titre'];
		$image = $_POST['image'];
		$contenu = $_POST['contenu'];
		
		$sql="SELECT COUNT(*) AS nb FROM portfolio WHERE lang = :lang";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([":lang" => $_GET['lang']]);
		$nb = $stmt->fetch();
		$number = $nb['nb'] + 1;
	
		$sql="INSERT INTO portfolio (titre, image, contenu, ordre, lang) VALUES (:titre, :image, :contenu, $number, :lang)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([":titre" => $titre, ":image" => $image, ":contenu" => $contenu, ":lang" => $_GET['lang']]);
		
		header('Location: index.php?lang='.$_GET['lang'].'');
	}
		
	echo'
	<form id="formulairecommentaires" method="post">
		<div>
			<label for="titre">Titre :</label>
				<input type="text" id="titre" name="titre" value="'.$_POST['titre'].'">
		</div>
		<div>
			<label for="image">Image :</label>
			<input type="text" id="image" name="image" value="'.$_POST['image'].'">
		</div>
		<div>
			<label for="contenu">Contenu :</label>
			<textarea id="contenu" name="contenu">'.$_POST['contenu'].'</textarea>
		</div>
		<div class="button">
			<button type="submit">Ajouter !</button>
		</div>		
	</form>
	';
	}

?>