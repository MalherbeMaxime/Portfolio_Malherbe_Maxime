<?php
	$page = "contact";
	$isCorrect = True;
	include("header.php");
	include("traitement_contact.php");
?>
		
		<div class="contform">
			<h2><?php echo $contactMe; ?></h2>
			<form id="formulairecontact" method="post">
			<?php 
			//affiche les éventuelles erreurs de validations
			if (!empty($errors)) {
				echo'<div class="errorsdiv">';
				foreach ($errors as $error) {
					echo '<div class="errors">' . $error . '</div>';
				}
				echo'</div>';
			}
			
			if(!empty($confirmContact)){
				echo '<div style="color:green; font-weight:bold;">'.$confirmContact.'</div>';
			}
			?>
			<!-- Formulaire qui conserve les champs en cas d'erreur -->
			<div>
				<label for="nom"><?php echo $lastName; ?> :</label>
				<input type="text" id="nom" name="nom" required <?php if(!empty($_POST['nom'])){ echo'value="'.$_POST['nom'].'"';}?>>
			</div>
			<div>
				<label for="prenom"><?php echo $firstName; ?> :</label>
				<input type="text" id="prenom" name="prenom" required <?php if(!empty($_POST['prenom'])){ echo'value="'.$_POST['prenom'].'"';}?>>
			</div>
			<div>
				<label for="entreprise"><?php echo $enterprise; ?> :</label>
				<input type="text" id="entreprise" name="entreprise" required <?php if(!empty($_POST['entreprise'])){ echo'value="'.$_POST['entreprise'].'"';}?>>
			</div>
			<div>
				<label for="mail"><?php echo $emailAddress; ?> :</label>
				<input type="email" id="mail" name="mail" required <?php if(!empty($_POST['mail'])){ echo'value="'.$_POST['mail'].'"';}?>>
			</div>
			<div>
				<label for="msg"><?php echo $tr_message; ?> :</label>
				<textarea id="msg" name="message" required><?php if(!empty($_POST['message'])){ echo$_POST['message'];}?></textarea>
			</div>
			<div>
				<label class="txtbuttonCGU" for="CGU"><?php echo $readTOF; ?> :</label>
				<input class="buttonCGU" type="checkbox" id="CGU" name="user_CGU_ok" required>
			</div>
			<div class="g-recaptcha" data-sitekey="6LeRTdoUAAAAACuGk-SiZwYLc1KXZKtQHOCFq9ma"></div> <!-- NEED TO DEFINE A KEY -->
			<div class="button">
				<button type="submit"><?php echo $confirmButton; ?></button> 
			</div>
			</form>
		</div>

<?php
	include("footer.php");
?>