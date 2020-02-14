<?php
$page = "admin";
include("../header.php");
include("login.php");

if(empty($_GET['lang']) OR $_GET['lang'] !="fr" AND $_GET['lang'] !="en" AND $_GET['lang'] !="it"){
	header('Location: index.php?lang=fr');
}

$sql="SELECT * FROM portfolio WHERE lang = :lang ORDER BY ordre ASC, id ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute([":lang" => $_GET['lang']]);
$articles = $stmt->fetchAll();

	if($_SESSION["admin"] === TRUE){
		
		echo'
			<div class="langs">
				<a href="index.php?lang=fr"><img src="../images/flag-fr-openmoji.png" alt="<?php echo $frflag;?>"></a>
				<a href="index.php?lang=en"><img src="../images/flag-gb-openmoji.png" alt="<?php echo $enflag;?>"></a>
				<a href="index.php?lang=it"><img src="../images/flag-it-openmoji.png" alt="<?php echo $itflag;?>"></a>
			</div>';
		
		
		foreach($articles AS $article){
			echo '<a class="lien" href=modify.php?id='.$article['id'].'&lang='.$_GET['lang'].'>'.$article['titre'].'</a>';
		}
		
		echo '<p class="addp"><a class="adda" href="add.php?lang='.$_GET['lang'].'">Ajouter</a></p>';
		echo '<p class="addp"><a class="adda" href="order.php?lang='.$_GET['lang'].'">Ordre</a></p>';
	}
?>