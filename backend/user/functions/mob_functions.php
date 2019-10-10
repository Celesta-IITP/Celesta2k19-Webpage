<?php ob_start();

session_start();
//Including all necesary files
include('db.php');
include('utility.php');

/** Pass a parameter with f and set value to it
 * Set f=register_user, to perform registration
*/
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['f'])){
        if($_POST['f']=='register_user'){
            user_registration();
        }elseif($_POST['f']=='login_user'){
            login_user();
        }elseif($_POST['f']=='checkin_checkout'){
            checkin_checkout();
        }elseif($_POST['f']=='user_profile'){
            profile();
        }elseif($_POST['f']=='logout_user'){
            logout_user();
        }elseif($_POST['f']=="resend_activation_link"){
            resendActivationLink();
        }
    }
}

/** -----------------Jot down all the required functions ----------------------- */
//Cleans the string from unwanted html symbols
function clean($string){
	return htmlentities($string);
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
	QRcode::png($celestaid."/".$first_name."/".$last_name,"../assets/qrcodes/".$celestaid.".png","H","10","10");
}

function user_registration(){
    $message=[];
    $errors=[];
	$min=3;
    $max=20;
    $response=array();

    if($_SERVER['REQUEST_METHOD']=='POST'){
        //Taking out the data from the post request
        $first_name=clean($_POST['first_name']);
        $last_name=clean($_POST['last_name']);
        $phone=clean($_POST['phone']);
        $college=clean($_POST['college']);
        $email=clean($_POST['email']);
        $password=clean($_POST['password']);
        $confirm_password=clean($_POST['confirm_password']);
        $gender=$_POST['gender'];
        $referral_id = trim(clean($_POST['referral_id']));

        //Checking for all possible errors
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
        //After check perform the task.
        if(!empty($errors)){
            $response['status']='400';
            $response['message']=$errors;
            echo json_encode($response);
        }else{
            $first_name=escape($first_name);
            $last_name=escape($last_name);
            $phone=escape($phone);
            $college=escape($college);
            $email=escape($email);
            $password=escape($password);
            $referral_id = escape($referral_id);

            $password=md5($password);
            $celestaid=getCelestaId();
            $validation_code=md5(mt_rand(10001,99999).microtime());
            generateQRCode($celestaid,$first_name,$last_name);
            $qrcode="https://celesta.org.in/backend/user/assets/qrcodes/".$celestaid.".png";

            //Composing the email
            $subject="Activate Celesta Account";
            $msg="<p>
                Thank you for creating Celesta Account. Please click the link below to activate your account. <br/>
                
                 <a href='https://celesta.org.in/backend/user/activate.php?email=$email&code=$validation_code'>https://celesta.org.in/backend/user/activate.php?email=$email&code=$validation_code</a>
                <br/>Note: You can login once you have activated your account
                </p>
            ";
            $header="From: noreply@yourwebsite.com";

            if(send_email($email,$subject,$msg,$header)){
                if(!refrral_id_exist($referral_id)){
                    $referral_id="CLST1504";
                }
                update_referral_points($referral_id);
            
                $sql="INSERT INTO users(first_name,last_name,phone,college,email,password,validation_code,active,celestaid,qrcode,gender) ";
                $sql.=" VALUES('$first_name','$last_name','$phone','$college','$email','$password','$validation_code','0','$celestaid','".$qrcode."','$gender')";
                $result=query($sql);
                confirm($result);

                //Setting the JSON ready for sending the response
                $message[]="Successfully created the account";
                // $message['validation_code']=$validation_code;

                $response['status']='200';
                $response['message']=$message;
                echo json_encode($response);
            }else{
                $response['status']='400';
                $response['message']="Failed to send the email for verification";
                echo json_encode($response);
            }
        }//After check else part closing
    }//Post check closing
}//User registration closing

// Add referral points
function update_referral_points($referral_id){
	$sql = "SELECT excitons FROM ca_users WHERE celestaid='$referral_id'";
	$result = query($sql);
	if(row_count($result)==1){
		$row=fetch_array($result);
		$points=$row['points'];
		$points = $points + 10;

		$sql1 = "UPDATE ca_users SET excitons=$points WHERE celestaid='$referral_id'";
		$result1 = query($sql1);
		confirm($result1);
	}
}


// Resend Activation Link
function resendActivationLink(){
	if($_SERVER['REQUEST_METHOD']=="POST"){
		$email=escape($_POST['email']); // Email id of the user
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
			}
		}else{
			$message[]="Email not found.";
			$response['status']=404;
		}

		$response['message']=$message;
		echo json_encode($response);
	}
}

// //Activate the user
// function activate_user(){
//     $response=array();
//     $errors=array();
//     $message=array();
//     $email=$_GET['email'];
//     $celestaid=$_GET['celestaid'];
//     $got_validation_code=$_GET['validation_code'];
//     // echo "Reached -".$got_validation_code."<br/>";

//     //fetching validation code from the database for the particular celstaid
//     $sql="SELECT validation_code,email,qrcode FROM users WHERE celestaid='$celestaid' and email='$email'";
//     $result=query($sql);
//     confirm($result);

//     if(row_count($result)==1){
//         $row=fetch_array($result);
//         $validation_code=$row['validation_code'];
//         $qrcode=$row['qrcode'];

//         if($got_validation_code==$got_validation_code){
//             $sql="UPDATE users SET active=1,validation_code='' WHERE celestaid='$celestaid'";
//             $result=query($sql);
//             $confirm($result);

//             #writing the response
//             $message[]="Your celestaid: $celestaid has been successfully activated.";
//             $response['status']='201';
//             $response['message']=$message;
//             $response['celestaid']=$celestaid;
//             $response['qrcode']=$qrcode;
            

//             //Composing the email
//             $subject="Activated Celesta Account";
//             $msg="<p>
//                 Your Celesta Id ".$celestaid." has been succesfully activated. <br/>
//                 You can now login in the app or web.
//                 You qr code is <img src='$qrcode'/> <a href='$qrcode'>click here</a><br/>
//                 </p>
//             ";
//             $header="From: noreply@yourwebsite.com";
//             send_email($email,$subject,$msg,$header);
//             echo json_encode($response);


//         }else{
//             $errors[]="The validation code that you entered is wrong.";
//             $response['status']='402';
//             $response['message']=$errors;
//             echo json_encode($response);
//         }
//     }else{
//         //Will write r=the response code later
//         $errors[]="Following Celesta ID have not been registered yet.";
//         $response['status']='402';
//         $response['message']=$errors;
//         echo json_encode($response);
//     }
// }//User account activation

//Login function
function login_user(){
    $response=array();
    $errors=array();
    $message=array();
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $celestaid=$_POST['celestaid'];
        $password=$_POST['password'];
        $password=md5($password);

        $sql="SELECT * FROM users WHERE celestaid='$celestaid' AND password='$password'";
        $result=query($sql);

        if(row_count($result)==1){
            $row=fetch_array($result);
            $active=$row['active'];

            if($active!=1){
                $errors[]="Your account is not activated. Please activate your account to login.";
                $response['status']='403';//Login failed
                $response['message']=$errors;
                echo json_encode($response);
            }else{
                $access_token=$celestaid.$password.microtime();
                $access_token=md5($access_token);

                $sql1="UPDATE users SET access_token='$access_token' WHERE celestaid='$celestaid'";
                $result1 = query($sql1);

                $first_name=$row['first_name'];
                $last_name=$row['last_name'];
                $email=$row['email'];
                $qrcode=$row['qrcode'];
                $celestaid=$row['celestaid'];
                $events_registered=$row['events_registered'];
                $events_participated=$row['events_participated'];
                $phone=$row['phone'];
    
                $response['status']='202';//Login validated
                $message['celestaid']=$celestaid;
                $message['first_name']=$first_name;
                $message['last_name']=$last_name;
                $message['email']=$email;
                $message['phone']=$phone;
                $message['qrcode']=$qrcode;
                $message['events_registered']=$events_registered;
                $message['events_participated']=$events_participated;
                $message['access_token']=$access_token;
                $response['message']=$message;
                echo json_encode($response);
            }//Else part of active
            
        }else{
            $errors[]="Invalid credentials.";
            $response['status']='403';//Login failed
            $response['message']=$errors;
            echo json_encode($response);
        }
    }
}

// Function to logout
function logout_user(){
    $celestaid=$_POST['celestaid'];
    $access_token=$_POST['access_token'];
    $response=array();
    $errors=array();

    $sql="SELECT id, access_token FROM users WHERE celestaid='$celestaid' AND access_token='$access_token'";
    $result=query($sql);

    if(row_count($result)==1){
        $sql1= "UPDATE users SET access_token='' WHERE celestaid='$celestaid'";
        $result1=query($sql1);

        $response['status']=202;
        $errors[]="Successfully logged out.";
    }else{
        $response['status']=401;
        $errors[]="Invalid authentication.";
    }
    $response['message']=$errors;
    echo json_encode($response);
}

// Function to get profile details
function profile(){

    $response=array();
    $errors=array();
    $message=array();
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $celestaid=$_POST['celestaid'];
        $access_token= $_POST['access_token'];

        $sql="SELECT * FROM users WHERE celestaid='$celestaid' AND access_token='$access_token'";
        $result=query($sql);

        if(row_count($result)==1){
            $row=fetch_array($result);

                $first_name=$row['first_name'];
                $last_name=$row['last_name'];
                $email=$row['email'];
                $qrcode=$row['qrcode'];
                $celestaid=$row['celestaid'];
                $events_registered=$row['events_registered'];
                $events_participated=$row['events_participated'];
                $phone=$row['phone'];
    
                $response['status']='202';// Profile access validated
                $message['celestaid']=$celestaid;
                $message['first_name']=$first_name;
                $message['last_name']=$last_name;
                $message['email']=$email;
                $message['phone']=$phone;
                $message['qrcode']=$qrcode;
                $message['events_registered']=$events_registered;
                $message['events_participated']=$events_participated;
                $message['access_token']=$access_token;
                $response['message']=$message;
                echo json_encode($response);
            
        }else{
            $errors[]="Invalid access token. Unauthorized to access the data.";
            $response['status']='403';// Unauthorized access
            $response['message']=$errors;
            echo json_encode($response);
        }
    }

}