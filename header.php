<?php 
	include ("db.php");
	session_start();
	
	if(empty($_SESSION['lang'])){
		$_SESSION['lang'] = "fr";
	}
	
	include("lang/fr.php");
	if($_SESSION['lang'] == "en"){
		include("lang/en.php");
	}
	if($_SESSION['lang'] == "it"){
		include("lang/it.php");
	}
	
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title><?php echo $page; ?></title>
		<link rel="icon" type="image/png" href="images/favicon.png" />
		<?php
		if(dirname($_SERVER['PHP_SELF']) == "/portfolio/admin"){
			echo '<link rel="stylesheet" href="../styles/PC/'.$page.'.css" />';
			echo '<link rel="stylesheet" href="../styles/PC/default_style.css" />';
			echo '<link rel="icon" type="image/png" href="../images/favicon.png" />';
			// For mobile users 
			echo '<link rel="stylesheet" media="screen and (orientation: portrait)" href="../styles/mobile/default_style.css" />';
			echo '<link rel="stylesheet" media="screen and (orientation: portrait)" href="../styles/mobile/'.$page.'.css" />';
		}
		else{
			echo '<link rel="stylesheet" href="styles/PC/'.$page.'.css" />';
			echo '<link rel="stylesheet" href="styles/PC/default_style.css" />';
			echo '<link rel="icon" type="image/png" href="images/favicon.png" />';
			// For mobile users 
			echo '<link rel="stylesheet" media="screen and (orientation: portrait)" href="styles/mobile/default_style.css" />';
			echo '<link rel="stylesheet" media="screen and (orientation: portrait)" href="styles/mobile/'.$page.'.css" />';
		}
		?>
	</head>

	<body>
		<?php
			if(dirname($_SERVER['PHP_SELF']) == "/portfolio/admin"){
				echo "<header>";
					echo'<nav class="menu">';
						echo'<ul>';
							echo '<a id="accueil" href="index.php"><li>ADMIN INDEX</li></a>';
							echo '<a id="portfolio" href="../index.php"><li>Retour au site</li></a>';
						echo '</ul>';
					echo '</nav>';
				echo '</header>';
			}
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