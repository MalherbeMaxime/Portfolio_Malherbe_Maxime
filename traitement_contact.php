<?php 

	if($isCorrect != True){
		header('Location: 404.php');
	}

    // Importation des class PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // charge l'autoloader de composer
    require 'vendor/autoload.php';

    //si on a des données dans $_POST, 
    //c'est que le form a été soumis
    if(!empty($_POST)){
        //par défaut, on dit que le formulaire est entièrement valide
        //si on trouve ne serait-ce qu'une seule erreur, on 
        //passera cette variable à false
        $formIsValid = true;

        $user_mail = strip_tags($_POST['mail']);
        $user_nom = strip_tags($_POST['nom']);
        $user_prenom = strip_tags($_POST['prenom']);
		$user_entreprise = strip_tags($_POST['entreprise']);
		$user_message = strip_tags($_POST['message']);
		

        //tableau qui stocke nos éventuels messages d'erreur
        $errors = [];

        //si le user_nom est vide...
        if(empty($user_nom) ){
            //on note qu'on a trouvé une erreur ! 
            $formIsValid = false;
            $errors[] = $noLastName;
        }
        //mb_strlen calcule la longueur d'une chaîne
        elseif(mb_strlen($user_nom) <= 1){
            $formIsValid = false;
            $errors[] = $lastNameTooShort;
        }
        elseif(mb_strlen($user_nom) > 50){
            $formIsValid = false;
            $errors[] = $lastNameTooLong;
        }

        //exactement pareil pour le prénom
        //si le user_prenom est vide...
        if(empty($user_prenom) ){
            //on note qu'on a trouvé une erreur ! 
            $formIsValid = false;
            $errors[] = $noFirstName;
        }
        //mb_strlen calcule la longueur d'une chaîne
        elseif(mb_strlen($user_prenom) <= 1){
            $formIsValid = false;
            $errors[] = $firstNameTooShort;
        }
        elseif(mb_strlen($user_prenom) > 50){
            $formIsValid = false;
            $errors[] = $firstNameTooLong;
        }

        //validation de l'user_mail
        if(!filter_var($user_mail, FILTER_VALIDATE_EMAIL)){
            $formIsValid = false;
            $errors[] = $emailIsInvalid;
        }

        if(empty($user_entreprise) ){
            //on note qu'on a trouvé une erreur ! 
            $formIsValid = false;
            $errors[] = $noEnterpriseName;
        }

		if(empty($_POST['g-recaptcha-response'])){
			$formIsValid = false;
            $errors[] = $invalidCaptcha;
		}

        //si le formulaire est toujours valide on insert les données dans la BDD
        if ($formIsValid == true){
			$sql="INSERT INTO contact (prenom, nom, entreprise, email) VALUES (:user_prenom, :user_nom, :user_entreprise, :user_mail)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([
			":user_prenom" => $user_prenom,
			":user_nom" => $user_nom,
			":user_entreprise" => $user_entreprise,
			":user_mail" => $user_mail,
			]);
			
			$sql="SELECT id from contact WHERE email = :user_mail";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([":user_mail" => $user_mail]);
			$id = $stmt->fetch();
			
			$sql="INSERT INTO contactmessage (message, date, user_id) VALUES (:user_message, NOW(), :user_id)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([
			":user_message" => $user_message,
			":user_id" => $id["id"],
			]);


			//si le formulaire est soumis on envoie un mail à moi et à l'utilisateur ayant soumit le formulaire
			if (!empty($_POST)){

				// Instantiation and passing `true` enables exceptions
				$mail = new PHPMailer(true);

					//Server settings
					$mail->Encoding = 'base64';
					$mail->CharSet = 'UTF-8';
					$mail->isSMTP();                                            // Send using SMTP            
					$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
					$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
					$mail->Username   = 'malherbe.notifs@gmail.com';                     // SMTP username
					$mail->Password   = 'KrkZ2255';                               // SMTP password
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
					$mail->Port       = 587;                                    // TCP port to connect to

					//Recipients
					$mail->setFrom('malherbe.notifs@gmail.com', $user_prenom." ".$user_nom);
					$mail->addAddress("maximemalherbe5@gmail.com", "Maxime Malherbe");     // Add a recipient

					// Content
					$mail->isHTML(true);                                  // Set email format to HTML
					$mail->Subject = "Message de ".$user_nom;
					$mail->Body    = 'De: <span style="font-weight:bold;">'.$user_prenom.' '.$user_nom.'</span><br>email:<span>'.$user_mail."</span><br>Entreprise: <span style='font-weight:bold;'> ".$user_entreprise."</span><br><br><p style='white-space: pre-wrap; font-size:1.2em;'>".$user_message."</p>";

					$mail->send();
					
					//--------------------------------------
					
					//Recipients
					$mail->ClearAllRecipients( );
					$mail->setFrom('maximemalherbe5@gmail.com', "Maxime Malherbe");
					$mail->addAddress($user_mail, $user_nom." ".$user_prenom);     // Add a recipient

					// Content
					$mail->isHTML(true);                                  // Set email format to HTML
					$mail->Subject = $confirmMail;
					$mail->Body    = '<h1 style="background-color:#2B75EB; padding:10px; color:white; text-align:center;">'.$requestAccepted.'</h1><br><br>'.$sentContactMessage.'<br><p style="color:black; white-space:pre-wrap; background-color: #E5E5E5;">'.$user_message.'</p><div style="background-color:#2B75EB; height:10px;"></div>';
					$mail->send();
					
					unset($_POST);
					$confirmContact = $confirmContactMessage;
			}
			
        }
    }
?>