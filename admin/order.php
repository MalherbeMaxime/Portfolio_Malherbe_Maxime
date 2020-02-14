<?php
$page = "admin";
include("../header.php");
include("login.php");

	if($_SESSION["admin"] === TRUE){
		
		$sql="SELECT * FROM portfolio WHERE lang = :lang ORDER BY ordre ASC, id ASC";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([":lang" => $_GET['lang']]);
		$articles = $stmt->fetchAll();
		
		if(!empty($_POST)){
			foreach($articles AS $article){
			
				$sql="UPDATE portfolio SET ordre = :number WHERE id = :id";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([":number" => $_POST[$article['id']], ":id" => $article['id']]);
				
			}
			
			header('Location: index.php');
		}
		
		
		echo '<form id="order" method="post">';
		
		foreach($articles AS $article){
			echo '<div>
					<label for="ordre">'.$article['titre'].'</label>
					<input type="number" id="ordre" name="'.$article['id'].'" value="'.$article['ordre'].'">
				  </div>';
		}
		echo '<div class="button">
				<button type="submit">Modifier !</button>
			 </div>';
		echo '</form>';
		
	}

?>