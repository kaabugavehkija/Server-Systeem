<?php
function baasi_yhendus(){
	global $link;
	$user = "test";
	$pass = "t3st3r123";
	$db = "test";
	$host = "localhost";

	$link = mysqli_connect($host, $user, $pass, $db) or die("ei saanud ühendatud - ");
	mysqli_query($link, "SET CHARACTER SET UTF8")or die( $sql. " - ". mysqli_error($link));
}

function kysi_toad($ruumi_id){
	global $link;
	$stmt = mysqli_prepare($link, "SELECT * FROM mario_broneering WHERE ruumi_id= ? ORDER BY bronni_algus DESC");
	$bind = mysqli_stmt_bind_param($stmt,"s", $ruumi_id);
	$exce = mysqli_stmt_execute($stmt);//true v false
	$veerud = array();
	stmt_bind_assoc($stmt, $veerud);
	$toad = array();
	while(mysqli_stmt_fetch($stmt)){
		foreach( $veerud as $key=>$value ){
			$row_tmb[ $key ] = $value;
		} 
		$toad[] = $row_tmb;
	}
	return $toad;
}
	
function registreeri(){
	if(isset($_POST['username'],$_POST['password'],$_POST['password2'])){
		global $link;
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password2 = $_POST['password'];
		$stmt = mysqli_prepare($link, "SELECT kasutajanimi FROM mario_kasutajad WHERE kasutajanimi = ?");
		$bind = mysqli_stmt_bind_param($stmt,"s", $username);
		$exce = mysqli_stmt_execute($stmt);//true v false
		$bind_r = mysqli_stmt_bind_result($stmt,$r['kasutajanimi']);
		if(mysqli_stmt_fetch($stmt)){
			echo "Sellenimeline kasutaja juba olemas."; 
			exit;
		}else{
			if ($_POST['password']!= $_POST['password2']){
				echo("Valitud paroolid ei olnud identsed . ");
				}
			elseif (strlen($_POST['password'])<9){
				echo ("Password peab olema pikem kui 8 tähemärki");
			}
			else{
				$stmt=mysqli_prepare($link,"INSERT INTO mario_kasutajad(kasutajanimi, parool) VALUES(?,SHA1(?))");
				$bind = mysqli_stmt_bind_param($stmt,"ss", $username, $password);
				$exce = mysqli_stmt_execute($stmt);//true v false
				if($exce){
					header ('Location:Tervitus.html');
					}else{
				echo "Viga ";
			}
		}mysqli_close($link);
		}	
	}
}

function logi_sisse(){
	if (isset($_POST['username'],$_POST['password'])) {
		global $link;
		$username = $_POST['username'];
		$password = $_POST['password'];
		$stmt = mysqli_prepare($link, "SELECT kasutajanimi, parool, kasutaja_id, roll FROM mario_kasutajad WHERE kasutajanimi = ? AND  parool = SHA1(?)");
		$bind = mysqli_stmt_bind_param($stmt,"ss", $username, $password);
		$exce = mysqli_stmt_execute($stmt);//true v false
		$bind_r = mysqli_stmt_bind_result($stmt,$r['kasutajanimi'], $r['parool'],$r['kasutaja_id'], $r['roll']);
		if($exce && $stmt->fetch()){
			session_regenerate_id();
			$_SESSION['kasutaja1'] = $r['kasutajanimi'];
			$_SESSION['kasutaja'] = $r['kasutaja_id'];
			$_SESSION['roll'] = $r['roll'];
			$nimi=$r['kasutajanimi'];
			header ('Location: Toad.php');
			exit();
		}else{
			$_SESSION['error'] = "Vale kasutajanimi või parool!";
			}
		mysqli_close($link);	
	}
}

function logout(){
	session_start();
	session_destroy();
	header('Location: Systeem.php');
}

function stmt_bind_assoc (&$stmt, &$out) {
    $data = mysqli_stmt_result_metadata($stmt);
    $fields = array();
    $out = array();
    $fields[0] = $stmt;
    $count = 1;
    while($field = mysqli_fetch_field($data)) {
        $fields[$count] = &$out[$field->name];
        $count++;
    }
	call_user_func_array('mysqli_stmt_bind_result', $fields);
}

function tuba(){
	global $link;
	$ruumi_id = $_GET['ruumi_id'];
	$stmt = mysqli_prepare($link,"SELECT ruumi_number FROM mario_ruumid WHERE ruumi_id= ?");
	$bind = mysqli_stmt_bind_param($stmt,"s", $ruumi_id);
	$exce = mysqli_stmt_execute($stmt);
	$bind_r = mysqli_stmt_bind_result($stmt,$r['ruumi_number']);
	while(mysqli_stmt_fetch($stmt)){
		foreach($r as $toanr){
			echo $toanr;}
	}
}
function kirjeldus(){
	global $link;
	$ruumi_id = $_GET['ruumi_id'];
	$stmt = mysqli_prepare($link,"SELECT kirjeldus FROM mario_ruumid WHERE ruumi_id= ?");
	$bind = mysqli_stmt_bind_param($stmt,"s", $ruumi_id);
	$exce = mysqli_stmt_execute($stmt);
	$bind_r = mysqli_stmt_bind_result($stmt,$r['ruumi_number']);
	while(mysqli_stmt_fetch($stmt)){
		foreach($r as $kirjeldus){
			echo $kirjeldus;}
	}
}

function naita_tuba(){
	baasi_yhendus();
	global $link;
	$toad=array();
	$sql = "SELECT * FROM mario_ruumid";
	$result = mysqli_query($link, $sql);
		while($rida=mysqli_fetch_assoc($result)){
			$toad[]=$rida;
		}return $toad;
	}
	
function kuupaevade_kattumine(){
	global $link;
	if (isset($_POST['algus'],$_POST['algus1'],$_POST['lopp'],$_POST['lopp1'])) {
	$algus=$_POST['algus'];
	$algus1=$_POST['algus1'];
	$lopp=$_POST['lopp'];
	$lopp1=$_POST['lopp1'];
	$ruumi_ID=$_POST['ruum'];
	$kp_algus=$algus." ".$algus1;
	$kp_lopp=$lopp1." ".$lopp;

	$stmt = mysqli_prepare($link,"SELECT COUNT(*) as num FROM mario_broneering WHERE
            ((? <= bronni_algus AND ? >= bronni_algus)OR
            (? >= bronni_algus AND ? <= bronni_lopp))
            AND ruumi_id = ?");
	mysqli_stmt_bind_param($stmt,"ssssi", $kp_algus, $kp_lopp, $kp_algus, $kp_lopp, $ruumi_ID);
	$exce = mysqli_stmt_execute($stmt);
	$bind_r = mysqli_stmt_bind_result($stmt,$r['num']);
	$num=array();
	if($exce && $stmt->fetch()){
		$num[] = $r['num'];
		};
	if($num[0]>0){
		echo "<div style = 'color: red; font-size: 150%'> Kontrolli aegu!</div>";
		exit;
	}else{
		baasi_yhendus();
		$kp_algus=strtotime($algus.$algus1);
		$kp_lopp=strtotime($lopp.$lopp1);

		$kp_baasi_algus = date('Y-m-d H:i',$kp_algus);
		$kp_baasi_lopp = date('Y-m-d H:i',$kp_lopp);

		$stmt = mysqli_prepare($link,"INSERT INTO mario_broneering (ruumi_id, kasutaja_id, bronni_algus, bronni_lopp) VALUES(?, ?, ?, ?)");
		mysqli_stmt_bind_param($stmt,"isss", $ruumi_ID, $_SESSION['kasutaja'], $kp_baasi_algus, $kp_baasi_lopp);
		$exce = mysqli_stmt_execute($stmt);

		#kasutaja viimati lisatud broneering
		$ajad=array();
		$sql="SELECT bronni_algus, bronni_lopp FROM mario_broneering WHERE bronni_algus= '" .$kp_baasi_algus."' AND bronni_lopp= '" .$kp_baasi_lopp."' AND ruumi_id= '" .$ruumi_ID."' AND kasutaja_id= ".$_SESSION['kasutaja']."";
		$result=mysqli_query($link, $sql) or die( $sql. " - ". mysqli_error($link));
		while($rida = mysqli_fetch_assoc($result)){
			$ajad[]=$rida;
		}return $ajad;
		
	}
}
}

function kustuta(){
	global $link;
	if(isset($_POST['kp'])){
	$id = $_GET['bronni_id'];
	$sql = "DELETE FROM mario_broneering WHERE bronni_id=$id";
	$result = mysqli_query($link, $sql) or die(mysql_error());
	//$ruumi_id =$_GET['ruumi_id'];
	//echo $test;
	//header("location: Systeem.php?page=detailvaade&ruumid_id=".$ruumi_id);
	header("location: Systeem.php?page=toad");
	exit;
	}
}
/*function kustuta(){
	global $link;
	if(isset($_POST['kp'])){
	$id = $_GET['bronni_id'];
	$stmt = mysqli_prepare($link, "DELETE FROM mario_broneering WHERE bronni_id = ?");
	mysqli_stmt_bind_param($stmt,"i", $id);
	$exce = mysqli_stmt_execute($stmt);
	
	header("location: Systeem.php?page=toad");
	exit;
	}
}*/
?>
