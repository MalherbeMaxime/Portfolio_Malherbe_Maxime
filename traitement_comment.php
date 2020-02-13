<?php 
    //si on a des données dans $_POST, 
    //c'est que le form a été soumis
    if(!empty($_POST)){
        //par défaut, on dit que le formulaire est entièrement valide
        //si on trouve ne serait-ce qu'une seule erreur, on 
        //passera cette variable à false
        $formIsValid = true;

        $user_mail = strip_tags($_POST['user_mail']);
		$user_message = strip_tags($_POST['user_message']);
		
		
		$sql="SELECT contact.id, contact.email, contact.entreprise from contact WHERE contact.email = :user_mail";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([":user_mail" => $user_mail]);
		$user = $stmt->fetch();
		
		if(!empty($user['id'])){
		$sql="SELECT contact.id, commentairemessage.user_id from commentairemessage, contact WHERE  commentairemessage.user_id = :user_id ";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([":user_id" => $user['id']]);
		$message = $stmt->fetch();
		}
		

        //tableau qui stocke nos éventuels messages d'erreur
        $errors = [];
		//vérifie si l'utilisateur m'a déjà contacté en vérifiant la présence de son mail dans la BDD
		if(empty($user["email"])){
			$formIsValid = false;
			$errors[] = "Vous devez me contacter au moins une fois via la page de contact avant de laisser un avis !";
		}

		if(!empty($message["user_id"])){
            $formIsValid = false;
            $errors[] = "Vous ne pouvez poster qu'un avis !";
		}

		//si le message est vide
        if(empty($user_message) ){ 
            $formIsValid = false;
            $errors[] = "Veuillez entrer un avis !";
        }
        elseif(mb_strlen($user_message) <= 2){
            $formIsValid = false;
            $errors[] = "Votre avis est trop court !";
        }
        elseif(mb_strlen($user_message) > 1500){
            $formIsValid = false;
            $errors[] = "Votre avis est trop long !";
        }

        //validation de l'user_mail
        if(!filter_var($user_mail, FILTER_VALIDATE_EMAIL)){
            $formIsValid = false;
            $errors[] = "Votre email n'est pas valide !";
        }

        //si le formulaire est toujours valide... 
        if ($formIsValid == true){
			
			$sql="INSERT INTO commentairemessage (message, user_id, date) VALUES (:user_message, :user_id, NOW())";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([
			":user_message" => $user_message,
			":user_id" => $user['id'],
			]);
			
        }
    }
?>