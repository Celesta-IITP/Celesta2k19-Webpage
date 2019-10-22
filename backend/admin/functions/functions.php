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

/********************************************** For naughty Admins only **************************************************/

function show_users(){
	if(!registrar_logged_in()){
		redirect("login.php");
	}elseif(getPermit()==0){
		$sql="SELECT first_name, last_name, college, celestaid, phone, email, gender FROM users";
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



/**************************************************** Registration Section *************************************************/

/*************************************** Register old Registrations ***********************************************/
function checkAuthority(){
	$permit=getPermit();
	if($permit==0 || $permit==1 || $permit==2){
		// redirect("logout.php");
	}else{
		redirect("logout.php");
	}
}

function getUserCall(){
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(isset($_POST['search_details'])){
			$celestaid=escape($_POST['celestaid']);
			return getDetails($celestaid);
		}else{
			return false;
		}
	}else{
		return false;
	}
}

// Call update user function
function validateUserAtDesk(){
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(isset($_POST["validate_user"])){
			updatingUser();
		}
	}
}

// Function to retrieve data of the user from the entered celestaid
function getDetails($celestaid){

	$sql="SELECT * FROM users WHERE celestaid='$celestaid'";
	$result=query($sql);
	confirm($result);

	if(row_count($result)==1){
		$row=fetch_array($result);

		if($row['registration_desk']==1){
			echo "<p class='bg-warning text-center'>$celestaid has already registered in the desk.</p>";
		}

		return $row;
	}else{
		echo "<p class='bg-danger text-center'>$celestaid not found. Please enter correct celestaid.</p>";
		return false;
	}
}

// Get the registration amount of the event
function getEventAmount($ev_id){
	$sql="SELECT id, ev_amount from events where ev_id='$ev_id'";
	$result=query($sql);
	if(row_count($result)==1){
		$row=fetch_array($result);
		return $row['ev_amount'];
	}else{
		return -1;
	}
}

// Function used to register user at registration desk
function updatingUser(){
	$first_name=clean($_POST['first_name']);
	$last_name=clean($_POST['last_name']);
	$celestaid=clean($_POST['celestaid']);
	$email=clean($_POST['email']);
	$phone=clean($_POST['phone']);
	$college=clean($_POST['college']);
	$gender=clean($_POST["gender"]);

	//Default values
	$price_tshirt=300;
	$price_reg=100; // Desk registration charge
	// $price_bandass=200;
	$price_both=400;
	$price_accommodation=500;

	// Get user info
	$sql0="SELECT * from users where celestaid='$celestaid'";
	$result0=query($sql0);
	$row=fetch_array($result0);

	//Setting price
	$total_charge=$row['total_charge'];
	$amount_paid=$row['amount_paid'];
	$registration_charge=$row['registration_charge'];
	// $bandpass_charge=$row['bandpass_charge'];
	$tshirt_charge=$row['tshirt_charge'];
	$events_charge=$row['events_charge'];
	$accommodation_charge=$row['accommodation_charge'];

	if(isset($_POST['registration_charge'])){
		$total_charge=$total_charge+$price_reg;
		$registration_charge+=$price_reg;
		$amount_paid=$amount_paid+$price_reg;
	}

	if(isset($_POST['tshirt_charge'])){
		$total_charge=$total_charge+$price_tshirt;
		$tshirt_charge+=$price_tshirt;
		$amount_paid=$amount_paid+$price_tshirt;
	}

	if(isset($_POST['college_stud'])){
		$college_stud=1;
	}else{
		$college_stud=0;
	}

	// if((isset($_POST['bandpass_charge'])) && isset($_POST['tshirt_charge'])){
	// 	$total_charge=$total_charge-$price_bandass-$price_tshirt+$price_both;
	// }
	$user=getDetails($celestaid);
	$events_registered=json_decode($user['events_registered']);
	$update_user_events_registered=array();
	$paidEvents=array();

	if(!empty($events_registered)){
		foreach($events_registered as $event){
			$ev_id=$event->ev_id;
			$amount=$event ->amount;
			$ev_name=$event ->ev_name;
			$team_name=$event ->team_name;
			$cap_name=$event ->cap_name;

			$add_event=$event;

			if(isset($_POST[$ev_id])){
				$ev_amount=getEventAmount($ev_id);
				$diff=$ev_amount-$amount;
				if($diff>0){
					$total_charge+=$diff;
					$events_charge+=$diff;


					// Update the events registered array
					$add_event=array();
					$add_event["ev_name"]=$ev_name;
					$add_event["ev_id"]=$ev_id;
					$add_event["amount"]=$diff;

					if(!empty($team_name)){
						$add_event['team_name']=$team_name;
						$add_event['cap_name']=$cap_name;
					}
					$update_user_events_registered[]=$add_event;
					updateEventTable($ev_id,$ev_amount,$celestaid,$team_name);
				}else{
					$update_user_events_registered[]=$event;
				}
				$paidEvents[]=$ev_name;
			}else{
				$update_user_events_registered[]=$event;
			}
		}
	}
	// print_r($update_user_events_registered);

	$qrcode=$user['qrcode'];
	$subject="Celesta Account";
	$msg="<p>
		Your Celesta Id is ".$celestaid.".<br>
		Total Amount to pay is: Rs. $total_charge<br>
		You qr code is <img src='$qrcode'/> <a href='$qrcode'>click here</a><br/>
		</p>
	";
	if(!empty($paidEvents)){
		$msg.="<br>Events for which you have successfully registered by paying(if paid event) are: ";
		foreach($paidEvents as $ev){
			$msg.="<br>$ev";
		}
	}
	$header="From: celesta19@gmail.com";

	send_email($email,$subject,$msg,$header);

	if(isset($_POST['accommodation_charge'])){
		$total_charge=$total_charge+$price_accommodation;
		$accommodation_charge=$price_accommodation;
		$name=$first_name." ".$last_name;
		$amount_paid=$amount_paid+$price_accommodation;
		bookAppointment($celestaid,$gender,$name,$phone,$price_accommodation,$email,$qrcode);
	}

	$update_user_events_registered=json_encode($update_user_events_registered);
	$sql="UPDATE users set first_name='$first_name', last_name='$last_name',phone='$phone',college='$college',total_charge=$total_charge,tshirt_charge=$tshirt_charge,events_charge=$events_charge,registration_charge=$registration_charge, events_registered='$update_user_events_registered',amount_paid=$amount_paid, registration_desk=1, iit_patna=$college_stud, accommodation_charge=$accommodation_charge WHERE celestaid='$celestaid'";
	$result=query($sql);
	confirm($result);

	echo "<h3 class='bg-success text-center'>$celestaid successfully registered. Pay amount: Rs. $total_charge </h3>";

}

function updateEventTable($ev_id,$ev_amount,$celestaid,$team_event){

	$sql="SELECT * FROM events WHERE ev_id='$ev_id'";
	$result=query($sql);
	$row=fetch_array($result);

	$ev_registrations=json_decode($row['ev_registrations']);
	$updated_registrations=array();
	foreach($ev_registrations as $reg){
		// If individual event

		$updt=array();
		if(empty($team_event)){
			$get_celestaid=$reg->celestaid;
			$name=$reg->name;
			$time=$reg->time;
			$phone=$reg->phone;
			$amount=$reg->amount;
			$updt['time']=$time;
			$updt['name']=$name;
			$updt['phone']=$phone;
			$updt['amount']=$amount;
			$updt['celestaid']=$celestaid;
			echo "6-";

			if($get_celestaid==$celestaid){
				$updt['amount']=$ev_amount;
			}

		}else{
			$time=$reg->time;
			$amount=$reg->amount;
			$cap_name=$reg->cap_name;
			$cap_phone=$reg->cap_phone;
			$cap_celestaid=$reg->celestaid;
			$team_name=$reg->team_name;
			$cap_email=$reg->cap_email;

			$mem1_name=$reg->mem1_name;
			$mem1_email=$reg->mem1_email;
			$mem1_phone=$reg->mem1_phone;
			$mem1_celestaid=$reg->mem1_celestaid;

			$mem2_name=$reg->mem2_name;
			$mem2_email=$reg->mem2_email;
			$mem2_phone=$reg->mem2_phone;
			$mem2_celestaid=$reg->mem2_celestaid;

			$mem3_name=$reg->mem3_name;
			$mem3_email=$reg->mem3_email;
			$mem3_phone=$reg->mem3_phone;
			$mem3_celestaid=$reg->mem3_celestaid;

			$mem4_name=$reg->mem4_name;
			$mem4_email=$reg->mem4_email;
			$mem4_phone=$reg->mem4_phone;
			$mem4_celestaid=$reg->mem4_celestaid;

			$mem5_name=$reg->mem5_name;
			$mem5_email=$reg->mem5_email;
			$mem5_phone=$reg->mem5_phone;
			$mem5_celestaid=$reg->mem5_celestaid;

			$mem_celestaid=array();

			// Updating datas
			$updt['cap_name']=$cap_name;
			$updt['time']=$time;
			$updt['amount']=$amount;
			$updt['cap_celestaid']=$cap_celestaid;
			$updt['team_name']=$team_name;
			$updt['cap_phone']=$cap_phone;
			$updt['cap_email']=$cap_email;

			$mem_celestaid[]=$celestaid;

			if(!empty($mem1_celestaid)){
				$updt['mem1_name']=$mem1_name;
				$updt['mem1_email']=$mem1_email;
				$updt['mem1_celestaid']=$mem1_celestaid;
				$updt['mem1_phone']=$mem1_phone;
				$mem_celestaid[]=$mem1_celestaid;
			}

			if(!empty($mem2_celestaid)){
				$updt['mem2_name']=$mem2_name;
				$updt['mem2_email']=$mem2_email;
				$updt['mem2_celestaid']=$mem2_celestaid;
				$updt['mem2_phone']=$mem2_phone;
				$mem_celestaid[]=$mem2_celestaid;
			}

			if(!empty($mem3_celestaid)){
				$updt['mem3_name']=$mem3_name;
				$updt['mem3_email']=$mem3_email;
				$updt['mem3_celestaid']=$mem3_celestaid;
				$updt['mem3_phone']=$mem3_phone;
				$mem_celestaid[]=$mem3_celestaid;
			}

			if(!empty($mem4_celestaid)){
				$updt['mem4_name']=$mem4_name;
				$updt['mem4_email']=$mem4_email;
				$updt['mem4_celestaid']=$mem4_celestaid;
				$updt['mem4_phone']=$mem4_phone;
				$mem_celestaid[]=$mem4_celestaid;
			}

			if(!empty($mem5_celestaid)){
				$updt['mem5_name']=$mem5_name;
				$updt['mem5_email']=$mem5_email;
				$updt['mem5_celestaid']=$mem5_celestaid;
				$updt['mem5_phone']=$mem5_phone;
				$mem_celestaid[]=$mem5_celestaid;
			}

			// If id found or matched
			if(in_array($celestaid,$mem_celestaid)){
				$updt['amount']=$ev_amount;
				foreach($mem_celestaid as $clst){
					updateOtherUsers($ev_id,$ev_amount,$clst);
				}
			}
		}

		$updated_registrations[]=$updt;
	}

	$updated_registrations=json_encode($updated_registrations);
	print_r();

	// Add a case to update all users if its a team event

	$sql1="UPDATE events set ev_registrations='$updated_registrations' WHERE ev_id='$ev_id'";
	$result1=query($sql1);

}

function updateOtherUsers($evid,$ev_amount,$celestaid){
	// To update other users data

	$sql="SELECT events_registered, email, qrcode FROM users WHERE celestaid='$celestaid'";
	$result=query($sql);
	if(row_count($result)==1){

		$row=fetch_array($result);
		$events_registered=json_decode($row['events_registered']);
		$qrcode=$row['qrcode'];

		$updated_registered_events=array();

		foreach($events_registered as $event){

			$ev_id=$event->ev_id;
			$amount=$event ->amount;
			$ev_name=$event ->ev_name;
			$team_name=$event ->team_name;
			$cap_name=$event ->cap_name;

			$add_event=array();
			$add_event['ev_id']=$ev_id;
			$add_event['amount']=$amount;
			$add_event['ev_name']=$ev_name;

			if(!empty($cap_name)){
				$add_event['cap_name']=$cap_name;
				$add_event['team_name']=$team_name;
			}

			if($ev_id==$evid){
				$add_event['amount']=$ev_amount;
				$say_name=$ev_name;
			}

			$updated_registered_events[]=$add_event;
		}

		$updated_registered_events=json_encode($updated_registered_events);
		$sql1="UPDATE users SET events_registered='$updated_registered_events' WHERE celestaid='$celestaid'";
		$result1=query($sql1);
		confirm($result1);

		$subject="Celesta Event Registrations Payment";
		$msg="<p>
			Your Celesta Id is ".$celestaid.". You have successfully paid for <b> $evid - $say_name </b>.
			<br>
			Amount paid is: $ev_amount<br>
			Paid By: $celestaid<br>
			You qr code is <img src='$qrcode'/> <a href='$qrcode'>click here</a><br/>
			</p>
		";
		$email=$row['email'];
		$header="From: celesta19@gmail.com";

		send_email($email,$subject,$msg,$header);

	}
}

/******************************************** End of functions ****************************************************/
//Function that handles total_register.php
function total_register(){
	if(!registrar_logged_in()){
		redirect("login.php");
	}else{
		//echo "Will shortly display the result";
		$sql="SELECT first_name, last_name, college, date, celestaid, qrcode, phone,tshirt_charge,registration_charge,accommodation_charge,amount_paid,events_charge,total_charge FROM users WHERE registration_desk=1";
		$result=query($sql);
		$permit=getPermit();
		$count=0;

		while ($row = $result->fetch_assoc()) {
			$count=$count+1;
			if($permit==2 || $permit==0){
    			echo "<tr>
						<th scope='row'>".$count."</th>
	      				<td>".$row['celestaid']."</td>
	      				<td>".$row['date']."</td>
	      				<td>".$row['first_name']." ".$row['last_name']."</td>
	      				<td>".$row['college']."</td>
	      				<td>".$row['phone']."</td>
						<td>".$row['tshirt_charge']."</td>
						<td>".$row['accommodation_charge']."</td>
						<td>".$row['registration_charge']."</td>
						<td>".$row['events_charge']."</td>
						<td>".$row['total_charge']."</td>
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
			// $bandpass=$_POST['bandpass_charge'];
			$referral_id=clean($referral_id);

	 		if($password!=$confirm_password){
	 			$errors[]="Both the password fields are not equal.";
	 		}

	 		if(email_exists($email)) {
	 			$errors[]="Email already taken";
			 }

			if(strlen($referral_id)!=8){
			 	$referral_id ="CLST1504";
		 	}

			if(!empty($errors)){
	 			foreach($errors as $error){
	 				echo validation_errors($error);
	 			}
	 		}else{
	 			if(new_register_user($first_name,$last_name,$phone,$college,$email,$password,$gender,$referral_id)){
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
function new_register_user($first_name,$last_name,$phone,$college,$email,$password,$gender,$referral_id){

	$first_name=escape($first_name);
	$last_name=escape($last_name);
	$phone=escape($phone);
	$college=escape($college);
	$email=escape($email);
	$password=escape($password);

	//Default values
	$price_tshirt=300;
	$price_reg=100;
	$price_accommodation=500;
	$price_both=400;

	// Setting price
	$total_charge=0;
	$registration_charge=0;
	// $bandpass_charge=0;
	$tshirt_charge=0;
	$accommodation_charge=0;

	if(isset($_POST['registration_charge'])){
		$total_charge=$total_charge+$price_reg;
		$registration_charge=$price_reg;
	}
	// if(isset($_POST['bandpass_charge'])){
	// 	$total_charge=$total_charge+$price_bandass;
	// 	$bandpass_charge=$price_bandass;
	// }
	if(isset($_POST['tshirt_charge'])){
		$total_charge=$total_charge+$price_tshirt;
		$tshirt_charge=$price_tshirt;
	}

	if(isset($_POST["college_stud"])){
		$college_stud=1;
	}else{
		$college_stud=0;
	}

	if(isset($_POST["accommodation_charge"])){
		$total_charge=$total_charge+$price_accommodation;
		$accommodation_charge=$price_accommodation;
	}

	// if((isset($_POST['bandpass_charge'])) && isset($_POST['tshirt_charge'])){
	// 	$total_charge=$total_charge-$price_bandass-$price_tshirt+$price_both;
	// }

	$registrar_name=$_SESSION['registrar'];
	if(isset($_COOKIE['registrar'])){
		$registrar_name=$_COOKIE['registrar'];
	}
	$password=md5($password);
	$celestaid=getCelestaId();
	generateQRCode($celestaid,$first_name,$last_name);
	$qrcode="https://celesta.org.in//backend/user/assets/qrcodes/".$celestaid.".png";

	//CONTENTS OF EMAIL
	$subject="Celesta Account";
	$msg="<p>
		Your Celesta Id is ".$celestaid.". Your account has been auto activated.<br/>
		Total Amount to pay is: Rs. $total_charge<br>
		You qr code is <img src='$qrcode'/> <a href='$qrcode'>click here</a><br/>
		
		</p>
	";
	$header="From: celesta19iitp@gmail.com";
	
	//Added to database if mail is sent successfully
	if(send_email($email,$subject,$msg,$header)){

		//Inserting into actual database
		$sql1="INSERT INTO users(first_name,last_name,phone,college,email,password,celestaid,qrcode,gender,added_by,active,validation_code,tshirt_charge,total_charge,registration_charge,amount_paid,registration_desk,iit_patna, accommodation_charge) ";
		$sql1.=" VALUES('$first_name','$last_name','$phone','$college','$email','$password','$celestaid','".$qrcode."','$gender','$registrar_name',1,'0',$tshirt_charge,$total_charge,$registration_charge,$total_charge,1,$college_stud,$accommodation_charge)";
		$result1=query($sql1);
		confirm($result1);

		update_referral_points($referral_id);

		set_message("<p class='bg-success text-center'>Please check your email to get your qrcode and celesta id. You can login now with the celesta id and the password.<br><br><br>Your Celesta id is $celestaid<br>Amount to pay is Rs. $total_charge<br> <img src='$qrcode' alt='QR Code cannot be displayed.'/> <br><br></p>");
		$name=$first_name." ".$last_name;
		if(isset($_POST["accommodation_charge"])){
			bookAppointment($celestaid,$gender,$name,$phone,$price_accommodation,$email,$qrcode);
		}

		return true;
	}else{
		return false;
	}
}

function bookAppointment($celestaid,$gender,$name,$phone,$amount_paid,$email,$qrcode){
	$date=escape(date('Y-m-d H:i:s'));
	$no_of_days=3;
	$day1=1;
	$day2=1;
	$day3=1;

	$sql="INSERT INTO accommodation(celestaid,names,phone,gender,booking_date,no_of_days,day1,day2,day3,amount_paid,email) VALUES('$celestaid','$name','$phone','$gender','$date',$no_of_days,$day1,$day2,$day3,$amount_paid,'$email')";
	$result=query($sql);
	confirm($result);

	$message="<p> Hi $name, you have successfully booked your accommodation for $no_of_days.<br>
	Amount paid for accommodation is : Rs. $amount_paid <br>
	Your celestaid is:$celestaid<br>
	<a href='$qrcode'><img src='$qrcode' alt='Your qr code should be shown here.' style='height:400px;width:400px'/></a>
	</p>";
	$subject="Celesta2k19 Accommodation Booking";
	$headers="From: celesta19iitp@gmail.com";
	send_email($email,$subject,$message,$headers);
}


function update_referral_points($referral_id){
	if(!refrral_id_exist($referral_id)){
		$referral_id="CLST1504";
	}
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
	if(!registrar_logged_in()){
		redirect("login.php");
	}
	if($_SERVER["REQUEST_METHOD"]=="POST"){

		$event_name=escape($_POST["event_name"]);
		$event_category=escape($_POST["event_category"]);
		$event_organizer = escape($_POST["event_organizer"]);
		$ev_club = escape($_POST["ev_club"]);
		$event_desc = escape($_POST["event_desc"]);
		$event_date = escape($_POST["event_date"]);
		$event_start_time = escape($_POST["event_start_time"]);
		$event_end_time = escape($_POST["event_end_time"]);
		$event_org_phone = escape($_POST["event_org_phone"]);
		$ev_amount = escape($_POST['event_amount']);
		$ev_venue = escape($_POST['event_venue']);
		$team_event = escape($_POST["team_event"]);
		$map_url = escape($_POST["map_url"]);
		$team_members = escape($_POST["team_members"]);
		$ev_prize = escape($_POST['ev_prize']);

		if($team_event=="False"){
			$team_event=0;
		}else{
			$team_event=1;
		}

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

			$sql = "INSERT INTO events(ev_id, ev_category, ev_name, ev_description, ev_organiser, ev_club, ev_org_phone, ev_poster_url, ev_rule_book_url, ev_date, ev_start_time, ev_end_time,ev_venue, ev_amount,is_team_event,map_url,team_members,ev_prize)";
			$sql .=" VALUES('$event_id','$event_category','$event_name','$event_desc','$event_organizer','$ev_club','$event_org_phone','$poster_url','$rulebook_url','$event_date','$event_start_time','$event_end_time', '$ev_venue',$ev_amount,$team_event,'$map_url','$team_members','$ev_prize')";

			$result = query($sql);
			
			if($result){
				set_message("<p class='bg-success text-center'>Successfully added the event.<br> Event ID: $event_id</p>");
				redirect("./events.php");
			}else{
				set_message("<p class='bg-danger text-center'>Failed to add.</p>");
			}


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

	$sql="SELECT ev_category, ev_name, ev_description, ev_organiser, ev_club, ev_org_phone, ev_poster_url, ev_rule_book_url, ev_date, ev_start_time, ev_end_time, ev_venue, ev_amount,is_team_event, map_url, team_members, ev_prize FROM events WHERE ev_id='$eventid'";
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

		$event_name=escape($_POST["event_name"]);
		$event_category=escape($_POST["event_category"]);
		$event_organizer = escape($_POST["event_organizer"]);
		$ev_club = escape($_POST["ev_club"]);
		$event_desc = escape($_POST["event_desc"]);
		$event_date = escape($_POST["event_date"]);
		$event_start_time = escape($_POST["event_start_time"]);
		$event_end_time = escape($_POST["event_end_time"]);
		$event_org_phone = escape($_POST["event_org_phone"]);
		$eventid=escape($_POST["eventid"]);
		$team_event=escape($_POST["team_event"]);
		$map_url=escape($_POST['map_url']);
		$event_amount= escape($_POST['event_amount']);
		$event_venue=escape($_POST['event_venue']);
		$team_members=escape($_POST['team_members']);
		$ev_prize=escape($_POST['ev_prize']);

		if($team_event=="False"){
			$team_event=0;
		}else{
			$team_event=1;
		}

		$sql = "UPDATE events SET ev_name='$event_name', ev_category='$event_category', ev_description='$event_desc', ev_organiser='$event_organizer', ev_club='$ev_club', ev_org_phone='$event_org_phone', ev_date='$event_date', ev_start_time='$event_start_time', ev_end_time='$event_end_time', is_team_event='$team_event', ev_amount='$event_amount', ev_venue='$event_venue', map_url='$map_url', team_members='$team_members', ev_prize='$ev_prize' WHERE ev_id='$eventid'";

		$result = query($sql);
		confirm($result);

		if(isset($_FILES["event_poster"])){
			$target_poster = "./events/posters/";
			
			$target_poster_file=$target_poster."$eventid"."_"."$event_name".".jpg";
			if(move_uploaded_file($_FILES["event_poster"]["tmp_name"],$target_poster_file)){
				$poster_url ="https://celesta.org.in/backend/admin".substr($target_poster_file, 1);
				$sql1= "UPDATE events SET ev_poster_url='$poster_url'  WHERE ev_id='$eventid'";
				$result1=query($sql1);
				confirm($result1);
			}
		}

		if(isset($_FILES["event_rulebook"])){
			$target_rulebook = "./events/rulebook/";
			
			$target_rulebook_file=$target_rulebook."$eventid"."_"."$event_name".".pdf";
			if(move_uploaded_file($_FILES["event_rulebook"]["tmp_name"],$target_rulebook_file)){
				$rulebook_url ="https://celesta.org.in/backend/admin".substr($target_rulebook_file, 1);
				$sql1= "UPDATE events SET ev_rule_book_url='$rulebook_url'  WHERE ev_id='$eventid'";
				$result1=query($sql1);
				confirm($result1);
			}
		}
		set_message("<p class='bg-success text-center'>Successfully updated the event.<br> Event ID: $eventid</p>");
		redirect("./events.php");


}

// FUnction to show participants of an event
function showEventParticipants(){
	$permit=getPermit();
	if($_SERVER["REQUEST_METHOD"]=="GET"){
		if($permit==4 || $permit==0){
			$ev_id=clean($_GET['eventid']);
			$sql="SELECT id, ev_registrations, is_team_event, ev_name FROM events WHERE ev_id='$ev_id'";
			$result=query($sql);
			confirm($result);

			if(row_count($result)==1){
				$row=fetch_array($result);
				return $row;
			}else{
				return false;
			}

		}else{
			redirect("logout.php");
			return false;
		}
	}

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

//Function  to check existence of a singleton team event
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