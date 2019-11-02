<?php include("functions/init.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php
if (logged_in()) {
    redirect("profile.php");
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Celesta2k19</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="./css/reg_styles.css">
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
    <canvas id="canvas"></canvas>
    <section class="login-body">
        <div class="row">
            <div class="input-cart col s12 m10 push-m1 z-depth-2">
                <div class="col s12 m12 login">
                    <h4 class="center">Log in</h4>
                    <br>
                    <?php display_message() ?>
                    <?php login_signup() ?>
                    <br>
                    <form id="login_form" name="login_form" method="post" autocomplete="off">
                        <div class="row">
                            <div class="input-field">
                                <input type="text" id="celestaid" name="celestaid" class="validate" required="required" autocomplete="off" placeholder="Celesta ID">
                                <label for="user">
                                    <i class="material-icons">person</i> </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field">
                                <input type="password" id="password" name="password" class="validate" required="required" placeholder="Password">
                                <label for="pass">
                                    <i class="material-icons">lock</i>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <button type="submit" name="login" id="login" class="btn waves-effect waves-light blue left">Log in</button>
                            </div>
                            <div class=" col s6">
                                <label><a href="./resend_activation.php">
                                    <span class="btn waves-effect waves-light left">Resend Activation Link</span></a>
                                </label>
                            </div>
                            <br>
                        </div>
                    </form>
                    <h5 class="center" style="margin-top:50px"><a href="./forgotPassword.php">Forgot Password?</a></h5>
                    <h5 class="center" style="margin-top:50px">Dont have an account ? <a href="./register.php">Sign Up</a></h5>
                </div>
            </div>
        </div>
        <div class="fixed-action-btn toolbar">
            <a class="btn-floating btn-large amber black-text">
                Menu
            </a>
            <ul>
                <li><a class="indigo center" href="../../">Home</a></li>
                <li><a class="blue center" href="../../events.php">Events</a></li>
                <li><a class="red center" href="../../sponsors.php">Sponsors</a></li>
            </ul>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
    <script src="./js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gl-matrix/2.1.0/gl-matrix.js"></script>
    <script src="./canvas/canvas.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>

</html>