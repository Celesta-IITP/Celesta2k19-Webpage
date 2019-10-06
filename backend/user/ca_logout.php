<?php include("functions/init.php");

$celestaid=$_SESSION['celestaid'];
$sql="UPDATE users SET access_token='' WHERE celestaid='$celestaid'";
$result=query($sql);

session_destroy();
if(isset($_COOKIE['celestaid'])){
	unset($_COOKIE['celestaid']);
	setcookie('celestaid','',time()-86400);
	unset($_COOKIE['qrcode']);
	setcookie('qrcode','',time()-86400);
}

redirect("../../ca/ca.php");