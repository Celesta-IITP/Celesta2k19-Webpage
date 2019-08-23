<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Campus Ambassador Registration</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/ca_register_style.css">
</head>
<body>

    <div class="main">

        <div class="container">
            <div class="signup-content">
                <form method="POST" id="signup-form" class="signup-form">
                    <h2>Register for Campus Ambassador </h2>
                    <p class="desc">Enroll more candidates to <span>“Top the List”</span></p>
                    <div class="form-group">
                        <input type="text" class="form-input" name="first_name" id="first_name" placeholder="First Name"/>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-input" name="last_name" id="last_name" placeholder="Last Name"/>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-input" name="phone" id="phone" placeholder="Phone"/>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-input" name="college" id="college" placeholder="School/College"/>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-input" name="email" id="email" placeholder="Email"/>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-input" name="password" id="password" placeholder="Password"/>
                        <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-input" name="confirm_password" id="confirm_password" placeholder="Confirm Password"/>
                        <span toggle="#confirm_password" class="zmdi zmdi-eye field-icon toggle-confirm-password"></span>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                        <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" id="submit" class="form-submit submit" value="Sign up"/>
                        <a href="#" class="submit-link submit">Sign in</a>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/ca_register.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>