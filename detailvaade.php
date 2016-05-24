<!DOCTYPE html>
<html>
<head>
    <title>Tuba</title>
    <meta charset="utf-8"/>
</head>

<body>

<?php
if(!isset($_SESSION['kasutaja1'])){ 
    header("Location: Systeem.php?page=logi_sisse");  
}
require_once("funktsioonid.php");
?>
<h1>Tuba nr 
<?php
tuba();
?>
</h1>
<h2>Kirjeldus: 
<?php 
kirjeldus();
?>
</h2>

<?php
	require_once("funktsioonid.php");
	baasi_yhendus();?>
	<h2>Olemasolevad broneeringud</h2>
	<?php $toad = kysi_toad($_GET['ruumi_id']);?>
	<?php
	foreach($toad as $tuba){?>
		<table>
			<tr><td>bronni algus</td><td>bronni lõpp</td></tr>
			<tr><td align ="center"><?php echo $tuba['bronni_algus'];?></td> <td align="center"><?php echo $tuba['bronni_lopp'];?></td></tr>
		</table>
		<?php	
		echo "<br/>";
	}?>
			
	<h2>Lisa broneering</h2>
	<form method="POST" action="">
		<table>
			<tr>
				<td>bronni algus kuupäev</td>
				<td>bronni algus kellaaeg</td>
				<td></td>
				<td>bronni lõpp kellaaeg</td>
				<td>bronni lõpp kuupäev</td>
				<td></td>
			</tr>
			<tr id="dates">
				<td><input name="algus" type="text" class="date start" /></td>
				<td><input name="algus1" type="text" class="time start" /></td>
				<td>kuni</td>
				<td><input name="lopp" type="text" class="time end" /></td>
				<td><input name="lopp1" type="text" class="date end" /></td>
				<td><button name="bronn" type="submit">Kinnita broneering</button></td>
			</tr>
		</table>
		<input type = "hidden" name = "ruum" value = "<?php echo $_GET['ruumi_id']; ?>" />
	</form>
	<meta name="description" content="A javascript plugin for intelligently selecting date and time ranges inspired by Google Calendar." />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	<script src="https://jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="https://jonthornton.github.io/jquery-timepicker/jquery.timepicker.css" />

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.css" />

	<script src="Datepair/lib/moment.min.js"></script>
	<script src="Datepair/lib/site.js"></script>

	<script src="Datepair/dist/datepair.js"></script>
	<script src="Datepair/dist/jquery.datepair.js"></script>
	<script>
		// initialize input widgets first
		$('#dates .time').timepicker({
			'timeFormat': 'H:i',
			'step': 15,
			'showDuration': true,
		});
		$('#dates .date').datepicker({
			'format': 'yyyy-mm-dd',
			'autoclose': true
		});
		// tekitab kuupäevapaari - lõpp ei saa algusest väiksem olla
		var dates = document.getElementById('dates');
		var datepair = new Datepair(dates);
	</script>

<!--kuupäevade kattumiste kontroll-->
<?php
if (isset($_POST['algus'],$_POST['algus1'],$_POST['lopp'],$_POST['lopp1'])) {
	$algus=htmlspecialchars($_POST['algus']);
	$algus1=htmlspecialchars($_POST['algus1']);
	$lopp=htmlspecialchars($_POST['lopp']);
	$lopp1=htmlspecialchars($_POST['lopp1']);
	$ruumi_ID=htmlspecialchars($_POST['ruum']);
	$kp_algus=mysqli_real_escape_string($link,$algus." ".$algus1);
	$kp_lopp=mysqli_real_escape_string($link,$lopp1." ".$lopp);

	$sql = "SELECT COUNT(*) as num FROM mario_broneering
            WHERE(('$kp_algus' <= bronni_algus AND '$kp_lopp' >= bronni_algus)
            OR('$kp_algus' >= bronni_algus AND '$kp_lopp' <= bronni_lopp))
            AND ruumi_id = '$ruumi_ID'";
	$result = mysqli_fetch_array(mysqli_query($link,$sql));
	$ridu_kokku=$result['num'];

	if($ridu_kokku>0){
		echo "Kontrolli aegu";
		exit;
		}
	else{
		baasi_yhendus();
		$kp_algus=strtotime($algus.$algus1);
		$kp_lopp=strtotime($lopp.$lopp1);

		$kp_baasi_algus = date('Y-m-d H:i',$kp_algus);
		$kp_baasi_lopp = date('Y-m-d H:i',$kp_lopp);

		$sql = "INSERT INTO mario_broneering (ruumi_id, kasutaja_id, bronni_algus, bronni_lopp) VALUES(".$ruumi_ID.",".$_SESSION['kasutaja'].", '".$kp_baasi_algus."', '".$kp_baasi_lopp."')";
		$result = mysqli_query($link, $sql);
		//header("Location: Systeem.php?page=detailvaade&ruumi_id=".$_GET["ruumi_id"]);
		?>
		
		<h2>Lisasite järgneva broneeringu</h2>
		<?php
		#kasutaja viimati lisatud broneering
		$sql="SELECT bronni_algus, bronni_lopp FROM mario_broneering WHERE bronni_algus= '" .$kp_baasi_algus."' AND bronni_lopp= '" .$kp_baasi_lopp."' AND ruumi_id= '" .$ruumi_ID."' AND kasutaja_id= ".$_SESSION['kasutaja']."";
		$result=mysqli_query($link, $sql) or die( $sql. " - ". mysqli_error($link));
		while($rida = mysqli_fetch_assoc($result)){
			echo "algus: ".$rida['bronni_algus'];
			echo "</br>";
			echo "lõpp: ".$rida['bronni_lopp'];
			//mysqli_close($link);
		}
	}
}
	
?>

	<form action="Systeem.php?page=logout" method="POST">
		<input type="submit" name="logout" value="Logi välja"/>
	</form>
</body>
</html>