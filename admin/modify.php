<?php
$page = "admin";
include("../header.php");
include("login.php");




	if($_SESSION["admin"] === TRUE){
		
	if(!empty ($_POST)){
		$titre = $_POST['titre'];
		$image = $_POST['image'];
		$contenu = $_POST['contenu'];
	
		$sql="UPDATE portfolio SET titre = :titre, image = :image,  contenu = :contenu WHERE id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([":titre" => $titre, ":image" => $image, ":contenu" => $contenu, ":id" => $_GET['id']]);
	}

	$sql="SELECT * FROM portfolio WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([":id" => $_GET['id']]);
	$article = $stmt->fetch();
		
	echo'
	<form id="formulairecommentaires" method="post">
		<div>
			<label for="titre">Titre :</label>
				<input type="text" id="titre" name="titre" value="'.$article['titre'].'">
		</div>
		<div>
			<label for="image">Image :</label>
			<input type="text" id="image" name="image" value="'.$article['image'].'">
		</div>
		<div>
			<label for="contenu">Contenu :</label>
			<textarea id="contenu" name="contenu">'.$article['contenu'].'</textarea>
		</div>
		<div class="button">
			<button type="submit">Mettre à jour !</button>
		</div>		
	</form>
	';
	echo '<p class="delete"><a class="delete" href=delete.php?id='.$_GET['id'].'>Supprimer</a><p>';
	}
?>