<?php include('functions/init.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Celesta2k19 || Registration Desk</title>
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/register.css">
</head>
<body>
<?php 
	if(!registrar_logged_in()){
		redirect("login.php");
	}
?>


<!------ Include the above in your HEAD tag ---------->
<div class="container">
	<?php include('includes/nav.php') ?>
	<?php display_message();
			checkAuthority();
			validateUserAtDesk(); ?>
	<?php $user = getUserCall() ?>
	<?php ?>
</div>	

<div class="container">
	<br>
	<br>
	<div class='row justify-content-md-center'>
		<div class="col-md-auto">
		<form class="form-inline" method="post" role="form" id="show_data">
		  <div class="form-group mb-2">
		    <label for="staticEmail2" class="sr-only">Email</label>
		    <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Enter the Celesta ID:">
		  </div>
		  <div class="form-group mx-sm-3 mb-2">
		    <label for="celestaid" class="sr-only">Celesta ID</label>
		    <input type="text" class="form-control" name='celestaid' id="celestaid" placeholder="CLST1504" value="CLST">
		  </div>
		  	<input type="hidden" name="search_details" id="search_details" value="search_details" >
		  <button type="submit" name="get_details" class="btn btn-primary mb-2">Search Details</button>
		</form>
		</div>
	</div>
	</div>

	<?php if($user!=false){?>


		<div class="container register">
			<div class="row">
				<div class="col-md-3 register-left">
					<img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
					<h3>Welcome</h3>
					<h3>To Celesta2k19 !!</h3>
					<p>The Techno Cultural Fest of IIT Patna</p>
					<input type="submit" onclick="location.href='new_register.php';" name="" value="New User"/><br/>
				</div>
				<div class="col-md-9 register-right">
					<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="home-tab" data-toggle="tab" href="#" role="tab" aria-controls="home" aria-selected="true">IIT Patna</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="profile-tab" data-toggle="tab" href="#" role="tab" aria-controls="profile" aria-selected="false">Celesta2k19</a>
						</li>
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
							<h3 class="register-heading">Validate User</h3>
							<form method="post" role="form">
							<div class="row register-form" >
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="<?php echo $user['first_name']?>" required />
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo $user['last_name']?>" required />
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="celestaid" name="celestaid" placeholder="CLST****" value="<?php echo $user['celestaid']?>" required readonly/>
									</div>
									<!-- <div class="form-group">
										<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password *" value="qwerty123" required />
									</div> -->
									<div class="form-group">
										<div class="maxl">
											<label class="radio inline"> 
												<input type="radio" name="gender" value="m" <?php if($user['gender']=='m'){
													echo "checked";} ?> >
												<span> Male </span> 
											</label>
											<label class="radio inline"> 
												<input type="radio" name="gender" value="f" <?php if($user['gender']=='f'){
													echo "checked";}?> >
												<span>Female </span> 
											</label>
										</div>
									</div> 
									<span><b>Events Registered</b></span>
									<?php $events = json_decode($user['events_registered']);
										foreach($events as $event){
											$ev_id=$event->ev_id;
											$ev_name=$event->ev_name;
											$amount=$event ->amount;
											$team_name=$event ->team_name;
											$event_amount=getEventAmount($ev_id);
											$diff=$event_amount-$amount;
											?>
											
									<div class="form-group row">
										<div class="col-sm-10">
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="<?php echo $ev_id?>" name='<?php echo $ev_id?>' <?php if($diff<=0){echo "checked disabled='disabled'";} ?>>
												<label class="form-check-label" for="registration_charge">
													<?php echo $ev_name." Pay: ";
													if($diff>0){
														echo $diff;
													}else{
														echo 0;
													}?>
												</label>
											</div>
										</div>
									</div>
									<?php } ?>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<input type="email" class="form-control" id="email" name="email" placeholder="Your Email" value="<?php echo $user['email']?>" required readonly/>
									</div>
									<div class="form-group">
										<input type="text" minlength="10" maxlength="10" name="phone" id="phone" class="form-control" placeholder="Your Phone" value="<?php echo $user['phone']?>" required/>
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="college" name="college" placeholder="Enter Your School/College" value="<?php echo $user['college']?>" required/>
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="referral" name="referral" placeholder="Referral ID" value="REFERRAL ID: <?php echo $user['referral_id']?>" required readonly/>
									</div>

									<div class="form-group row">
										<div class="col-sm-10">
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="registration_charge" name='registration_charge'>
												<label class="form-check-label" for="registration_charge">
													Registration 
												</label>
											</div>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-10">
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="college_stud" name='college_stud'>
												<label class="form-check-label" for="college_stud">
													IIT Patna Student
												</label>
											</div>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-10">
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="tshirt_charge" name='tshirt_charge'>
												<label class="form-check-label" for="tshirt_charge">
													T-Shirt (Rs 300)
												</label>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-10">
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="accommodation_charge" name='accommodation_charge'>
												<label class="form-check-label" for="accommodation_charge">
													Accommodation Charge (Rs 500)
												</label>
											</div>
										</div>
									</div>  
									<input type="hidden" name="validate_user" id="validate_user" value="validate_user">
									<input type="submit" class="btnRegister"  value="Validate User"/>
								</div>
							</div>
						</form>
						</div>
					</div>
				</div>
			</div>
		</div>



	<?php } ?>

</div>

</body>
</html>