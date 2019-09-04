<?php include("functions/init.php");

session_destroy();
if(isset($_COOKIE['celestaid'])){
	unset($_COOKIE['celestaid']);
	setcookie('celestaid','',time()-86400);
	unset($_COOKIE['qrcode']);
	setcookie('qrcode','',time()-86400);
}
redirect("reg.php");