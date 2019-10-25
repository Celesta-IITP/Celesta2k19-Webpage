<?php 
    // include("./functions/init.php");
    // include('./functions/book_accomodation.php');

    // if (!logged_in()) {
    //     redirect("login.php");
    // }
    $celestaid=null;
    $access_token=null;
    if (isset($_SESSION['celestaid'])) {
        $celestaid = $_SESSION['celestaid'];
        $access_token = $_SESSION['access_token'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Celesta2k19</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/background.jpg');width:100%;height:100vh">

			<div class="wrap-login100 p-t-30 p-b-50">
                <span style="color:red; text-align:center">
          
                </span>
				<span class="login100-form-title p-b-41">
                    Accommodation Portal
				</span>
				<form class="login100-form validate-form p-b-33 p-t-5" method="POST">
					<div class="wrap-input100 validate-input" data-validate="Select choice">
                        <select class="input100" type="select" name="pass">
                            <!-- <option value="day1">Day 1</option>
                            <option value="day2">Day 2</option>
                            <option value="day3">Day 3</option> -->
                            <option value="all_day">All 3 Days</option>
                            <!-- <option value="day1_day2">Day 1 & 2</option>
                            <option value="day2_day3">Day 2 & 3</option> -->
                        </select>
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>    
                    </div>
                    
                    <input type="hidden" value="<?php echo $celestaid?>" name="celestaid" id="celestaid">
                    <input type="hidden" value="<?php echo $access_token?>" name="access_token" id="access_token">

					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn" type="submit">
							Book Accommodation
                        </button>
                    </div>
                    <div class="m-t-10 text-center">
                        <a href="./profile.php">
                            <button class="btn btn-primary">
                                Cancel
                            </button>
                        </a>
					</div>

				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->

</body>
</html>