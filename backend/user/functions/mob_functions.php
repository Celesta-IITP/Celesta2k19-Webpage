<?php ob_start();

session_start();
//Including all necesary files
include('db.php');
include('utility.php');

/** Return value parameters
 * Sample registration response:
 * {
 * 'status': 400,
 * 'message':{
 *              "Email already exists",
 *              "Username less then 3 letters",
 *           }
 * }
 * 
 * Status code values:
 *  400: Registration failed because of wrong inputs
 *  401: Registration failed because of failing to send email
 *  402: Account activation failed
 *  403: Login failed
 *  404: Cannot be checked in or checked out
 *  200: Registration succesfull
 *  201: Activated the celesta id
 *  202: Logged in succefully
 *  203: Succesfully checked in
 */

/** Pass a parameter with f and set value to it
 * Set f=register_user, to perform registration
*/
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['f'])){
        if($_POST['f']=='register_user'){
            user_registration();
        }elseif($_POST['f']=='activate_user'){
            activate_user();
        }elseif($_POST['f']=='login_user'){
            login_user();
        }elseif($_POST['f']=='checkin_checkout'){
            checkin_checkout();
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
            $validation_code=mt_rand(10001,99999);
            generateQRCode($celestaid,$first_name,$last_name);
            $qrcode="https://celesta.org.in/backend/user/assets/qrcodes/".$celestaid.".png";

            //Composing the email
            $subject="Activate Celesta Account";
            $msg="<p>
                Your Celesta Id is ".$celestaid.". <br/>
                You qr code is <img src='$qrcode'/> <a href='$qrcode'>click here</a><br/>

                Your validation code is: $validation_code<br>
                Enter this code in the app to activate your account.
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
                $message['celestaid']=$celestaid;
                $message['qrcode']=$qrcode;
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

//Activate the user
function activate_user(){
    $response=array();
    $errors=array();
    $message=array();
    $celestaid=$_POST['celestaid'];
    $got_validation_code=$_POST['validation_code'];

    //fetching validation code from the database for the particular celstaid
    $sql="SELECT validation_code,email,qrcode FROM users WHERE celestaid='$celestaid'";
    $result=query($sql);
    
    if(row_count($result)==1){
        $row=fetch_array($result);
        $validation_code=$row['validation_code'];
        $email=$row['email'];
        $qrcode=$row['qrcode'];

        if($validate_code==$got_validation_code){
            $sql="UPDATE users SET active=1 WHERE celestais='$celestaid'";
            $result=query($sql);
            $confirm($result);

            #writing the response
            $message[]="Your celestaid: $celestaid has been succesfully activated.";
            $response['status']='201';
            $response['message']=$message;
            echo json_encode($response);

            //Composing the email
            $subject="Activated Celesta Account";
            $msg="<p>
                Your Celesta Id ".$celestaid." has been succesfully activated. <br/>
                You can now login in the app or web.
                You qr code is <img src='$qrcode'/> <a href='$qrcode'>click here</a><br/>
                </p>
            ";
            $header="From: noreply@yourwebsite.com";
            send_email($email,$subject,$msg,$header);


        }else{
            $errors[]="The validation code that you entered is wrong.";
            $response['status']='402';
            $response['message']=$errors;
            echo json_encode($response);
        }
    }else{
        //Will write r=the response code later
        $errors[]="Following Celesta ID have not been registered yet.";
        $response['status']='402';
        $response['message']=$errors;
        echo json_encode($response);
    }
}//User account activation

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
                $access_token=$celestaid.$password;
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

//CheckinCheckout
function checkin_checkout(){
        $response=array();
        $message=array();
        $toadd=array();
        $last_row=array();
        $checkin_checkout=array();
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $celestaid=clean($_POST['celestaid']);
        $date_time=clean($_POST['date_time']);

        $sql="SELECT checkin_checkout,active FROM present_users WHERE celestaid='$celestaid'";
        $result=query($sql);

        if(row_count($result)==1){
            $row=fetch_array($result);
            $active=$row['active'];
            if($active!=1){
                $response['status']='404';
                $message[]="Account is not yet active. You have not yet registered in the registration desk.";
            }else{
                $checkin_checkout=json_decode($row['checkin_checkout']);
                if(!empty($checkin_checkout)){
                    $reverse_data=$checkin_checkout;
                    $last_row=end($reverse_data);

                    //If user have just checked in, he needs to be checked out
                    if($last_row[0]=="checkin"){
                        $toadd[]="checkout";
                        $toadd[]=$date_time;
                        $checkin_checkout[]=$toadd;
                        
                        $checkin_checkout=json_encode($checkin_checkout);
                        $sql2="UPDATE present_users SET checkin_checkout='$checkin_checkout' WHERE celestaid='$celestaid'";
                        $result2=query($sql2);
                       // $response['status']='203';
                        $message[]="Succesfully checked out.";
                        
                    }//Check in user if his last state is checked in
                    else{
                        $toadd[]="checkin";
                        $toadd[]=$date_time;
                        $checkin_checkout[]=$toadd;
                        $checkin_checkout=json_encode($checkin_checkout);
                        $sql3="UPDATE present_users SET checkin_checkout='$checkin_checkout' WHERE celestaid='$celestaid'";
                        $result3=query($sql3);
                       // confirm($result1);
                      //  $response['status']='203';
                        $message[]="Succesfully checked in.";
                    }

                }else{
                    $toadd=array();
                    $toadd[]="checkin";
                    $toadd[]=$date_time;
                    $checkin_checkout[]=$toadd;
                    $checkin_checkout=json_encode($checkin_checkout);
                    $sql1="UPDATE present_users SET checkin_checkout='$checkin_checkout' WHERE celestaid='$celestaid'";
                    $result1=query($sql1);
                   // $response['status']='203';
                    $message[]="Succesfully checked in.";
                }
                $message[]=$last_row;
            }//End of main working part

        }else{
            //$response['status']='404';
            $message[]="Following celestaid have not registered in the registration desk.";
        }
        //$response['message']=$message;
        echo json_encode($message);
    }//Ending of if part of post method
}//Ending of checkin_checkout function