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
                    Reset Password
				</span>
				<form class="login100-form validate-form p-b-33 p-t-5" id="resetPwdForm">
                    <div class="wrap-input100 validate-input" data-validate="Enter new password">
						<input class="input100" type="password" name="password" id="password" placeholder="Password" required>
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Confirm new password">
						<input class="input100" type="password" name="password1" id="password1" placeholder="Confirm password" required>
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>
					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn" type="submit">
							Submit &nbsp;&nbsp;<span class="spinner-border spinner-border-sm spinner" style="display: none"></span>
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
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, '\\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

		var resetPwdForm = document.querySelector('#resetPwdForm');
		resetPwdForm.addEventListener('submit', async (e) => {
		e.preventDefault();
		let spinner = document.querySelector(".spinner");
      	spinner.style.display = "inline-block";
		var password=document.querySelector('#password').value;
        var password1=document.querySelector('#password1').value;
        var email = getParameterByName('email');
        var validation_code = getParameterByName('code');

		let formData = new FormData();
		formData.append("password", password);
        formData.append("password1", password1);
        formData.append("email", email);
        formData.append("validation_code", validation_code);
        
		// let url="https://celesta.org.in/backend/user/functions/resetPassword.php";
		let url="http://localhost/celesta2k19-webpage/backend/user/functions/resetPassword.php";
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
		if(res.status === 300){
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
