<?php 
	include ("db.php");
	session_start();
	//langue fr par défaut si la session est vide
	if(empty($_SESSION['lang'])){
		//charge les variables françaises
		$_SESSION['lang'] = "fr";
	}
	//ces vérifications ne s'appliquent que si la langue existe 
	include("lang/fr.php");
	if($_SESSION['lang'] == "en"){
		//charge les variables anglaises
		include("lang/en.php");
	}
	if($_SESSION['lang'] == "it"){
		//charge les variables italiennes
		include("lang/it.php");
	}
	
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta name="description" content="Maxime Malherbe, étudiant en développement informatique. Bienvenue sur mon portfolio !">
		<title><?php if($page == "accueil"){ echo "Maxime Malherbe - Portfolio";} else{ echo $page; }?></title>
		<link rel="icon" type="image/png" href="images/favicon.png" />
		<?php
		//Si la page est admin, alors le path vers les styles est différent
		
		if(dirname($_SERVER['PHP_SELF']) == "/admin"){
			echo '<link rel="stylesheet" href="../styles/PC/'.$page.'.css" />';
			echo '<link rel="stylesheet" href="../styles/PC/default_style.css" />';
			echo '<link rel="icon" type="image/png" href="../images/favicon.png" />';
			// Pour les utilisateurs mobile
			echo '<link rel="stylesheet" media="screen and (orientation: portrait), screen and (max-width: 1280px), handheld" href="../styles/mobile/default_style.css" />';
			echo '<link rel="stylesheet" media="screen and (orientation: portrait), screen and (max-width: 1280px), handheld" href="../styles/mobile/'.$page.'.css" />';
			echo '<meta name="robots" content="noindex" />';
		}
		
		if($page == "404"){
			echo '<link rel="stylesheet" href="styles/PC/'.$page.'.css" />';
			echo '<link rel="stylesheet" href="styles/PC/default_style.css" />';
			echo '<link rel="icon" type="image/png" href="../images/favicon.png" />';
			// Pour les utilisateurs mobile
			echo '<link rel="stylesheet" media="screen and (orientation: portrait)" href="styles/mobile/default_style.css" />';
			echo '<link rel="stylesheet" media="screen and (orientation: portrait)" href="styles/mobile/'.$page.'.css" />';
			//permet de ne pas indexer la page 404
			echo '<meta name="robots" content="noindex" />';
		}
		else{
			echo '<link rel="stylesheet" href="styles/PC/'.$page.'.css" />';
			echo '<link rel="stylesheet" href="styles/PC/default_style.css" />';
			echo '<link rel="icon" type="image/png" href="images/favicon.png" />';
			// Pour les utilisateurs mobile 
			echo '<link rel="stylesheet" media="screen and (orientation: portrait), screen and (max-width: 1280px), handheld" href="styles/mobile/default_style.css" />';
			echo '<link rel="stylesheet" media="screen and (orientation: portrait), screen and (max-width: 1280px), handheld" href="styles/mobile/'.$page.'.css" />';
			echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';

		}
		?>
	</head>

	<body>
		<?php
			//si la page est dans le dossier admin, alors on affiche une barre de navigation différente
			if(dirname($_SERVER['PHP_SELF']) == "/admin"){
				echo "<header>";
					echo'<nav class="menu">';
						echo'<ul>';
							echo '<a id="accueil" href="index.php?lang='.$_GET['lang'].'"><li>ADMIN INDEX</li></a>';
							echo '<a id="accueil" href="comments.php?lang='.$_GET['lang'].'"><li>Commentaires</li></a>';
							echo '<a id="portfolio" href="../index.php"><li>Retour au site</li></a>';
						echo '</ul>';
					echo '</nav>';
				echo '</header>';
			}
			//barre de navigation par défaut
			else{
				echo "<header>";
					echo'<nav class="menu">';
						echo'<ul>';
							echo '<a id="portfolio" href="portfolio.php"><li>'.$about.'</li></a>';
							echo '<a id="accueil" href="index.php"><li>'.$home.'</li></a>';
							echo '<a id="contact" href="contact.php"><li>'.$contact.'</li></a>';
						echo '</ul>';
					echo '</nav>';
				echo '</header>';
			}
			?>