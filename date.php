<?php
session_start();
if (isset($_POST['algus'],$_POST['algus1'],$_POST['lopp'],$_POST['lopp1'])) {
	$algus=htmlspecialchars($_POST['algus']);
	$algus1=htmlspecialchars($_POST['algus1']);
	$lopp=htmlspecialchars($_POST['lopp']);
	$lopp1=htmlspecialchars($_POST['lopp1']);
	$ruumi_ID=htmlspecialchars($_POST['ruum']);
}
require_once("funktsioonid.php");

baasi_yhendus();
$kp_algus=strtotime($algus.$algus1);
$kp_lopp=strtotime($lopp.$lopp1);

$kp_baasi_algus = date('Y-m-d H:i',$kp_algus);
$kp_baasi_lopp = date('Y-m-d H:i',$kp_lopp);


$sql = "INSERT INTO mario_broneering (ruumi_id, kasutaja_id, bronni_algus, bronni_lopp) VALUES(".$ruumi_ID.",".$_SESSION['kasutaja'].", '".$kp_baasi_algus."', '".$kp_baasi_lopp."')";
$result = mysqli_query($link, $sql);
mysqli_close($link);
echo "Broneering kinnitatud";
//header('Refresh: 3; Toad.php');
?>