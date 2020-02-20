<?php
	$page = "portfolio";
	$isCorrect = True;
	include("header.php");
	include("traitement_comment.php");
	
		$sql="SELECT contact.id, comments.user_id, comments.message, contact.entreprise, comments.lang, comments.origin FROM contact, comments WHERE comments.user_id = contact.id AND comments.lang = :lang AND comments.visible = True";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([":lang" => $_SESSION['lang']]);
		$commentaires = $stmt->fetchAll();
		
		
		$sql="SELECT * FROM portfolio WHERE lang = :lang ORDER BY ordre ASC, id ASC";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([":lang" => $_SESSION['lang']]);
		$articles = $stmt->fetchAll();
	
	
?>

<?php
	
// La vidéo n'étant disponible qu'en français, je ne l'affiche que lorsque la langue correspond au français
	if($_SESSION['lang'] == "fr"){
		echo'
			<div class="video" disablePictureInPicture controlsList="nodownload">
				<video controls>
					<source src="/videos/presentation.mp4" type="video/mp4">
				</video>
			</div>';
	}
?>
		
			<!-- ------------------------------------------------ -->
		
		<div class="menunav">
			<ul>
			<?php
			//menu créant des références vers les titres des articles
			foreach($articles AS $article){
				echo '<li><a class="navbutton" href="#'.$article['titre'].'">'.$article['titre'].'</a></li>';
			}
			?>
			</ul>
		</div>
			<!-- ------------------------------------------------ -->
		<div class="cv">
		<?php
		//affiche les articles du portfolio
		foreach($articles AS $article){
			echo '<article>';
			echo '<h2 id="'.$article['titre'].'">'.$article['titre'].'</h2>';
			echo '<div class="illustration" style='."'".'background-image:url("'.$article['image'].'");'."'".'></div>';
			echo '<p>'.$article['contenu'].'</p>';
			echo '</article>';
		}
		?>
		</div>
		
		<!-- ------------------------------------------------ -->
		
		<div class="commentaires"> <!-- Les commentaires seront ajoutés automatiquement grâce à du php -->
			<h2><?php echo $recommendation; ?></h2>
			
			<?php
			//si il n'y a pas de commentaire, on l'affiche à l'utilisateur
			if(empty($commentaires)){
				echo '<div class="com">';
				echo $noComment;
				echo '</div>';
			}
			//affichage des commentaires
			foreach($commentaires as $commentaire){
				echo '<div class="com">';
				echo 	'"'.$commentaire['message'].'"';
				echo	'<div class="nomentreprise">';
				echo	$commentaire['entreprise'];
				echo	'</div>';
				if($commentaire['lang'] != $commentaire['origin']){
					echo '<span class="infoTranslated"><span class="translated">('.$wasTranslated.'</span> | <a class="yandex" href="http://translate.yandex.com" target="_blank">Powered by Yandex</a> <span class="translated">)</span></span>';
				}
				echo '</div>';
				
			}
			
			
			?>
			
			<!-- ------------------------------------------------ -->
			
			<h2><?php echo $postComment; ?></h2>
			
				<?php 
				//affiche les éventuelles erreurs de validations
				if (!empty($errors)) {
					echo'<div class="errorsdiv">';
					foreach ($errors as $error) {
						echo '<div class="errors">' . $error . '</div>';
					}
					echo '</div>';
				}   
				?>
				
			<form id="formulairecommentaires" method="post">
			<div>
				<label for="mail"><?php echo $emailAddress; ?> :</label>
				<input type="email" id="mail" name="user_mail"<?php if(!empty($_POST['user_mail']) AND !empty($errors)){ echo'value="'.$_POST['user_mail'].'"';}?>>
			</div>
			<div>
				<label for="msg"><?php echo $tr_message; ?> :</label>
				<textarea id="msg" name="user_message"><?php if(!empty($_POST['user_message']) AND !empty($errors)){ echo$_POST['user_message'];}?></textarea>
			</div>
			<div class="g-recaptcha" data-sitekey="6LeRTdoUAAAAACuGk-SiZwYLc1KXZKtQHOCFq9ma"></div> <!-- PENSER A DEFINIR UNE CLE LORS DE LA MISE EN LIGNE DU SITE -->
			<div class="button">
				<button type="submit"><?php echo $confirmButton; ?></button> <!-- Ajouter une case à cocher pour valider la lecture des CGU -->
			</div>
			
			
			</form>
		</div>
		
<?php
	include("footer.php");
?>