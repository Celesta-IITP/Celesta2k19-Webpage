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
// 	return (mail($email,$subject,$msg,$headers));

	require 'PHPMailerAutoload.php';

	$mail = new PHPMailer;

	//$mail->SMTPDebug = 4;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'tls://smtp.gmail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = "";                 // SMTP username
	$mail->Password = "";                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->setFrom('hayyoulistentome@gmail.com', 'Celesta2k19');
	$mail->addAddress($email);     // Add a recipient
	//$mail->addAddress('ellen@example.com');               // Name is optional
	$mail->addReplyTo('hayyoulistentome@gmail.com', 'Information');
	//$mail->addCC('cc@example.com');
	//$mail->addBCC('bcc@example.com');

	// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $msg;
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	if(!$mail->send()) {
	   // echo 'Message could not be sent.';
	   // echo 'Mailer Error: ' . $mail->ErrorInfo;
	    return false;
	} else {
	  //  echo 'Message has been sent';
	    return true;
	}
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

		//CONTENTS OF EMAIL
		$subject="Activate Celesta Account";
		$msg="<p>
			Your Celesta Id is ".$celestaid.". <br/>
		Please click the link below to activate you Account and login.<br/>
			http://localhost:8888/login/activate.php?email=$email&code=$validation_code
			</p>
		";
		$header="From: noreply@yourwebsite.com";
		//Added to database if mail is sent successfully
		if(send_email($email,$subject,$msg,$header)){
			$sql="INSERT INTO users(first_name,last_name,phone,college,email,password,validation_code,active,celestaid) ";
			$sql.=" VALUES('$first_name','$last_name','$phone','$college','$email','$password','$validation_code','0','$celestaid')";
			$result=query($sql);
			return true;
		}else{
			return false;
		}
		
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
		$celestaid=clean($_POST['celestaid']);
		$password=clean($_POST['password']);
		$remember=isset($_POST['remember']);

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
			if(login_user($celestaid,$password,$remember)){
				redirect("admin.php");
			}else{
				//echo "Inside credential wrong";
				echo validation_errors("Your credentials are not correct");
			}

		}

	}
}

//Log in the user
function login_user($celestaid, $password, $remember){

	$sql = "SELECT password, id FROM users WHERE celestaid ='".escape($celestaid)."' AND active=1";

	$result=query($sql);
	if(row_count($result)==1){

		$row=fetch_array($result);
		$db_password=$row['password'];

		echo $db_password;
		echo md5($password);
		if(md5($password)==$db_password){
			$_SESSION['celestaid']=$celestaid;	//Storing the cdlesta id in a session

			if($remember=="on"){
				 setcookie('celestaid',$celestaid, time() + 86400); 
			}
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
	if(isset($_SESSION['celestaid']) || isset($_COOKIE['celestaid'])){
		return true;
	}
	else{
		return false;
	}
}

// Recover password

function recover_password(){
	if($_SERVER['REQUEST_METHOD']=="POST"){
		if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']){
			$email=clean($_POST['email']);
			if(email_exists($email)){

				$sql="SELECT celestaid FROM users WHERE email='".$email."' ";
				$result=query($sql);
				
				confirm($result);
				$row=fetch_array($result);
				$celestaid=$row['celestaid'];
				
				$validation_code=md5($email+$celestaid+microtime());
				setcookie('temp_access_code',$validation_code,time()+ 600 );

				$sql1="UPDATE users SET validation_code='".$validation_code."' WHERE email='".escape($email)."' ";
				$result1= query($sql1);
				confirm($result1); 

				$subject = "Please reset your Celesta ID password.";
				$message = "<p>Your celesta id is: {$celestaid}.<br/>
					Your password reset code is {$validation_code} <br/>
					Click here to reset your password http://localhost:8888/login/code.php?email=$email&code=$validation_code </p>";
				$header="From: noreply@yourwebsite.com";
				if (send_email($email,$subject,$message,$header)){
					echo "Email sent";
					set_message("<p class='bg-success text-center'>Please check your email or spam folder for password resetting link.</p>");
					redirect("index.php");
				}else{
					echo validation_errors("Email could not be sent. Please try after sometime.");
				}
			}else{
				echo validation_errors("This email doesnot exist");
			}

			//echo "It works";
		}else{
			redirect("index.php");
		}
		
	}
}

/*******Handling Password resetting **************/
function validate_code(){
	if(isset($_COOKIE['temp_access_code'])){

		if($_SERVER['REQUEST_METHOD']=="GET"){
			if(!isset($_GET['email']) && !isset($_GET['code'])){
				redirect("index.php");
			}else if(empty($_GET['email']) || empty($_GET['code'])){
				redirect("index.php");
			}else{
				if(isset($_GET['code'])){
					$email=clean($_GET['email']);
					$validation_code=clean($_GET['code']);
					
					$sql2="SELECT id FROM users WHERE validation_code='".$validation_code."' AND email='".$email."' ";
					$result2=query($sql2); 
					print_r($result2);
					confirm($result2);
					if(row_count($result2) == 1){
						redirect("reset.php?email=$email&code=$validation_code");
					}else{
						echo validation_errors("Sorry incorrect validation code. You might have clicked on wrong link. Try by typing the code manually or click on Forgot Password Again to get the link.");
					}
			}
			
		}
	}

	//Manually entering the code
	if($_SERVER['REQUEST_METHOD']=="POST"){
		if(isset($_POST['code'])){
			$validation_code= clean($_POST['code']);
			$email =clean($_GET['email']);

			$sql="SELECT id FROM users WHERE validation_code='".$validation_code."' AND email='".$email."' ";
			$result=query($sql); 

			if(row_count($result) == 1){
				redirect("reset.php?email=$email&code=$validation_code");
			}else{
				echo validation_errors("Sorry incorrect validation code for given email id.");
			}		

		}
	}
	}else{
		set_message("<p class='bg-danger text-center'>Sorry your validation cookie has expired.</p>");
		redirect("recover.php");
	}
}

//Resetting the password
function reset_password(){

	if(isset($_COOKIE['temp_access_code'])){
		if($_SERVER['REQUEST_METHOD']=="GET"){
			if(!isset($_GET['email']) && !isset($_GET['code'])){
				redirect("index.php");
			}else if(empty($_GET['email']) || empty($_GET['code'])){
				echo "2nd option";
				redirect("index.php");
			}else{
				if(isset($_GET['code'])){
					$email=clean($_GET['email']);
					$validation_code=clean($_GET['code']);
					$sql2="SELECT id FROM users WHERE validation_code='".escape($validation_code)."' AND email='".escape($email)."' ";
					$result2=query($sql2); 

					if(row_count($result2) == 1){
						setcookie("temp_password_reset",1,time()+180);
					}else{
						unset($_COOKIE['temp_password_reset']);
						setcookie("temp_password_reset",'',time()-180);
						redirect("index.php");
					}
				}
		
			}
		}else if($_SERVER['REQUEST_METHOD']=="POST"){
			if($_COOKIE['temp_password_reset']==1){
				
				if(isset($_POST['password']) && isset($_POST['confirm_password'])){
					$password=clean($_POST['password']);
					$email=clean($_GET['email']);
					$confirm_password=clean($_POST['confirm_password']);
					if($password!=$confirm_password){
						echo validation_errors("Password and confirm password did not match.");
					}else{
						$password=md5($password);
						$sql="SELECT id FROM users WHERE email='".escape($email)."' ";
						$result=query($sql);

						if(row_count($result)==1){
							$sql1="UPDATE users SET password='".$password."' WHERE email='".escape($email)."' ";
							$result1=query($sql1);
							set_message("<p class='bg-success text-center'> Your apassword has been resetted.</p>");
							redirect("login.php");
						}else{
							echo validation_errors("Failed to reset password. Try again later.");
						}

						
					}
				}
			}else{
				echo "Password failed to reset. Try again later";
				redirect("recover.php");
			}
			unset($_COOKIE['temp_password_reset']);
			setcookie("temp_password_reset",'',time()-180);
		}
	}
}

