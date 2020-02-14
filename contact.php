<?php
	$page = "contact";
	include("header.php");
	include("traitement_contact.php");
?>
		
		<div class="contform">
			<h2><?php echo $contactMe; ?></h2>
			<form id="formulairecontact" method="post">
			<div>
				<label for="nom"><?php echo $lastName; ?> :</label>
				<input type="text" id="nom" name="nom" required>
			</div>
			<div>
				<label for="prenom"><?php echo $firstName; ?> :</label>
				<input type="text" id="prenom" name="prenom" required>
			</div>
			<div>
				<label for="entreprise"><?php echo $enterprise; ?> :</label>
				<input type="text" id="entreprise" name="entreprise">
			</div>
			<div>
				<label for="mail"><?php echo $emailAddress; ?> :</label>
				<input type="email" id="mail" name="mail" required>
			</div>
			<div>
				<label for="msg"><?php echo $tr_message; ?> :</label>
				<textarea id="msg" name="message" required></textarea>
			</div>
			<div>
				<label class="txtbuttonCGU" for="CGU"><?php echo $readTOF; ?> :</label>
				<input class="buttonCGU" type="checkbox" id="CGU" name="user_CGU_ok" required>
			</div>
			<script src="https://www.google.com/recaptcha/api.js" async defer></script>
			<div class="g-recaptcha" data-sitekey="CHANGER"></div> <!-- NEED TO DEFINE A KEY -->
			<div class="button">
				<button type="submit"><?php echo $confirmButton; ?></button> 
				<?php 
				//affiche les éventuelles erreurs de validations
				if (!empty($errors)) {
				foreach ($errors as $error) {
                echo '<div class="errors">' . $error . '</div>';
				}
			}   
        ?>
			</div>
			</form>
		</div>

<?php
	include("footer.php");
?>