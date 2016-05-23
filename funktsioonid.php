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
	$toad = array();
	$sql="SELECT * FROM mario_broneering WHERE ruumi_id= ". $ruumi_id;
	$result=mysqli_query($link, $sql) or die( $sql. " - ". mysqli_error($link));
	while($rida = mysqli_fetch_assoc($result)){
		$toad[]=$rida;
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
			if ($_POST['password']!= $_POST['password2'])
				echo("Valitud paroolid ei olnud identsed . ");
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
		$stmt = mysqli_prepare($link, "SELECT kasutajanimi, parool, kasutaja_id FROM mario_kasutajad WHERE kasutajanimi = ? AND  parool = SHA1(?)");
		$bind = mysqli_stmt_bind_param($stmt,"ss", $username, $password);
		$exce = mysqli_stmt_execute($stmt);//true v false
		$bind_r = mysqli_stmt_bind_result($stmt,$r['kasutajanimi'], $r['parool'],$r['kasutaja_id']);
		
		if($exce && $stmt->fetch()){
			//session_start();
			session_regenerate_id();
			$_SESSION['kasutaja1'] = $r['kasutajanimi'];
			$_SESSION['kasutaja'] = $r['kasutaja_id'];
			$nimi=$r['kasutajanimi'];
			print_r($r);
			header ('Location: Toad.php');
			exit();
		}else{
			$_SESSION['error'] = "Vale kasutajanimi või parool!";
			//echo "Vale kasutajanimi või parool!";
			}
		mysqli_close($link);	
	}
}

function logout(){
	session_start();
	session_destroy();
	header('Location: Systeem.php');
}
?>
