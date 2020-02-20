<?php 
	if($isCorrect != True){
		header('Location: 404.php');
	}


	//Importation des class Yandex translator
	use Yandex\Translate\Translator;
	use Yandex\Translate\Translation;
	use Yandex\Translate\Exception;
	// charge l'autoloader de composer
    require 'vendor/autoload.php';
	
	//API key pour Yandex
	$key = "trnsl.1.1.20200214T083539Z.23a9590cce001877.4cdc04d20a9f138428bb132cca2a6cda4a7b3940";
	$translator = new Translator($key);

	
	
	
	
	//ajout d'un commentaire dans la BDD
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
			$errors[] = $mustContactBeforeReview;
		}

		if(!empty($message["user_id"])){
            $formIsValid = false;
            $errors[] = $onlyOneReview;
		}

		//si le message est vide
        if(empty($user_message) ){ 
            $formIsValid = false;
            $errors[] = $noReview;
        }
        elseif(mb_strlen($user_message) <= 2){
            $formIsValid = false;
            $errors[] = $reviewTooShort;
        }
        elseif(mb_strlen($user_message) > 1500){
            $formIsValid = false;
            $errors[] = $reviewTooLong;
        }

        //validation de l'user_mail
        if(!filter_var($user_mail, FILTER_VALIDATE_EMAIL)){
            $formIsValid = false;
            $errors[] = $emailIsInvalid;
        }
		
		if(empty($_POST['g-recaptcha-response'])){
			$formIsValid = false;
            $errors[] = $invalidCaptcha;
		}

        //si le formulaire est toujours valide on vérifie la langue du commentaire afin de le traduire (penser à faire une fonction plus tard)
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