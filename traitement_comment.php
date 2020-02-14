<?php 

	//Importation des class Yandex translator
	use Yandex\Translate\Translator;
	use Yandex\Translate\Translation;
	use Yandex\Translate\Exception;
	// charge l'autoloader de composer
    require 'vendor/autoload.php';
	
	//API key pour Yandex
	$key = "trnsl.1.1.20200214T083539Z.23a9590cce001877.4cdc04d20a9f138428bb132cca2a6cda4a7b3940";
	$translator = new Translator($key);

	
	
	
	
	
	function addComment($user_message, $lang, $pdo, $user, $originLang)
	{
		$sql="INSERT INTO comments (message, user_id, date, lang, origin) VALUES (:user_message, :user_id, NOW(), :lang, :origin)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
		":user_message" => $user_message,
		":user_id" => $user['id'],
		":lang" => $lang,
		":origin" => $originLang]);
	}
	
	
	

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
		$sql="SELECT contact.id, comments.user_id from comments, contact WHERE  comments.user_id = :user_id ";
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
			
			$detectlang = $translator->detect($user_message);
			$originLang = $detectlang;
			addComment($user_message, $detectlang, $pdo, $user, $originLang);
			
			if($detectlang == "fr"){
				$otherlangs = array("en", "it");
				foreach($otherlangs AS $otherlang){
					$translation = $translator->translate($user_message, 'fr-'.$otherlang.'');
					$user_message_translated = $translation;
					addComment($user_message_translated, $otherlang, $pdo, $user, $originLang);
				}
			}

			if($detectlang == "en"){
				$otherlangs = array("fr", "it");
				foreach($otherlangs AS $otherlang){
					$translation = $translator->translate($user_message, 'en-'.$otherlang.'');
					$user_message_translated = $translation;
					addComment($user_message_translated, $otherlang, $pdo, $user, $originLang);
				}
			}
			
			if($detectlang == "it"){
				$otherlangs = array("en", "fr");
				foreach($otherlangs AS $otherlang){
					$translation = $translator->translate($user_message, 'it-'.$otherlang.'');
					$user_message_translated = $translation;
					addComment($user_message_translated, $otherlang, $pdo, $user, $originLang);
				}
			}
			
			if($detectlang != "fr" AND $detectlang != "it" AND $detectlang != "en"){
				$otherlangs = array("en", "fr", "it");
				foreach($otherlangs AS $otherlang){
					$translation = $translator->translate($user_message, ''.$detectlang.'-'.$otherlang.'');
					$user_message_translated = $translation;
					addComment($user_message_translated, $otherlang, $pdo, $user, $originLang);
				}
			}
			
        }
    }
?>