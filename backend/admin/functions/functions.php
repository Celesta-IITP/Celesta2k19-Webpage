<?php
/*******************Useful Functions*****************/
include('utility.php');

//require "../../utility.php";

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

function celestaid_exist_present_user($celestaid){
	$sql="SELECT id FROM present_users WHERE celestaid='$celestaid'";
	$result=query($sql);
	if(row_count($result)==1){
		return true;
	}
	else{
		return false;
	}
}

//Logging in the admin registrar
function login_registrar(){
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$registrar=clean($_POST['email']);
 		$password=clean($_POST['password']);
 		$remember=isset($_POST['remember']);
 		$password=md5($password);
 		$sql="SELECT id, permit FROM admins WHERE email='".$registrar."' AND password='".$password."'";
 		$result=query($sql);

 		if(row_count($result)==1){
 			$row=fetch_array($result);
			 $permit=$row['permit'];

 			$_SESSION['registrar']=$registrar;
 			$_SESSION['permit']=$permit;
 			if($remember=="on"){
 				setcookie('registrar',$registrar,time()+86400);
 				setcookie('rpermit',$permit,time()+86400);
 			}
			 set_message("<p class='bg-success text-center'>Logged in succesfully.<br>Email: $registrar <br> Permit: $permit</p>");

			 if($permit==1 || $permit ==2){
				redirect("total_register.php");
			 }elseif($permit==3){
				 redirect("cas.php");
			 }elseif($permit==0){ //Super Admin has access to everything
				 redirect("total_register.php");
			 }elseif($permit==4){
				 return redirect("./events.php");
			 }
			 else{
				 echo "Logged in - ".$permit;
			 }
 			
 		}else{
 			echo validation_errors("Failed to login.");
 		}
	}
}

//To check wether registrar is logged in or not
function registrar_logged_in(){
	if(isset($_SESSION['registrar']) || isset($_COOKIE['registrar'])){
		return true;
	}
	else{
		return false;
	}
}

function getPermit(){
	if(isset($_SESSION['permit'])){
		return $_SESSION['permit'];
	}
	if(isset($_COOKIE['permit'])){
		return $_COOKIE['permit'];
	}
}

//Function that handles register.php
function registrar_register(){
	if(!registrar_logged_in())
	{
		redirect("login.php");
	}else
	{
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			if(isset($_POST['get_details']))
			{
				$celestaid=clean($_POST['celestaid']);

				//Bring data about user from the database
				$sql="SELECT first_name,last_name,gender,email,phone,college,active FROM users WHERE celestaid='".escape($celestaid)."' ";
				$result=query($sql);
				confirm($result);

				if(row_count($result)==1 )
				{
					if((celestaid_exist_present_user($celestaid)) && (getPermit()==2 || getPermit()==0))
					{
						$sql3="SELECT total_charge,registration_charge,tshirt_charge,bandpass_charge FROM present_users WHERE celestaid='".escape($celestaid)."' ";
						$result3=query($sql3);
						$row3=fetch_array($result3);

						$total_charge=$row3['total_charge'];
						$tshirt_charge=$row3['tshirt_charge'];
						$bandpass_charge=$row3['bandpass_charge'];
						$registration_charge=$row3['registration_charge'];

						$row=fetch_array($result);
						$first_name=$row['first_name'];
						$last_name=$row['last_name'];
						$gender=$row['gender'];
						$email=$row['email'];
						$phone=$row['phone'];
						$college=$row['college'];
						$active=$row['active'];

						//Filling the form with details
						//document.getElementById("celestaid").value = $celestaid;
						$to_show="

						<div class='register'>
							    <div class='row'>
							        <div class='col-md-3 register-left'>
							            <img src='https://image.ibb.co/n7oTvU/logo_white.png' alt=''/>
							            <h3>Welcome</h3>
							            <h3>To Celesta2k19 !!</h3>
							            <p>The Techno Cultural Fest of IIT Patna</p>
							            <input type='submit' onclick='location.href=\"new_register.php\";'name='' value='New User'/><br/>
							        </div>
							        <div class='col-md-9 register-right'>
							            <ul class='nav nav-tabs nav-justified' id='myTab' role='tablist'>
							                <li class='nav-item'>
							                    <a class='nav-link active' id='home-tab' data-toggle='tab' href='#' role='tab' aria-controls='home' aria-selected='true'>IIT Patna</a>
							                </li>
							                <li class='nav-item'>
							                    <a class='nav-link' id='profile-tab' data-toggle='tab' href='#' role='tab' aria-controls='profile' aria-selected='false'>Celesta2k19</a>
							                </li>
							            </ul>
							            <div class='tab-content' id='myTabContent'>
							                <div class='tab-pane fade show active' id='home' role='tabpanel' aria-labelledby='home-tab'>
							                    <h3 class='register-heading'>Validate Users</h3>
							                    <form method='post' role='form' id='validate_user_form'>
								                    <div class='row register-form' >
								                        <div class='col-md-6'>
								                            <div class='form-group'>
								                                <input type='text' readonly class='form-control' id='first_name' name='first_name' placeholder='First Name' value='".$first_name."' required />
								                            </div>
								                            <div class='form-group'>
								                                <input type='text' readonly class='form-control' id='last_name' name='last_name' placeholder='Last Name' value='".$last_name."' required />
								                            </div>
								                            <div class='form-group'>
								                                <input type='text' readonly class='form-control' id='celestaid' name='celestaid' placeholder='Celesta ID' value='".$celestaid."' required />
								                            </div>";
		                if($gender=='m')
		                {
		                	$to_show.="<div class='form-group'>
		                                <div class='maxl'>
		                                    <label class='radio inline'> 
		                                        <input type='radio' name='gender' readonly value='m' id='male' checked>
		                                        <span> Male </span> 
		                                    </label>
		                                    <label class='radio inline'> 
		                                        <input type='radio' name='gender' readonly id='female' value='f'>
		                                        <span>Female </span> 
		                                    </label>
		                                </div>
		                            </div>";
		                }else
		                {
		                	$to_show.="<div class='form-group'>
		                                <div class='maxl'>
		                                    <label class='radio inline'> 
		                                        <input type='radio' name='gender' readonly value='m' id='male'>
		                                        <span> Male </span> 
		                                    </label>
		                                    <label class='radio inline'> 
		                                        <input type='radio' name='gender' readonly id='female' value='f' checked>
		                                        <span>Female </span> 
		                                    </label>
		                                </div>
		                            </div>";	                	
		                }            
		                            

		                $to_show.=" 			</div>
							                        <div class='col-md-6'>
							                            <div class='form-group'>
							                                <input type='email' class='form-control' readonly id='email' readonly name='email' placeholder='Your Email' value='".$email."' required/>
							                            </div>
							                            <div class='form-group'>
							                                <input type='text' minlength='10' maxlength='10' readonly name='phone' id='phone' class='form-control' placeholder='Your Phone' value='".$phone."' required/>
							                            </div>
							                            <div class='form-group'>
							                                <input type='text' class='form-control' id='college' readonly name='college' placeholder='Enter Your School/College' value='".$college."' required/>
							                            </div>";

						//For registration charge
						if($registration_charge!=0){
							$to_show.="	<div class='form-group row'>
			                                <div class='col-sm-10'>
			                                    <div class='form-check'>
			                                        <input class='form-check-input' type='checkbox' id='registration_charge' name='registration_charge' readonly checked>
			                                        <label class='form-check-label' for='registration_charge'>
			                                            Registration 
			                                        </label>
			                                    </div>
			                                </div>
			                            </div>";
						}else{
							$to_show.="	<div class='form-group row'>
			                                <div class='col-sm-10'>
			                                    <div class='form-check'>
			                                        <input class='form-check-input' type='checkbox' id='registration_charge' name='registration_charge'>
			                                        <label class='form-check-label' for='registration_charge'>
			                                            Registration 
			                                        </label>
			                                    </div>
			                                </div>
			                            </div>";	
						}


						//For tshirt
						if($tshirt_charge!=0){
							$to_show.="	<div class='form-group row'>
			                                <div class='col-sm-10'>
			                                    <div class='form-check'>
			                                        <input class='form-check-input' type='checkbox' id='tshirt_charge' name='tshirt_charge' checked>
			                                        <label class='form-check-label' for='rtshirt_charge'>
			                                            Tshirt
			                                        </label>
			                                    </div>
			                                </div>
			                            </div>";
						}else{
							$to_show.="	<div class='form-group row'>
			                                <div class='col-sm-10'>
			                                    <div class='form-check'>
			                                        <input class='form-check-input' type='checkbox' id='tshirt_charge' name='tshirt_charge'>
			                                        <label class='form-check-label' for='tshirt_charge'>
			                                            Tshirt
			                                        </label>
			                                    </div>
			                                </div>
			                            </div>";	
						}

						//For bandpass
						if($bandpass_charge!=0){
							$to_show.="	<div class='form-group row'>
			                                <div class='col-sm-10'>
			                                    <div class='form-check'>
			                                        <input class='form-check-input' type='checkbox' id='bandpass_charge' name='bandpass_charge' checked>
			                                        <label class='form-check-label' for='bandpass_charge'>
			                                            Bandpass
			                                        </label>
			                                    </div>
			                                </div>
			                            </div>";
						}else{
							$to_show.="	<div class='form-group row'>
			                                <div class='col-sm-10'>
			                                    <div class='form-check'>
			                                        <input class='form-check-input' type='checkbox' id='bandpass_charge' name='bandpass_charge'>
			                                        <label class='form-check-label' for='bandpass_charge'>
			                                            Bandpass 
			                                        </label>
			                                    </div>
			                                </div>
			                            </div>";	
						}						



						$to_show.="<input type='submit' class='btnRegister' id='valid_user' name='valid_user' value='Register'/>
							                        </div>
							                    </div>
							                </form>
							                </div>
							            </div>
							        </div>
							    </div>
						</div>";

						echo $to_show;	//Displays the form
					}elseif((celestaid_exist_present_user($celestaid)) && (getPermit()!=2 || getPermit()!=0)){
						echo validation_errors("You donot have the permit to do the following changes.");

					}elseif(!celestaid_exist_present_user($celestaid)){

						$row=fetch_array($result);
						$first_name=$row['first_name'];
						$last_name=$row['last_name'];
						$gender=$row['gender'];
						$email=$row['email'];
						$phone=$row['phone'];
						$college=$row['college'];
						$active=$row['active'];

						//Filling the form with details
						//document.getElementById("celestaid").value = $celestaid;
						$to_show="

						<div class='register'>
							    <div class='row'>
							        <div class='col-md-3 register-left'>
							            <img src='https://image.ibb.co/n7oTvU/logo_white.png' alt=''/>
							            <h3>Welcome</h3>
							            <h3>To Celesta2k19 !!</h3>
							            <p>The Techno Cultural Fest of IIT Patna</p>
							            <input type='submit' onclick='location.href=\"new_register.php\";'name='' value='New User'/><br/>
							        </div>
							        <div class='col-md-9 register-right'>
							            <ul class='nav nav-tabs nav-justified' id='myTab' role='tablist'>
							                <li class='nav-item'>
							                    <a class='nav-link active' id='home-tab' data-toggle='tab' href='#' role='tab' aria-controls='home' aria-selected='true'>IIT Patna</a>
							                </li>
							                <li class='nav-item'>
							                    <a class='nav-link' id='profile-tab' data-toggle='tab' href='#' role='tab' aria-controls='profile' aria-selected='false'>Celesta2k19</a>
							                </li>
							            </ul>
							            <div class='tab-content' id='myTabContent'>
							                <div class='tab-pane fade show active' id='home' role='tabpanel' aria-labelledby='home-tab'>
							                    <h3 class='register-heading'>Validate Users</h3>
							                    <form method='post' role='form' id='validate_user_form'>
								                    <div class='row register-form' >
								                        <div class='col-md-6'>
								                            <div class='form-group'>
								                                <input type='text' class='form-control' id='first_name' name='first_name' placeholder='First Name' value='".$first_name."' required />
								                            </div>
								                            <div class='form-group'>
								                                <input type='text' class='form-control' id='last_name' name='last_name' placeholder='Last Name' value='".$last_name."' required />
								                            </div>
								                            <div class='form-group'>
								                                <input type='text' readonly class='form-control' id='celestaid' name='celestaid' placeholder='Celesta ID' value='".$celestaid."' required />
								                            </div>";
		                if($gender=='m')
		                {
		                	$to_show.="<div class='form-group'>
		                                <div class='maxl'>
		                                    <label class='radio inline'> 
		                                        <input type='radio' name='gender' value='m' id='male' checked>
		                                        <span> Male </span> 
		                                    </label>
		                                    <label class='radio inline'> 
		                                        <input type='radio' name='gender' id='female' value='f'>
		                                        <span>Female </span> 
		                                    </label>
		                                </div>
		                            </div>";
		                }else
		                {
		                	$to_show.="<div class='form-group'>
		                                <div class='maxl'>
		                                    <label class='radio inline'> 
		                                        <input type='radio' name='gender' value='m' id='male'>
		                                        <span> Male </span> 
		                                    </label>
		                                    <label class='radio inline'> 
		                                        <input type='radio' name='gender' id='female' value='f' checked>
		                                        <span>Female </span> 
		                                    </label>
		                                </div>
		                            </div>";	                	
		                }            
		                            

		                $to_show.=" 			</div>
							                        <div class='col-md-6'>
							                            <div class='form-group'>
							                                <input type='email' class='form-control' id='email' readonly name='email' placeholder='Your Email' value='".$email."' required/>
							                            </div>
							                            <div class='form-group'>
							                                <input type='text' minlength='10' maxlength='10' name='phone' id='phone' class='form-control' placeholder='Your Phone' value='".$phone."' required/>
							                            </div>
							                            <div class='form-group'>
							                                <input type='text' class='form-control' id='college' name='college' placeholder='Enter Your School/College' value='".$college."' required/>
							                            </div>
							                            <div class='form-group row'>
							                                <div class='col-sm-10'>
							                                    <div class='form-check'>
							                                        <input class='form-check-input' type='checkbox' id='registration_charge' name='registration_charge' checked>
							                                        <label class='form-check-label' for='registration_charge'>
							                                            Registration 
							                                        </label>
							                                    </div>
							                                </div>
							                            </div>

							                            <div class='form-group row'>
							                                <div class='col-sm-10'>
							                                    <div class='form-check'>
							                                        <input class='form-check-input' type='checkbox' id='tshirt_charge' name='tshirt_charge'>
							                                        <label class='form-check-label' for='tshirt_charge'>
							                                            T-Shirt (Rs 300)
							                                        </label>
							                                    </div>
							                                </div>
							                            </div>

							                            <div class='form-group row'>
							                                <div class='col-sm-10'>
							                                    <div class='form-check'>
							                                        <input class='form-check-input' type='checkbox' id='bandpass_charge' name='bandpass_charge'>
							                                        <label class='form-check-label' for='bandpass_charge'>
							                                            Band Pass
							                                        </label>
							                                    </div>
							                                </div>
							                            </div>                    

							                            <input type='submit' class='btnRegister' id='valid_user' name='valid_user' value='Register'/>
							                        </div>
							                    </div>
							                </form>
							                </div>
							            </div>
							        </div>
							    </div>
						</div>";

						echo $to_show;	//Displays the form



					}

				}else
				{

					echo validation_errors("Celesta id - $celestaid doesnot exist. Please register.");
				}
			}elseif(isset($_POST['valid_user']))
			{//Function that will add the user in present_user database

				//Default values
				$price_tshirt=300;
				$price_reg=100;
				$price_bandass=200;
				$price_both=400;
				
				//Setting price
				$total_charge=0;
				$registration_charge=0;
				$bandpass_charge=0;
				$tshirt_charge=0;

				if(isset($_POST['registration_charge'])){
					$total_charge=$total_charge+$price_reg;
					$registration_charge=$price_reg;
				}
				if(isset($_POST['bandpass_charge'])){
					$total_charge=$total_charge+$price_bandass;
					$bandpass_charge=$price_bandass;
				}
				if(isset($_POST['tshirt_charge'])){
					$total_charge=$total_charge+$price_tshirt;
					$tshirt_charge=$price_tshirt;
				}

				if((isset($_POST['bandpass_charge'])) && isset($_POST['tshirt_charge'])){
					$total_charge=$total_charge-$price_bandass-$price_tshirt+$price_both;
				}

				//Gathering updated information from the form
				$first_name=clean($_POST['first_name']);
		 		$last_name=clean($_POST['last_name']);
		 		$phone=clean($_POST['phone']);
		 		$college=clean($_POST['college']);
		 		$gender=$_POST['gender'];
		 		$celestaid=$_POST['celestaid'];
		 		$email=$_POST['email'];

		 		$sql="SELECT * FROM users WHERE celestaid='".$celestaid."' ";
		 		$result=query($sql);
		 		$row=fetch_array($result);

		 		//Getting other datas from the server
		 		$password=$row['password'];
		 		$added_by=$row['added_by'];
		 		$events_registered=$row['events_registered'];
		 		$events_participated=$row['events_participated'];
		 		$qrcode=$row['qrcode'];
		 		$active=$row['active'];

		 		if(!celestaid_exist_present_user($celestaid)){

			 		$sql1="INSERT INTO present_users(first_name,last_name,phone,college,gender,celestaid,email,password,added_by, events_registered, events_participated , qrcode,active,registration_charge, tshirt_charge, bandpass_charge, total_charge) VALUES('$first_name', '$last_name', '$phone', '$college','$gender','$celestaid','$email','$password','$added_by','$events_registered','$events_participated','$qrcode','1', $registration_charge,$tshirt_charge,$bandpass_charge,$total_charge)";

			 		$result1=query($sql1);

			 		$subject="Celesta2k19 Billing";
					$msg="<p><h1> Welcome to Celesta2k19</h1><br>
						Your Celesta Id is ".$celestaid.". You have been verified as a participant present in the fest.<br/>
						You need to pay Rs. $total_charge to complete registration desk.<br>
						You qr code is <img src='$qrcode'/> <a href='$qrcode'>click here</a><br/>
						</p>
					";
					$header="From: hayyoulistentome@gmail.com";

					if(send_email($email,$subject,$msg,$header)){
						set_message("<p class='bg-success text-center'>Thank you $first_name $last_name for participating in Celetsa2k19.<br> You can login with the celesta id and the password to stay updated.<br><br><br>Your Celesta id is $celestaid<br>Total amount to pay is: Rs. $total_charge<br> <img src='$qrcode' alt='QR Code cannot be displayed.'/> <br><br></p>");
			 			redirect('display.php');
					}else{
						set_message("<p class='bg-danger text-center'>Sorry we failed to send the confirmation mail to the user.</p>");
					}		 			
		 		}elseif((celestaid_exist_present_user($celestaid)) && (getPermit()==2 || getPermit()==0))
		 		{
		 			//$sql2="UPDATE present_users SET "
		 			$sql3="SELECT total_charge,registration_charge,tshirt_charge,bandpass_charge FROM present_users WHERE celestaid='".escape($celestaid)."' ";
					$result3=query($sql3);
					$row3=fetch_array($result3);

					$initial_total_charge=$row3['total_charge'];
					$amount_to_pay=$total_charge-$initial_total_charge;

		 			$subject="Celesta2k19 Rebilling";
					$msg="<p><h1> Billing has been updated for Celesta Id: ".$celestaid.".</h1><br> New total bill amount is: Rs. $total_charge.<br/>
						You need to pay Rs $amount_to_pay<br>
						You qr code is <img src='$qrcode'/> <a href='$qrcode'>click here</a><br/>
						</p>
					";
					$header="From: hayyoulistentome@gmail.com";

					if(send_email($email,$subject,$msg,$header)){

						$sql4="UPDATE present_users SET total_charge=$total_charge, tshirt_charge=$tshirt_charge, bandpass_charge=$bandpass_charge, registration_charge=$registration_charge WHERE celestaid='$celestaid'";
						$result4=query($sql4);
						confirm($result4);

						set_message("<p class='bg-success text-center'>Thank you $first_name $last_name for participating in Celetsa2k19.<br> Your updated bill has been sent to your email.<br>New total bill amount is: Rs. $total_charge.<br/>
							You need to pay Rs $amount_to_pay<br><br>Your Celesta id is $celestaid<br><br> <img src='$qrcode' alt='QR Code cannot be displayed.'/> <br><br></p>");
			 		redirect('display.php');
		 		}
			}else{
				echo validation_errors("You donot have the permit to do the following changes.");
			}
		}
	}
}
}

//Function that handles total_register.php
function total_register(){
	if(!registrar_logged_in()){
		redirect("login.php");
	}else{
		//echo "Will shortly display the result";
		$sql="SELECT first_name, last_name, college, date, celestaid, qrcode, phone FROM present_users";
		$result=query($sql);
		$permit=getPermit();
		$count=0;

		while ($row = $result->fetch_assoc()) {
			$count=$count+1;
			if($permit==1){
				echo "<tr>
						<th scope='row'>".$count."</th>
	      				<td>".$row['celestaid']."</td>
	      				<td>".$row['date']."</td>
	      				<td>".$row['first_name']." ".$row['last_name']."</td>
	      				<td>".$row['college']."</td>
	      				<td> Not Authorized</td>
	      				<td>".$row['qrcode']."</td>
	    			</tr>";
    		}elseif($permit==2 || $permit==0){
    			echo "<tr>
						<th scope='row'>".$count."</th>
	      				<td>".$row['celestaid']."</td>
	      				<td>".$row['date']."</td>
	      				<td>".$row['first_name']." ".$row['last_name']."</td>
	      				<td>".$row['college']."</td>
	      				<td>".$row['phone']."</td>
	      				<td>".$row['qrcode']."</td>
	    			</tr>";
    		}
		}


	}
}

//Attaching the qr code generator
function generateQRCode($celestaid,$first_name,$last_name){
	include("./../user/functions/qrCodeGenerator/qrlib.php");
	QRcode::png($celestaid."/".$first_name."/".$last_name,"./../user/assets/qrcodes/".$celestaid.".png","H","10","10");
}

//Registers users who donot have celestaid
function new_register(){
	if(!registrar_logged_in()){
		redirect("login.php");
	}else{
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$errors=[];
			$first_name=clean($_POST['first_name']);
	 		$last_name=clean($_POST['last_name']);
	 		$phone=clean($_POST['phone']);
	 		$college=clean($_POST['college']);
	 		$email=clean($_POST['email']);
	 		$password=clean($_POST['password']);
	 		$confirm_password=clean($_POST['confirm_password']);
	 		$gender=($_POST['gender']);
	 		$reg=$_POST['registration_charge'];
	 		$tshirt=$_POST['tshirt_charge'];
			 $bandpass=$_POST['bandpass_charge'];

	 		if($password!=$confirm_password){
	 			$errors[]="Both the password fields are not equal.";
	 		}

	 		if(email_exists($email)) {
	 			$errors[]="Email already taken";
	 		}

			if(!empty($errors)){
	 			foreach($errors as $error){
	 				echo validation_errors($error);
	 			}
	 		}else{
	 			if(new_register_user($first_name,$last_name,$phone,$college,$email,$password,$gender)){
	 				redirect("display.php");
	 			}
	 			else{
		 			set_message("<p class='bg-danger text-center'>Sorry we couldn't register the user.</p>");
		 			echo "User registration failed";
	 			}
	 		
	 		}		 		
		}
		
	}
}

//Register the new user into both the database
function new_register_user($first_name,$last_name,$phone,$college,$email,$password,$gender){
	$first_name=escape($first_name);
	$last_name=escape($last_name);
	$phone=escape($phone);
	$college=escape($college);
	$email=escape($email);
	$password=escape($password);

	//Default values
	$price_tshirt=300;
	$price_reg=100;
	$price_bandass=200;
	$price_both=400;
	

	//Setting price
	$total_charge=0;
	$registration_charge=0;
	$bandpass_charge=0;
	$tshirt_charge=0;
	if(isset($_POST['registration_charge'])){
		$total_charge=$total_charge+$price_reg;
		$registration_charge=$price_reg;
	}
	if(isset($_POST['bandpass_charge'])){
		$total_charge=$total_charge+$price_bandass;
		$bandpass_charge=$price_bandass;
	}
	if(isset($_POST['tshirt_charge'])){
		$total_charge=$total_charge+$price_tshirt;
		$tshirt_charge=$price_tshirt;
	}

	if((isset($_POST['bandpass_charge'])) && isset($_POST['tshirt_charge'])){
		$total_charge=$total_charge-$price_bandass-$price_tshirt+$price_both;
	}

	$registrar_name=$_COOKIE['registrar'];
	$password=md5($password);
	$celestaid=getCelestaId();
	generateQRCode($celestaid,$first_name,$last_name);
	$qrcode="https://celesta.org.in//backend/user/assets/qrcodes/".$celestaid.".png";

	//CONTENTS OF EMAIL
	$subject="Activate Celesta Account";
	$msg="<p>
		Your Celesta Id is ".$celestaid.". Your account has been auto activated.<br/>
		Total Amount to pay is: Rs. $total_charge<br>
		You qr code is <img src='$qrcode'/> <a href='$qrcode'>click here</a><br/>
		
		</p>
	";
	$header="From: hayyoulistentome@gmail.com";
	
	//Added to database if mail is sent successfully
	if(send_email($email,$subject,$msg,$header)){

		//Inserting into present_users table. Users present in fest
		$sql="INSERT INTO present_users(first_name ,last_name, phone,college,email,password, celestaid,qrcode,gender,added_by,active, registration_charge, tshirt_charge, bandpass_charge, total_charge) ";
		$sql.=" VALUES('$first_name','$last_name','$phone','$college','$email','$password','$celestaid','".$qrcode."','$gender','$registrar_name',1,$registration_charge,$tshirt_charge,$bandpass_charge,$total_charge)";
		$result=query($sql);
		confirm($result);

		//Inserting into actual database
		$sql1="INSERT INTO users(first_name,last_name,phone,college,email,password,celestaid,qrcode,gender,added_by,active,validation_code) ";
		$sql1.=" VALUES('$first_name','$last_name','$phone','$college','$email','$password','$celestaid','".$qrcode."','$gender','$registrar_name',1,'0')";
		$result1=query($sql1);
		confirm($result1);

		set_message("<p class='bg-success text-center'>Please check your email oto get your qrcode and celesta id. You can login now with the celesta id and the password.<br><br><br>Your Celesta id is $celestaid<br>Amount to pay is Rs. $total_charge<br> <img src='$qrcode' alt='QR Code cannot be displayed.'/> <br><br></p>");
		return true;
	}else{
		return false;
	}
}


/******************************************* MPR Section **************************************************/
// Show the list of campus ambassador to the MPR people

function show_ca_users(){
	if(!registrar_logged_in()){
		redirect("login.php");
	}elseif(getPermit()==0 || getPermit()==3){
		$sql="SELECT first_name, last_name, college, celestaid, phone, excitons, gravitons FROM ca_users WHERE active=1";
		$result=query($sql);
		$permit=getPermit();

		$data=array();
		while ($row = $result->fetch_assoc()) {
    		if($permit==3 || $permit==0){
				$data[]=$row;
    		}
		}
		return $data;
	}
}

function ca_calls(){
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(isset($_POST["search_ca"])){
			search_ca();
		}elseif(isset($_POST["save_ca"])){
			if($_POST['save_ca']=='save_ca'){
				update_ca();
			}
		}elseif(isset($_POST["cancel_ca"])){
			if($_POST['cancel_ca']=='cancel_ca'){
				cancel_ca();
			}
		}
	}
}

// Function to check if a ca is present or not. If present do it exists or not
function is_ca_exist($celestaid){
	$sql = "SELECT * FROM ca_users WHERE celestaid='$celestaid' AND active=1";
	$result=query($sql);
	if(row_count($result)==1){
		return true;
	}else{
		return false;
	}
}

// Function to search ca
function search_ca(){
	$celestaid = clean($_POST["celestaid"]);
	if(is_ca_exist($celestaid)){
		$_SESSION["searched_ca"]=$celestaid;
		redirect("ca.php");
	}else{
		echo validation_errors("Record not found");
	}
}

// Function to show details of searched ca
function searched_ca(){
	if(isset($_SESSION["searched_ca"])){
		if(is_ca_exist($_SESSION["searched_ca"])){
			$celestaid = $_SESSION["searched_ca"];
			$sql="SELECT first_name, last_name, college, celestaid, phone, excitons, gravitons FROM ca_users WHERE celestaid='$celestaid'";
			$result=query($sql);
            $row = fetch_array($result);
			return $row;
		}else{
			redirect("cas.php");
		}
	}else{
		redirect("cas.php");
	}
}
function update_ca(){
	$celestaid = clean($_POST['celestaid']);
	$excitons = (int)clean($_POST["excitons"]);
	$gravitons = (int)clean($_POST["gravitons"]);

	$sql = "UPDATE ca_users SET gravitons=$gravitons, excitons=$excitons WHERE celestaid='$celestaid'";
	$result = query($sql);
	redirect('./cas.php');
	unset($_SESSION['searched_ca']);
	echo "alert('Updated the score points')";

}

function cancel_ca(){
	redirect('./cas.php');
	unset($_SESSION['searched_ca']);
}
/******************************************* MPR Section Ends**************************************************/




/******************************************* Events Section **************************************************/
/** This section of the page contains the backend functions to add and modify events.
 * Meri jaan Atreyee, tere bina kuch idea nahi ata yaar. Ab maan bhi jao. Paas aa jao. Kitne din aur dur rakhoge.
 */

 // To get an event id
function getEventId(){
	$exist=true;
	while ($exist) {
		$eventid="ATM".mt_rand(1001,9999);
		$exist=eventid_exists($eventid);
	}
	return $eventid;
}

//To check if the given event id already exists or not
function eventid_exists($eventid){
	$sql="SELECT id FROM events WHERE ev_id='$eventid'";
	$result=query($sql);
	if(row_count($result)==1){
		return true;
	}
	else{
		return false;
	}
}

// Function to add events
function addEvent(){
	if($_SERVER["REQUEST_METHOD"]=="POST"){

		$event_name=clean($_POST["event_name"]);
		$event_category=clean($_POST["event_category"]);
		$event_organizer = clean($_POST["event_organizer"]);
		$ev_club = clean($_POST["ev_club"]);
		$event_desc = clean($_POST["event_desc"]);
		$event_date = clean($_POST["event_date"]);
		$event_start_time = clean($_POST["event_start_time"]);
		$event_end_time = clean($_POST["event_end_time"]);
		$event_org_phone = clean($_POST["event_org_phone"]);

		$event_id =getEventId();

		$target_poster = "./events/posters/";
		$target_rulebook = "./events/rulebook/";
		
		$target_poster_file=$target_poster."$event_id"."_"."$event_name".".jpg";
		$target_rulebook_file=$target_rulebook."$event_id"."_"."$event_name".".pdf";

		if(!isset($_FILES["event_poster"]["tmp_name"]) && !isset($_FILES["event_rulebook"]["tmp_name"])){
			echo "Please add files";
		}

		// Upload the file
		if((move_uploaded_file($_FILES["event_poster"]["tmp_name"],$target_poster_file)) && (move_uploaded_file($_FILES["event_rulebook"]["tmp_name"],$target_rulebook_file))){
			
			$poster_url ="https://celesta.org.in/backend/admin".substr($target_poster_file, 1);
			$rulebook_url = "https://celesta.org.in/backend/admin".substr($target_rulebook_file, 1);

			$sql = "INSERT INTO events(ev_id, ev_category, ev_name, ev_description, ev_organiser, ev_club, ev_org_phone, ev_poster_url, ev_rule_book_url, ev_date, ev_start_time, ev_end_time)";
			$sql .=" VALUES('$event_id','$event_category','$event_name','$event_desc','$event_organizer','$ev_club','$event_org_phone','$poster_url','$rulebook_url','$event_date','$event_start_time','$event_end_time')";
			
			$result = query($sql);
			set_message("<p class='bg-success text-center'>Successfully added the event.<br> Event ID: $event_id</p>");
			redirect("./events.php");

		}else{
			echo "Failed";
		}
	}
}
/********************************************** Addition of Events ends here *****************************************************/

// Show the events created to the events people
function show_events(){
	if(!registrar_logged_in()){
		redirect("login.php");
	}elseif(getPermit()==0 || getPermit()==4){
		$sql="SELECT ev_id, ev_category, ev_name, ev_description, ev_organiser, ev_club, ev_org_phone, ev_poster_url, ev_rule_book_url, ev_date, ev_start_time, ev_end_time FROM events";
		$result=query($sql);
		$permit=getPermit();

		$data=array();
		while ($row = $result->fetch_assoc()) {
    		if($permit==4 || $permit==0){
				$data[]=$row;
    		}
		}
		return $data;
	}
}

/********************************************** Update of Events starts here *****************************************************/

// Function that gathers details of the event by using the eventid.
function getEvent($eventid){
	if(!registrar_logged_in()){
		redirect("login.php");
		return false;
	}
	if(!eventExists($eventid)){
		redirect("events.php");
		return false;
	}

	$sql="SELECT ev_category, ev_name, ev_description, ev_organiser, ev_club, ev_org_phone, ev_poster_url, ev_rule_book_url, ev_date, ev_start_time, ev_end_time FROM events WHERE ev_id='$eventid'";
	$result=query($sql);


	$permit=getPermit();
	$data=array();
	if($permit==4 || $permit==0){
		$data=fetch_array($result);
	}
	return $data;
}

// Function to handle update and cancel button accordingly
function updateEventCalls(){
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(isset($_POST["update_event"])){
			updateEvent();
		}elseif(isset($_POST["cancel_event"])){
			redirect("events.php");
		}elseif(isset($_POST["delete_event"])){
			deleteEvent();
		}
	}

}

// Function to update event details
function updateEvent(){

		$event_name=clean($_POST["event_name"]);
		$event_category=clean($_POST["event_category"]);
		$event_organizer = clean($_POST["event_organizer"]);
		$ev_club = clean($_POST["ev_club"]);
		$event_desc = clean($_POST["event_desc"]);
		$event_date = clean($_POST["event_date"]);
		$event_start_time = clean($_POST["event_start_time"]);
		$event_end_time = clean($_POST["event_end_time"]);
		$event_org_phone = clean($_POST["event_org_phone"]);
		$eventid=clean($_POST["eventid"]);

		$sql = "UPDATE events SET ev_name='$event_name', ev_category='$event_category', ev_description='$event_desc', ev_organiser='$event_organizer', ev_club='$ev_club', ev_org_phone='$event_org_phone', ev_date='$event_date', ev_start_time='$event_start_time', ev_end_time='$event_end_time' WHERE ev_id='$eventid'";
		$result = query($sql);
		confirm($result);

		if(isset($_FILES["event_poster"])){
			$target_poster = "./events/posters/";
			
			$target_poster_file=$target_poster."$eventid"."_"."$event_name".".jpg";
			if(move_uploaded_file($_FILES["event_poster"]["tmp_name"],$target_poster_file)){
				$poster_url ="https://celesta.org.in/backend/admin".$target_poster_file;
				$sql1= "UPDATE events SET ev_poster_url='$poster_url'  WHERE ev_id='$eventid'";
				$result1=query($sql1);
			}
		}

		if(isset($_FILES["event_rulebook"])){
			$target_rulebook = "./events/rulebook/";
			
			$target_rulebook_file=$target_rulebook."$eventid"."_"."$event_name".".pdf";
			if(move_uploaded_file($_FILES["event_poster"]["tmp_name"],$target_rulebook_file)){
				$rulebook_url ="https://celesta.org.in/backend/admin".$target_rulebook_file;
				$sql1= "UPDATE events SET ev_rule_book_url='$rulebook_url'  WHERE ev_id='$eventid'";
				$result1=query($sql1);
			}
		}
		set_message("<p class='bg-success text-center'>Successfully updated the event.<br> Event ID: $eventid</p>");
		redirect("./events.php");


}

// Function to delete event
function deleteEvent(){
	$eventid=clean($_POST["eventid"]);
	$sql= "DELETE FROM events where ev_id='$eventid'";
	$result=query($sql);
	confirm($result);
	set_message("<p class='bg-danger text-center'>Successfully deleted the event.<br> Event ID: $eventid</p>");
	redirect("./events.php");
}

//Function  to check existence of the event
function eventExists($eventid){
	$sql="SELECT id FROM events WHERE ev_id='$eventid'";
	$result = query($sql);
	if(row_count($result)==1){
		return true;
	}else{
		return false;
	}
}


/**********************************************Update of Events ends here *********************************************************/

?>