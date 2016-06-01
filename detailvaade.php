<!DOCTYPE html>
<html>
<head>
    <title>Tuba</title>
	<link rel="stylesheet" type = "text/css" href="dv_toad.css">
    <meta charset="utf-8"/>
</head>

<body>
<?php
if(!isset($_SESSION['kasutaja1'])){ 
    header("Location: Systeem.php?page=logi_sisse"); 
	var_dump($_GET['bronni_id']);
}
require_once("funktsioonid.php");
?>
<h1>Tuba nr <?php tuba();?></h1>
<h2>Kirjeldus: <?php kirjeldus();?></h2>

<?php
	require_once("funktsioonid.php");
	baasi_yhendus();?>
	<h3>Olemasolevad broneeringud</h3>
	<?php $toad = kysi_toad($_GET['ruumi_id']);?>
		
	<?php if ($_SESSION['roll']=='admin' && !empty($toad)){
		echo "<table border='1' cellpadding='10'>";
		echo "<tr><th>Jrk</th><th>Bronni algus</th><th>Bronni lõpp</th><th>Kustuta</th></tr>";
		$i=0;
		foreach($toad as $tuba){
			$i++;
			echo "<tr>";
			echo "<td>";
			echo $i;
			echo "</td>";
			echo "<td>".$tuba['bronni_algus']."</td>";
			echo "<td>".$tuba['bronni_lopp']."</td>";
			?>
			
				<td id="c">
					<form method="POST" action="Systeem.php?page=kustuta&ruumi_id=<?php echo $tuba['ruumi_id']?>">
					<input type="hidden"  name = "kp" id="kp" value = "<?php echo $tuba['bronni_id']; ?>" />
					
					<input id ="kustuta" type="submit" value="Kustuta">
					</form>
				</td>
				</tr>

				<?php ;}?>
			</table>
		<?php ;}
		else{
		echo "<table border='1' cellpadding='10'>";
			echo "<tr><th>Jrk</th><th>Bronni algus</th><th>Bronni lõpp</th></tr>";
			$i=0;
			foreach($toad as $tuba){
				$i++;
				echo "<tr>";
				echo "<td>";
				echo $i;
				echo "</td>";
				echo "<td>".$tuba['bronni_algus']."</td>";
				echo "<td>".$tuba['bronni_lopp']."</td>";
				echo "<tr>";
			}
			}?>
		</table>
		
		<h3>Lisa broneering</h3>
		<form method="POST" action="">
			<table>
				<tr>
					<td>Bronni algus kuupäev</td>
					<td>Bronni algus kellaaeg</td>
					<td></td>
					<td>Bronni lõpp kellaaeg</td>
					<td>Bronni lõpp kuupäev</td>
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
	
		<!--väljalogimise nupp-->
		<form id = "form1" action="Systeem.php?page=logout" method="POST">
		</form>
		<button id="logout" class = "logout" type = "submit" form = "form1" value="Submit">Logi välja</button>
		
		<!--kuupäevade kattumiste kontroll-->
		<?php
		require_once("funktsioonid.php");
		$ajad=kuupaevade_kattumine();?>
				
		<?php
		if(!is_null($ajad)){
			foreach($ajad as $aeg){?>
				<h2>Lisasite järgneva broneeringu</h2>
				<table border="1">
					<tr><th>Bronni algus</th><th>Bronni lõpp</th></tr>
					<tr><td><?php echo $aeg['bronni_algus'];?></td> <td align="center"><?php echo $aeg['bronni_lopp'];?></td></tr>
				</table>
				<?php	
				echo "<br/>";
			}
		}?>
	<script src = "logout.js"></script>
	<script src = "kustuta.js"></script>
</body>
</html>