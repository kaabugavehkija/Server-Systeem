<!doctype html>
<html>
	<head>
		<title>Toad</title>
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
		<p>kliki toanumbri peal täpsemate andmete saamiseks</p>
		<?php
		require_once("funktsioonid.php");
		baasi_yhendus();
		$sql = "SELECT * FROM mario_ruumid";
		$result = mysqli_query($link, $sql);

		while($rida=mysqli_fetch_assoc($result)){
			$toad=array();
			$toad[]=$rida;
			foreach($toad as $tuba){?>
				<a href="Systeem.php?page=detailvaade&ruumi_id=<?php echo $tuba["ruumi_id"];?>">Tuba nr: <?php echo $tuba['ruumi_number'];?></a>
				<?php echo '<br/>';	
		}
		}?>
		<form action="Systeem.php?page=logout" method="POST">
			<input type="submit" name="logout" value="Logi välja"/>
		</form>

	</body>
</html>