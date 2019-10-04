<?php include("functions/init.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Campus Ambassador Registration</title>
	<!-- Main css -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="./css/ca_reg.css">
	<script src="./js/ca_reg.js"></script>
</head>

<body>

	<div class="wrapper">
		<div class="container">
			<h1>Register for Campus Ambassador</h1>
			<?php display_message() ?>
			<div style="position: relative; z-index: 9">
				<?php validate_ca_registration() ?>
			</div>
			<form class="form" method="POST" id="signup-form">
				<input type="text" class="form-input" name="first_name" id="first_name" placeholder="First Name" />
				<input type="text" class="form-input" name="last_name" id="last_name" placeholder="Last Name" />
				<input type="text" class="form-input" name="phone" id="phone" placeholder="Phone" />
				<input type="text" class="form-input" name="college" id="college" placeholder="School/College" />
				<input type="email" class="form-input" name="email" id="email" placeholder="Email" />
				<input type="password" class="form-input" name="password" id="password" placeholder="Password" />
				<input type="password" class="form-input" name="confirm_password" id="confirm_password" placeholder="Confirm Password" />

				<input type="radio" name="gender" value="m" checked placeolder="Male">
				<span style="color:white"> Male </span>
				<input type="radio" name="gender" value="f">
				<span style="color:white">Female </span><br>
				<button type="submit" id="login-button">Register</button>
			</form>
		</div>

		<ul class="bg-bubbles">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>

</html>