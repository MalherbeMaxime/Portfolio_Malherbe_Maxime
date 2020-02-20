<?php
	$page = "accueil";
	include("header.php");
	
?>
		<div class="langs">
			<a href="lang.php?lang=fr"><img src="images/flag-fr-openmoji.png" alt="<?php echo $frflag;?>"></a>
			<a href="lang.php?lang=en"><img src="images/flag-gb-openmoji.png" alt="<?php echo $enflag;?>"></a>
			<a href="lang.php?lang=it"><img src="images/flag-it-openmoji.png" alt="<?php echo $itflag;?>"></a>
		</div>
		<div class="contenu">
			<img src="images/photo.webp" alt="<?php echo $photo;?>">
			<p>Maxime Malherbe</p>
		</div>	
		<div class="desc">
		" 
		<?php echo $description;?>
		 "
		</div>
<?php
	include("footer.php");
?>