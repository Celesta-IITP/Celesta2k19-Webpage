<?php include("functions/init.php");

session_destroy();
if(isset($_COOKIE['registrar'])){
	unset($_COOKIE['registrar']);
	setcookie('registrar','',time()-86400);
	unset($_COOKIE['permit']);
	setcookie('permit','',time()-86400);
}
unset($_SESSION['permit']);
unset($_SESSION['registrar']);
redirect("login.php");