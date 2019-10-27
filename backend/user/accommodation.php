<?php 
    include("./functions/init.php");

    $loggedIn = logged_in();
    $celestaid=""; $access_token="";
    if($loggedIn){
      $celestaid = $_SESSION['celestaid'];
      $access_token=$_SESSION['access_token'];
    } else {
		redirect('./login.php');
	}
?>

<?php
//   $service_url = 'http://localhost/celesta2k19-webpage/user/functions/book_accomodation.php';
  $service_url = 'https://celesta.org.in/backend/user/functions/book_accomodation.php';
  $curl = curl_init($service_url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $curl_response = curl_exec($curl);
  if ($curl_response === false) {
    $info = curl_getinfo($curl);
    curl_close($curl);
    die('error occured during curl exec. Additioanl info: ' . var_export($info));
  }
  curl_close($curl);
  $data = json_decode($curl_response, true);
  echo $data['status'];
  
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Celesta2k19</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/background.jpg');width:100%;height:100vh">

			<div class="wrap-login100 p-t-30 p-b-50">
                <span style="" id="responses">
					<!--  -->
                </span>
				<span class="login100-form-title p-b-41">
                    Accommodation Portal
				</span>
				<form class="login100-form validate-form p-b-33 p-t-5" id="accoForm">
					<div class="wrap-input100 validate-input" data-validate="Select choice">
                        <select class="input100" type="select" name="daySelect" id="daySelect">
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
							Book Accommodation &nbsp;&nbsp;<span class="spinner-border spinner-border-sm spinner" style="display: none"></span>
                        </button>
                    </div>
                    <div class="m-t-10 text-center">
                        <a href="./profile.php" style="color:hover: red">
                            Cancel
                        </a>
					</div>

				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<script src="vendor/countdowntime/countdowntime.js"></script>

	<!-- acco js -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<script>
		var accoForm = document.querySelector('#accoForm');
		accoForm.addEventListener('submit', async (e) => {
		e.preventDefault();
		let spinner = document.querySelector(".spinner");
      	spinner.style.display = "inline-block";
		var celestaid=document.querySelector('#celestaid').value;
		var access_token=document.querySelector('#access_token').value;
		var daySelect=document.querySelector('#daySelect').value;

		console.log(celestaid, access_token, daySelect);

		let formData = new FormData();
		formData.append("celestaid", celestaid);
		formData.append("access_token", access_token);

		// formData.append(daySelect, daySelect);

		if(daySelect==="day1"){
			formData.append("day1", daySelect);
		} else if(daySelect==="day2"){
			formData.append("day2", daySelect);
		} else if(daySelect==="day3"){
			formData.append("day3", daySelect);
		} else if(daySelect==="all_day"){
			formData.append("all_day", daySelect);
		} else if(daySelect==="day1_day2"){
			formData.append("day1_day2", daySelect);
		} else if(daySelect==="day2_day3"){
			formData.append("day2_day3", daySelect);
		}
		
		// let url="https://celesta.org.in/backend/user/functions/book_accomodation.php";
		let url="http://localhost/celesta2k19-webpage/backend/user/functions/book_accomodation.php";
		let res = await fetch(
			url,
			{
			body: formData,
			method: "post"
			}
		);
		res = await res.json();
		spinner.style.display = "none";
		let htmlData='';
		var responses=document.querySelector('#responses');
		if(res.status === 404){
			res.message.forEach((msg) => {
				htmlData+=`
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					 ${msg}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				`;
			})
		}
		else if(res.status === 401){
			res.message.forEach((msg) => {
				htmlData+=`
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					 ${msg}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				`;
			})
		}
		else if(res.status === 208){
			res.message.forEach((msg) => {
				htmlData+=`
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					 ${msg}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				`;
			})
		}
		else if(res.status === 202){
			res.message.forEach((msg) => {
				htmlData+=`
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					 ${msg}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				`;
			})
		}
		responses.innerHTML=htmlData;
		});
	</script>

</body>
</html>
