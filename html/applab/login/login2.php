<?php
ob_start();
session_start();
require '../../configuration.php';
$joomla_config = new JConfig();
#echo "A:".$joomla_config->app_lab_pass.":B";
#echo "<br>Posted password:".$_POST["password"].";";
if ($joomla_config->app_lab_pass == $_POST["password"]){
	echo "<br>True";
}else{
	echo "<br>False";
}
$usernames = array("", "beaniehat");
$passwords = array($joomla_config->app_lab_pass, "test");
$original_location = $_SESSION["original_location"];
if ($original_location == ''){
	$page = "../start_bootstrap.php";
}else{
	$page = $_SESSION["original_location"];
}

#echo "<BR>Page:".$page;

for($i=0;$i<count($usernames);$i++){
  $logindata[$usernames[$i]]=$passwords[$i];
}
#if($logindata[$_POST["username"]]==$_POST["password"]){
if ($joomla_config->app_lab_pass == $_POST["password"]){
$_SESSION["password"]=$_POST["password"];
$_SESSION["original_location"] = '';
header('Location: '.$page);
exit;
}else{
header('Location: ../index.php?wrong=1');
exit;
}
?> 