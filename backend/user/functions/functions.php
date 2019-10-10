<?php
	include("utility.php");	//Mail function and qr code function
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
			</button><strong> $error_message</strong> 
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

// To check if the user exists or not
function refrral_id_exist($referral_id){
	$sql = "SELECT id, active FROM ca_users WHERE celestaid ='".$referral_id."'";
	$result = query($sql);
	if(row_count($result)==1){
		$row=fetch_array($result);
		if($row['active']==1){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

//Attaching the qr code generator
function generateQRCode($celestaid,$first_name,$last_name){
	include("qrCodeGenerator/qrlib.php");
	QRcode::png($celestaid."/".$first_name."/".$last_name,"assets/qrcodes/".$celestaid.".png","H","10","10");
}

/*************************Calling API Functions**************************/
// Calling login and signup functions
function login_signup(){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['login'])){
			if($_POST['login']='miss_u_a_lot_atreyee'){
				validate_user_login();
			}
		}elseif(isset($_POST['signup'])){
			if($_POST['signup']=="love_u_atreyee"){
				validate_user_registration();
			}
		}
	}
}


/*************************** API Functions *****************************/
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
		$gender=$_POST['gender'];
		$referral_id = trim(clean($_POST['referral_id']));

	 	if(strlen($first_name)<$min){
	 		$errors[]="Your first name cannot be less than {$min}";
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
	 		$errors[]="Your password fields didn't match";
		 }
		 
		 if(strlen($referral_id)!=8){
			 $referral_id ="CLST1504";
		 }

	 	if(email_exists($email)){
	 		$errors[]="Email already taken";
	 	}

	 	if(!empty($errors)){
	 		foreach($errors as $error){
	 			echo validation_errors($error);
	 		}
	 		return json_encode(array_merge(array("201"),$errors));
	 	}else{
	 		if(register_user($first_name,$last_name,$phone,$college,$email,$password,$gender, $referral_id)){

	 			redirect("display.php");
	 			return json_encode("200");//Registration success
	 		}
	 		else{
	 			// set_message("<p class='bg-danger text-center'>Sorry we couldn't register the user.</p>");
	 			echo validation_errors("Sorry we couldn't register the user.");
	 			return json_encode("201");	//Registration failed
	 		}
	 	}
 	}
}

/* Registration of campus ambassador*/

function validate_ca_registration(){
	$min=3;
	$max=20;
	if($_SERVER['REQUEST_METHOD']=="POST"){
		$first_name=clean($_POST['first_name']);
 		$last_name=clean($_POST['last_name']);
 		$phone=clean($_POST['phone']);
 		$college=clean($_POST['college']);
 		$email=clean($_POST['email']);
 		$password=clean($_POST['password']);
 		$confirm_password=clean($_POST['confirm_password']);
 		$gender=$_POST['gender'];

	 	if(strlen($first_name)<$min){
	 		$errors[]="Your first name cannot be less than {$min}";
	 	}

	 	if(strlen($phone)<10){
	 		$errors[]="Your phone number cannot be less than 10 digits.";
	 	}

	 	if(strlen($last_name)>$max){
	 		$errors[]="Your last name cannot be more than {$max}";
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
		 
		if(!empty($errors)){
	 		foreach($errors as $error){
	 			echo validation_errors($error);	
	 		}
	 		return json_encode(array_merge(array("201"),$errors));
	 	}else{
	 		if(ca_register($first_name,$last_name,$phone,$college,$email,$password,$gender)){

	 			redirect("display.php");
	 			return json_encode("200");//Registration success
			 }else{
				//  set_message("<p class='bg-danger text-center'>Sorry we couldn't register the user.</p>");
				 echo validation_errors("Sorry we couldn't register the user.");
	 			return json_encode("201");	//Registration failed
	 		}
		}
	}
}

function ca_register($first_name, $last_name, $phone, $college, $email, $password, $gender){
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
		generateQRCode($celestaid,$first_name,$last_name);
		$qrcode="https://celesta.org.in/backend/user/assets/qrcodes/".$celestaid.".png";

		//CONTENTS OF EMAIL
		$subject="Activate Celesta Account";
		$msg="<p>
		You have successfully registered as a Campus Ambassador in Celesta-2k19. Please verify your account to get the details.
		Please click the link below to activate your Account and login.<br/>
			<a href='https://celesta.org.in/backend/user/activate.php?email=$email&code=$validation_code&ca=campus_ambassador_celesta2k19'>https://celesta.org.in/backend/user/activate.php?email=$email&code=$validation_code&ca=campus_ambassador_celesta2k19</a>
			</p>
		";
		$header="From: noreply@yourwebsite.com";
		//Added to database if mail is sent successfully
		if(send_email($email,$subject,$msg,$header)){
			$sql="INSERT INTO users(first_name,last_name,phone,college,email,password,validation_code,active,celestaid,qrcode,gender) ";
			$sql.=" VALUES('$first_name','$last_name','$phone','$college','$email','$password','$validation_code','0','$celestaid','".$qrcode."','$gender')";
			$result=query($sql);
			confirm($result);

			$sql="INSERT INTO ca_users(first_name,last_name,phone,college,email,password,validation_code,active,celestaid,qrcode,gender) ";
			$sql.=" VALUES('$first_name','$last_name','$phone','$college','$email','$password','$validation_code','0','$celestaid','".$qrcode."','$gender')";
			$result=query($sql);
			confirm($result);

			set_message("<p class='bg-success text-center'>Please check your email or spam folder for activation link. </p>");
			return true;
		}else{
			return false;
		}
	}
}


/* */

function register_user($first_name,$last_name,$phone,$college,$email,$password,$gender, $referral_id){

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
		generateQRCode($celestaid,$first_name,$last_name);
		// $qrcode="http://localhost:8888/Celesta2k19-Webpage/backend/user/assets/qrcodes/".$celestaid.".png";
		$qrcode="https://celesta.org.in/backend/user/assets/qrcodes/".$celestaid.".png";

		//CONTENTS OF EMAIL
		$subject="Activate Celesta Account";
		$msg="<p>
		You have successfully created a Celesta Account. Please verify your account to get the details.
		Please click the link below to activate your Account and login.<br/>
			<a href='https://celesta.org.in/backend/user/activate.php?email=$email&code=$validation_code'>https://celesta.org.in/backend/user/activate.php?email=$email&code=$validation_code</a>
			</p>
		";
		$header="From: noreply@yourwebsite.com";
		//Added to database if mail is sent successfully
		if(send_email($email,$subject,$msg,$header)){
			if(!refrral_id_exist($referral_id)){
				$referral_id="CLST1504";
			}
			update_referral_points($referral_id);

			$sql="INSERT INTO users(first_name,last_name,phone,college,email,password,validation_code,active,celestaid,qrcode,gender, ca_referral) ";
			$sql.=" VALUES('$first_name','$last_name','$phone','$college','$email','$password','$validation_code','0','$celestaid','".$qrcode."','$gender','$referral_id')";
			$result=query($sql);
			confirm($result);

			set_message("<p class='bg-success text-center'>Please check your email or spam folder for activation link. </p>");
			return true;
		}else{
			return false;
		}
	}
}

// Add referral points
function update_referral_points($referral_id){
	$sql = "SELECT excitons FROM ca_users WHERE celestaid='$referral_id'";
	$result = query($sql);
	if(row_count($result)==1){
		$row=fetch_array($result);
		$points=$row['excitons'];
		$points = $points + 10;

		$sql1 = "UPDATE ca_users SET excitons=$points WHERE celestaid='$referral_id'";
		$result1 = query($sql1);
		confirm($result1);
	}
}

//Activate User functions
function activate_user(){
	if($_SERVER['REQUEST_METHOD']=="GET"){
		if (isset($_GET['email'])) {
			echo $email=clean($_GET['email']);
			echo $validation_code=clean($_GET['code']);

			$sql="SELECT id, celestaid, qrcode, first_name FROM users WHERE email='".escape($_GET['email'])."' AND validation_code='".escape($_GET['code'])."' ";
			$result=query($sql);
			confirm($result);

			if(row_count($result)==1){
				$sql2="UPDATE users SET active = 1, validation_code = 0 WHERE email='".escape($email)."' AND validation_code='".escape($validation_code)."' ";
				$result2=query($sql2);
				confirm($result2);
				
				// Fetching details
				$row=fetch_array($result);
				$celestaid=$row['celestaid'];
				$qrcode=$row['qrcode'];
				$is_ca=false;
				$first_name=$row['first_name'];

				// To activate ca register table
				if(isset($_GET['ca'])){
					$ca =clean($_GET['ca']);
					if($ca =="campus_ambassador_celesta2k19"){
						$sql1="SELECT id FROM ca_users WHERE email='".escape($_GET['email'])."' AND validation_code='".escape($_GET['code'])."' ";
						$result1=query($sql1);
						confirm($result1);
						$is_ca=true;

						if(row_count($result1)==1){
							$sql3="UPDATE ca_users SET active = 1, validation_code = 0 WHERE email='".escape($email)."' AND validation_code='".escape($validation_code)."' ";
							$result3=query($sql3);
							confirm($result3);
						}
					}
				}

				$subject="Celesta Account Details";

				$header="From: noreply@yourwebsite.com";

				if($is_ca==true){
					set_message("<p class='bg-success'> Your account has been activated.<br> Your celestaid is <b>$celestaid</b>. Your ca referral id is: <b>$celestaid</b>. <br> Your qr code is <br> <img src='$qrcode'/></p>");
					$msg="<p>
					Hi $first_name, you have successfully completed your CA registration process.<br>
					Your celestaid is : <b>$celestaid</b><br>
					Your referral id is: <b>$celestaid</b><br>
					Please join the WhatsApp Group : <a href='https://chat.whatsapp.com/KiaTa2umQ2wKoDX6pzptXp'>https://chat.whatsapp.com/KiaTa2umQ2wKoDX6pzptXp</a>
					Your qr code is: <img src='$qrcode'>
					Or click here to get your qrcode : <a href='$qrcode'>$qrcode</a>
					</p>
					";
				}else{
					set_message("<p class='bg-success'> Your account has been activated.<br> Your celestaid is <b>$celestaid</b>. <br> Your qr code is <br> <img src='$qrcode'/></p>");
					$msg="<p>
					Hi $first_name, you have successfully created a Celesta Account.<br>
					Your celestaid is : <b>$celestaid</b><br>
					Your qr code is: <img src='$qrcode'>
					Or click here to get your qrcode : <a href='$qrcode'>$qrcode</a>
					</p>
					";
				}
				
				send_email($email,$subject,$msg,$header);

				redirect("display.php");
				return json_encode("400");//Success
			}
			else{
				set_message("<p class='bg-danger'> Your account could not be activated.</p>");
				return json_encode("404");//Failed
			}
		}

	}
}

// Resend Activation Link
function resendActivationLink(){
	if($_SERVER['REQUEST_METHOD']=="POST"){
		$email=escape($_POST['username']); // Email id of the user
		$sql="SELECT active,id, validation_code,celestaid FROM users WHERE email='$email'";
		$result=query($sql);
		confirm($result);

		$response=array();
		$message=array();

		if(row_count($result)==1){
			$row=fetch_array($result);
			$active=$row['active'];

			if($active==1){
				$message[]="Account already activated.";
				$response['status']=208;
			}else{
				$celestaid=$row['celestaid'];
				$validation_code=md5($celestaid.microtime());
				$sql1="UPDATE users SET validation_code='$validation_code' WHERE email='$email'";
				$result1=query($sql1);
				confirm($result1);
				$activation_link="https://celesta.org.in/backend/user/activate.php?email=$email&code=$validation_code";

				if(isUserCA($email)){
					$sql2="UPDATE ca_users SET validation_code='$validation_code' where email='$email'";
					$result2=query($sql2);
					$activation_link="https://celesta.org.in/backend/user/activate.php?email=$email&code=$validation_code&ca=campus_ambassador_celesta2k19";
				}

				$subject="Re-Activation Link";
				$msg="<p>
				Please click the link below to activate your celesta account and login.<br/>
					<a href='$activation_link'>$activation_link</a>
					</p>
				";
				$header="From: noreply@yourwebsite.com";
				send_email($email,$subject,$msg,$header);
				$message[]="Successfully resend the verification link";
				$response['status']=200;
				set_message("<p class='bg-success'> Activation link has successfully been sent to your account.</p>");
				echo json_encode($response);
				redirect("reg.php");
			}
		}else{
			$message[]="Email not found.";
			$response['status']=404;
		}

		$response['message']=$message;
		echo json_encode($response);

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
			return json_encode(array_merge(array("404"),$errors));
		}else{
			if(login_user($celestaid,$password,$remember)){
				if(isset($_GET['redirecteventsdata'])){
					redirect("../../events/eventsdata.php?data=".$_GET['redirecteventsdata']);
					return 0;
				}
				if(isset($_GET['redirecteventsdetails'])){
					redirect("../../events/eventsdetails.php?id=".$_GET['redirecteventsdetails']);
					return 0;
				}
				redirect("profile.php");
				return json_encode(array("400"));//User logged in
			}else{
				//echo "Inside credential wrong";
				echo validation_errors("Your credentials are not correct or your account might not been activated yet.");
				return json_encode("404");//User login failed
			}
		}
	}
}

//Log in the user
function login_user($celestaid, $password, $remember){

	$sql = "SELECT password, id, qrcode, active FROM users WHERE celestaid ='".escape($celestaid)."' AND active=1";

	$result=query($sql);
	if(row_count($result)==1){

		$row=fetch_array($result);
		$db_password=$row['password'];
		$qrcode=$row['qrcode'];
		if(md5($password)==$db_password){
			$access_token=$celestaid.$password.microtime();
			$access_token=md5($access_token);

			$sql1="UPDATE users SET access_token='$access_token' WHERE celestaid='$celestaid'";
			$result1 = query($sql1);
			$_SESSION['celestaid']=$celestaid;	//Storing the celesta id in a session
			$_SESSION['qrcode']=$qrcode;
			$_SESSION['access_token']=$access_token;

			if($remember=="on"){
				 setcookie('celestaid',$celestaid, time() + 86400);
				 setcookie('qrcode',$qrcode,time()+86400);
				 setcookie('access_token',$celestaid, time()+86400);
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
	if(isset($_SESSION['celestaid'])){
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
					Click here to reset your password https://celesta.org.in/backend/user/code.php?email=$email&code=$validation_code </p>";
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

							//Updating in present database also, if the email exists
							$sql2="SELECT id FROM present_users WHERE email='".escape($email)."' ";
							$result2=query($sql2);
							if(row_count($result2)==1){
								$sql3="UPDATE present_users SET password='".$password."' WHERE email='".escape($email)."' ";
								$result3=query($sql3);
							}
							
							set_message("<p class='bg-success text-center'> Your password has been resetted.</p>");
							redirect("reg.php");
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


// CA Leaderboard
function ca_leaderboard(){
	$sql="SELECT * FROM ca_users WHERE active=1";
	$result=query($sql);
	$data = array();
    while($row = fetch_array($result))
    {
        $data[] = $row;
	}
	return $data;
}

function user_details($celestaid){
	$sql="SELECT * FROM users WHERE celestaid='".escape($celestaid)."' ";
	$result=query($sql);
	$data = fetch_array($result);
	$sql2="SELECT * FROM ca_users WHERE celestaid='".escape($celestaid)."' ";
	$result2=query($sql2);
	if(row_count($result2)==1){
		$data['isCA']=true;
		$ca=fetch_array($result2);
		$data['ca']=$ca;
	} else {
		$data['isCA']=false;
	}
	return $data;
}

function isUserCA($email){
	$sql="SELECT id from ca_users where email='$email'";
	$result=query($sql);
	if(row_count($result)==1){
		return true;
	}else{
		return false;
	}
}
