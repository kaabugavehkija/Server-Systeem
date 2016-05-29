<?php
session_start();
require_once("funktsioonid.php");
baasi_yhendus();

$page="";
if (!empty($_GET["page"])) {
	$page=$_GET["page"];
}
switch($page){
	case "registreeri":
		registreeri();
		include_once("Registreerimine.html");
	break;
	case "logi_sisse":
		logi_sisse();
		include_once("Sisselogimine.html");
	break;
	case "toad":
		include('Toad.php');
	break;
	case "detailvaade":
		include('detailvaade.php');
	break;
	case "logout":
		logout();
	break;
	case "kustuta":
		kustuta();
	break;
	default:
		include("Avaleht.html");
	break;
}

?>