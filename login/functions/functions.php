<?php
	//Declaring variables
	$first_name='';
	$last_name='';
	$phone='';
	$college='';
	$email='';
	$password='';
	$confirm_password='';

/*******************Useful Functions*****************/

//Cleans the string from unwanted html symbols
function clean($string){
	return htmlentities($string);
}

//Redirect to a particular page after task is done
function redirect($location){
	return header("Location: {$location}");
}

//Function to store message
function set_message($message){
	if(!empty($message)){
		$_SESSION['message']=$message;
	}
	else{
		$message="";
	}
}

//DISPLAY MESSAGE
function display_message(){
	if(isset($_SESSION['message'])){
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}
}

//Token generator
function token_generator(){
	$token=$_SESSION['token'] =md5(uniqid(mt_rand(),true));
	return $token;
}

//Function to display validation error
function validation_errors($error_message){
$error = <<<DELIMITER
<div class="alert alert-warning alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button><strong>Warning!</strong> $$error_message
			</div>
DELIMITER;
return $error;			
}

//To check if the given email address already exists or not
function email_exists($email){
	$sql="SELECT id FROM users WHERE email='$email'";
	$result=query($sql);
	if(row_count($result)==1){
		return true;
	}
	else{
		return false;
	}
}

//To check if the given username already exists or not
function celestaid_exists($celestaid){
	$sql="SELECT id FROM users WHERE celestaid='$celestaid'";
	$result=query($sql);
	if(row_count($result)==1){
		return true;
	}
	else{
		return false;
	}
}

//Function that sends email
function send_email($email,$subject,$msg,$headers){
	return (mail($email,$subject,$msg,$headers));
}



/*************************Validating Functions**************************/

 function validate_user_registration(){

 	//Declaring the variables
	$first_name="";
	$last_name="";
	$phone='';
	$college='';
	$email='';
	$password='';
	$confirm_password='';

	$errors=[];
	$min=3;
	$max=20;

 	if($_SERVER['REQUEST_METHOD']=='POST'){
 		$first_name=clean($_POST['first_name']);
 		$last_name=clean($_POST['last_name']);
 		$phone=clean($_POST['phone']);
 		$college=clean($_POST['college']);
 		$email=clean($_POST['email']);
 		$password=clean($_POST['password']);
 		$confirm_password=clean($_POST['confirm_password']);
 	}

 	if(strlen($first_name)<$min){
 		$errors[]="Your first name cannot be less than {$min}";
 	}

 	 if(strlen($last_name)<$min){
 		$errors[]="Your last name cannot be less than {$min}";
 	}

 	if(strlen($phone)<10){
 		$errors[]="Your phone number cannot be less than 10 digits.";
 	}

 	if(strlen($last_name)>$max){
 		$errors[]="Your last name cannot be more than {$max}";
 	}

 	if(strlen($first_name)>$max){
 		$errors[]="Your first name cannot be more than {$max}";
 	}

 	if(strlen($phone)>$max){
 		$errors[]="Your phone number cannot have more than 10 digits.";
 	}

 	if(strlen($email)<$min){
 		$errors[]="Your email cannot be less than {$min}";
 	}

 	if($password!==$confirm_password){
 		$errors[]="Your password fields donot match";
 	}

 	if(email_exists($email)){
 		$errors[]="Email already taken";
 	}

 	// if(username_exists($username)){
 	// 	$errors[]="Username already taken by another user";
 	// }


 	if(!empty($errors)){
 		foreach($errors as $error){
 			echo validation_errors($error);
 		}
 	}else{
 		if(register_user($first_name,$last_name,$phone,$college,$email,$password)){
 			set_message("<p class='bg-success text-center'>Please check your email or spam folder for activation link.</p>");
 			redirect("index.php");
 		}
 		else{
 			set_message("<p class='bg-danger text-center'>Sorry we couldn't register the user.</p>");
 			echo "User registration failed";
 		}
 		
 	}
}

//Function to generate random celestaID
function getCelestaId(){
	$exist=true;
	while ($exist) {
		$celestaid="CLST".mt_rand(1001,9999);
		$exist=celestaid_exists($celestaid);
	}
	return $celestaid;
}

function register_user($first_name,$last_name,$phone,$college,$email,$password){

	$first_name=escape($first_name);
	$last_name=escape($last_name);
	$phone=escape($phone);
	$college=escape($college);
	$email=escape($email);
	$password=escape($password);

	if(email_exists($email)==true){
		return false;
	}else{
		$password=md5($password);
		$celestaid=getCelestaId();
		$validation_code=md5($celestaid+microtime());
		//$validation_code='asdertyukcds2345678';
		$sql="INSERT INTO users(first_name,last_name,phone,college,email,password,validation_code,active,celestaid) ";
		$sql.=" VALUES('$first_name','$last_name','$phone','$college','$email','$password','$validation_code','0','$celestaid')";
		echo "<br/>".$sql."<br/>";

		$result=query($sql); 
		echo "<br/>";
		print_r($result);
		confirm($result);

		$subject="Activate Account";
		$msg="
			Your Celesta Id is ".$celestaid.". 
		Please click the link below to activate you Account and login.
			http://localhost:8888/login/activate.php?email=$email&code=$validation_code
		";
		$header="From: noreply@yourwebsite.com";
		send_email($email,$subject,$msg,$headers);


		return true;
	}
}

//Activate User functions
function activate_user(){
	if($_SERVER['REQUEST_METHOD']=="GET"){
		if (isset($_GET['email'])) {
			echo $email=clean($_GET['email']);
			echo $validation_code=clean($_GET['code']);

			$sql="SELECT id FROM users WHERE email='".escape($_GET['email'])."' AND validation_code='".escape($_GET['code'])."' ";
			$result=query($sql);
			confirm($result);

			if(row_count($result)==1){
				$sql2="UPDATE users SET active = 1, validation_code = 0 WHERE email='".escape($email)."' AND validation_code='".escape($validation_code)."' ";
				$result2=query($sql2);
				confirm($result2);
				set_message("<p class='bg-success'> Your account has been activated.</p>");
				redirect("login.php");
			}
			else{
				set_message("<p class='bg-danger'> Your account could not be activated.</p>");
			}
			
		}

	}
}

//Validate user Login
function validate_user_login(){
	$errors=[];
	if($_SERVER['REQUEST_METHOD']=="POST"){
		echo "it Works"."<br/>";
		$celestaid=clean($_POST['celestaid']);
		$password=clean($_POST['password']);


		//Listing down possible errors
		if(empty($celestaid)){
			$errors[]="Celesta ID field cannot be ampty.";
		}

		if(empty($password)){
			$errors[]="Password field cannot be empty.";
		}

		//Error printing or performing further operations
		if(!empty($errors)){
			foreach ($errors as $error) {
				echo validation_errors($error);
			}
		}else{
			if(login_user($celestaid,$password)){
				redirect("admin.php");
			}else{
				//echo "Inside credential wrong";
				echo validation_errors("Your credentials are not correct");
			}

		}

	}
}

//Log in the user
function login_user($celestaid, $password){

	$sql = "SELECT password, id FROM users WHERE celestaid ='".escape($celestaid)."' AND active=1";

	$result=query($sql);
	if(row_count($result)==1){

		$row=fetch_array($result);
		$db_password=$row['password'];

		echo $db_password;
		echo md5($password);
		if(md5($password)==$db_password){
			$_SESSION['celestaid']=$celestaid;
			return true;
		}else{
			return false;
		}

		return true;
	}
	else{
		return false;
	}

}

//Logged in functions
function logged_in(){
	if(isset($_SESSION['celestaid'])){
		return true;
	}
	else{
		return false;
	}
}




