<?php
session_start();
if(!isset($_SESSION["password"])){
#exit;
	$host = $_SERVER['HTTP_HOST'];
	$self = $_SERVER['PHP_SELF'];
	$query = !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;
	$url = !empty($query) ? "http://$host$self?$query" : "http://$host$self";

	$_SESSION['original_location'] = $url;
	#echo $url.":".$_SESSION['original_location'];
	
header('Location: agreement_iphone_retina.php');
exit;
}else{
	#echo "hello3".$_SESSION["password"];
}
?> 


