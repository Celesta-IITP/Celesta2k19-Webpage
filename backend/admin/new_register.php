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
</head>
<body>


<!------ Include the above in your HEAD tag ---------->
<div class="container">
	<?php include('includes/nav.php') ?>
	<?php display_message()?>
	<?php new_register() ?>
</div>	

<div class="container register">
    <div class="row">
        <div class="col-md-3 register-left">
            <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
            <h3>Welcome</h3>
            <h3>To Celesta2k19 !!</h3>
            <p>The Techno Cultural Fest of IIT Patna</p>
            <input type="submit" onclick="location.href='register.php';" name="" value="Validate User"/><br/>
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
                    <h3 class="register-heading">Register Directly on Registration Desk</h3>
                    <form method="post" role="form">
                    <div class="row register-form" >
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name *" value="" required />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name *" value="" required />
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password *" value="qwerty123" required/>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password *" value="qwerty123" required />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="referral_id" name="referral_id" placeholder="Referral ID" />
                            </div>
                             <div class="form-group">
                                <div class="maxl">
                                    <label class="radio inline"> 
                                        <input type="radio" name="gender" value="m" checked>
                                        <span> Male </span> 
                                    </label>
                                    <label class="radio inline"> 
                                        <input type="radio" name="gender" value="f">
                                        <span>Female </span> 
                                    </label>
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Your Email *" value="" required/>
                            </div>
                            <div class="form-group">
                                <input type="text" minlength="10" maxlength="10" name="phone" id="phone" class="form-control" placeholder="Your Phone *" value="" required/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="college" name="college" placeholder="Enter Your School/College *" value="" required/>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="registration_charge" name='registration_charge' checked>
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

                            <input type="submit" class="btnRegister"  value="Register"/>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>