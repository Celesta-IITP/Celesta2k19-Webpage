<?php include("functions/init.php"); ?>
<!DOCTYPE html>
<html lang="en">
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
                <div class="col s12 m12 login">
                    <h4 class="center">Registration Fee Payment Portal</h4>
                    <br>
                    <div>
                        <div style="display: flex; justify-content: center; laign-items: center">
                            <img src="../../assets/images/pay/regPayment.jpeg" width="300px" height="300px" alt="">
                        </div>
                        <br>
                        <div style="display: flex; justify-content: center; laign-items: center">
                            <img src="../../assets/images/pay/pay.jpeg" width="300px" height="100px" alt="">
                        </div>
                        <div>
                            <h5>Note:</h5>
                            <ol>
                                <li>Scan the QR Code above to pay ₹150 (Registration Fee).</li>
                                <li>Keep the transaction ID and the screenshot of payment with you.</li>
                                <li>Fill the Google-form for transaction verification. <a href="https://forms.gle/hQXhDu3VG2iyjQ576" target="_blank" style="background: rgb(255,193,7)"><button style="background: rgb(255,193,7); color: #fff">Google Form</button></a></li>
                            </ol>
                        </div>
                    </div>
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
