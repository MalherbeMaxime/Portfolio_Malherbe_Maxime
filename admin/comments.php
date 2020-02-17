<?php
$page = "admin";
include("../header.php");
include("login.php");

	if($_SESSION["admin"] === TRUE){
		
		$sql="SELECT contact.id, comments.user_id, comments.message, contact.entreprise, comments.lang, comments.origin, comments.visible FROM contact, comments WHERE comments.user_id = contact.id AND comments.lang = :lang ORDER by date DESC";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([":lang" => $_GET['lang']]);
		$comments = $stmt->fetchAll();
		
		echo '<h1>Mettre 1 pour rendre le commentaire visible, mettre 0 pour le cacher</h1>';




	if(!empty($_POST)){
		foreach($comments AS $comment){

				
			$sql="UPDATE comments SET visible = :isvisible WHERE user_id = :id";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([":isvisible" => $_POST[$comment['id']], ":id" => $comment['user_id']]);
				
		}
	}

		$sql="SELECT contact.id, comments.user_id, comments.message, contact.entreprise, comments.lang, comments.origin, comments.visible FROM contact, comments WHERE comments.user_id = contact.id AND comments.lang = :lang ORDER by date DESC";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([":lang" => $_GET['lang']]);
		$comments = $stmt->fetchAll();
		
		echo '<form id="order" method="post">';
		
		foreach($comments AS $comment){
			if($comment['visible']==True){
				$ischecked = True;
				}
			else{
				$ischecked = False;
			}
			echo '<div>';
			echo	'<label for="visible">'.$comment['message'].'</label>';
			echo	'<input type="text" id="visible" name="'.$comment['id'].'" value="'.$ischecked.'">';
			echo '</div>';

		}
		
		echo '<div class="button">
				<button type="submit">Modifier !</button>
			 </div>';
		echo '</form>';
		
	}

?>