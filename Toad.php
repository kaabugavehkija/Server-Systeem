<!doctype html>
<html>
	<head>
		<title>Toad</title>
		<link rel="stylesheet" type = "text/css" href="dv_toad.css">
		<meta charset="utf-8">
	</head>
	<body>
		<?php
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		if(!isset($_SESSION['kasutaja1'])){ 
			header("Location: Systeem.php?page=logi_sisse");  
		}
		?>
		<p>Sisse loginud kasutaja <?php echo $_SESSION['kasutaja1'];?></p>

		<h1>Olemasolevad toad:</h1>
		<p>Kliki toanumbri peal täpsemate andmete saamiseks</p>
		
		<!--väljalogimise nupp-->
		<form id = "form2" action="Systeem.php?page=logout" method="POST">
		</form>
		<button class = "logout" type = "submit" form = "form2" value="Submit">Logi välja</button>
		
		<p>
		<?php
		require_once("funktsioonid.php");
		$toad = naita_tuba();
		foreach($toad as $tuba){?>
			<a href="Systeem.php?page=detailvaade&ruumi_id=<?php echo $tuba["ruumi_id"];?>">Tuba nr: <?php echo $tuba['ruumi_number'];?></a>
			<?php echo '<br/>';	
		}?>
		</p>
	</body>
</html>