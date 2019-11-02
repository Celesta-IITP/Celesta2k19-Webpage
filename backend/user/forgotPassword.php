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
	    <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-151382188-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-151382188-1');
  </script>
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/background.jpg');width:100%;height:100vh">

			<div class="wrap-login100 p-t-30 p-b-50">
                <span style="" id="responses">
					<!--  -->
                </span>
				<span class="login100-form-title p-b-41">
                    Forgot Password
				</span>
				<form class="login100-form validate-form p-b-33 p-t-5" id="forgotPwdForm">
                    <div class="wrap-input100 validate-input" data-validate = "Enter email id">
						<input class="input100" type="text" name="email" id="email" placeholder="Email ID" required>
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>
					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn" type="submit">
							Continue &nbsp;&nbsp;<span class="spinner-border spinner-border-sm spinner" style="display: none"></span>
                        </button>
                    </div>
                    <div class="m-t-10 text-center">
                        <a href="./login.php" style="color:hover: red">
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
		var forgotPwdForm = document.querySelector('#forgotPwdForm');
		forgotPwdForm.addEventListener('submit', async (e) => {
		e.preventDefault();
		let spinner = document.querySelector(".spinner");
      	spinner.style.display = "inline-block";
		var email=document.querySelector('#email').value;

		let formData = new FormData();
		formData.append("email", email);

		let url="https://celesta.org.in/backend/user/functions/forgotPassword.php";
		// let url="http://localhost/celesta2k19-webpage/backend/user/functions/forgotPassword.php";
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
		else if(res.status === 500){
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
		else if(res.status === 200){
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
