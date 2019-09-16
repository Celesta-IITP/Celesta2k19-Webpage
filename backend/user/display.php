<?php include("functions/init.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php     
    if(!logged_in()){
        redirect("reg.php");
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
</head>

<body>
    <canvas id="canvas"></canvas>
    <section class="login-body">
        <div class="row">
            <div class="input-cart col s12 m10 push-m1 z-depth-2">
            <?php display_message() ?>
            </div>
        </div>
        <div class="fixed-action-btn toolbar">
            <a class="btn-floating btn-large amber black-text">
                Menu
            </a>
            <ul>
                <li><a class="indigo center" href="../../">Home</a></li>
                <li><a class="blue center" href="../../events.html">Events</a></li>
                <li><a class="red center" href="../../sponsors.html">Sponsors</a></li>
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