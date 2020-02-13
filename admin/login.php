<?php
	
	if(empty($_SESSION["admin"])){
		$_SESSION["admin"] = False;
	}
	
	if(!empty($_POST) AND !empty($_POST['admin_mail']) AND !empty($_POST['admin_pass'])){
		$mail = $_POST['admin_mail'];
		$mdp = $_POST['admin_pass'];
		
		if($mail == "maximemalherbe5@gmail.com" AND $mdp == "test1234"){
			$_SESSION["admin"] = TRUE;
		}
		else{
			echo 'Mauvais identifiants';
		}
	}
	
	if($_SESSION["admin"] === False){	
		
		echo '<div class="contain">';
		echo		 '<form id="formadmin" method="post">';
		echo	 '<div>';
		echo		'<label for="admin_mail">Adresse e-mail :</label>';
		echo		'<input type="email" id="admin_mail" name="admin_mail">';
		echo	 '</div>';
		echo	 '<div>';
		echo		'<label for="admin_pass">MDP :</label>';
		echo		'<input type="password" id="admin_pass" name="admin_pass">';
		echo 	'</div>';
		echo 	'<div class="button">';
		echo		'<button type="submit">Valider</button>';
		echo 	'</div>';
		echo 	'</form>';
		echo '</div>';
	}
?>