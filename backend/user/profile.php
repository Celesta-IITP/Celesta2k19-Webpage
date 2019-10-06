<?php 
    include("functions/init.php"); 
    if(!logged_in()){
        redirect("reg.php");
    }
    $celestaid; $imgsrc;
    if(isset($_SESSION['celestaid'])){
        $celestaid = $_SESSION['celestaid'];
        $imgsrc = $_SESSION['qrcode'];
        $access_token=$_SESSION['access_token'];
    }
    $data = ca_leaderboard();
    $profile = user_details($celestaid);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Celesta'19</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./profile/css/styles.css">
    <link rel="stylesheet" href="./profile/css/menu-styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
</head>

<body>
    <div class="page">
        <span class="menu_toggle">
            <i class="menu_open fa fa-bars fa-lg"></i>
            <i class="menu_close fa fa-times fa-lg"></i>
        </span>
        <ul class="menu_items">
            <li><a href="./../../index.html"><i class="icon fa fa-home fa-2x"></i> Home</a></li>
            <li><a href="./../../events.html"><i class="icon fa fa-heart fa-2x"></i> Events</a></li>
            <li><a href="./../../team.html"><i class="icon fa fa-users fa-2x"></i> Team</a></li>
        </ul>
        <main class="content">
            <div class="content_inner">
                <section class="speakers-section" style="background-image: url(https://i.ibb.co/92HJxz2/team-bg.jpg);">
                    <button class="btn btn-primary float-right" style="margin-right: 20px;"><a href="./logout.php" style="color: #fff">Logout</a></button>

                    <div class="parallax-scene parallax-scene-2 anim-icons">
                        <span data-depth="0.40" class="parallax-layer icon icon-circle-5"></span>
                        <span data-depth="0.99" class="parallax-layer icon icon-circle-5"></span>
                    </div>

                    <div class="container">
                        <div class="sec-title light text-center">
                            <span class="title">Your Profile</span>
                        </div>

                        <div class="row d-flex justify-content-center">

                            <div class="speaker-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="800ms">
                                <div class="inner-box">
                                    <div class="image-box">
                                        <figure class="image">
                                            <img src="<?php echo $imgsrc ?>">
                                            <div class="social-links">
                                                <h5 class="text-center" style="color: #fff"><?php echo $profile['first_name'] ." ". $profile['last_name'] ?></h5>
                                            </div>
                                        </figure>
                                    </div>
                                    <div class="caption-box text-center">
                                        <h4 class="name"><?php echo $profile['first_name'] ." ". $profile['last_name'] ?></h4>
                                        <h4 class="name">CelestaID: <?php echo $celestaid ?></h4>
                                        <span class="designation"><a href="mailto:<?php echo $profile['email'] ?>"><?php echo $profile['email'] ?></a></span>
                                        <hr>
                                        <?php if($profile['isCA']) { ?>
                                            <button class="btn btn-success">Excitons: <?php echo $profile['ca']['excitons'] ?></button> <button class="btn btn-success">Gravitons: <?php echo $profile['ca']['gravitons'] ?></button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php if($profile['isCA']) { ?>
                        <div class="container">
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-10">
                                    <h2 class="text-center" style="color: #fff">CA Leaderboard</h2>
                                    <table class="table table-hover" style="color: #fff; background: rgba(0,0,0,.5)">
                                        <thead>
                                            <tr>
                                                <th scope="col">Rank</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">CelestaID</th>
                                                <th scope="col">Points</th>
                                                <th scope="col">Excitons</th>
                                                <th scope="col">Gravitons</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach($data as $d) { ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i++; ?></th>
                                                    <td><?php echo $d['first_name'] ." ". $d['last_name'] ?></td>
                                                    <td><?php echo $d['celestaid'] ?></td>
                                                    <td><?php echo $d['excitons']*1.5 + $d['gravitons'] ?></td>
                                                    <td><?php echo $d['excitons'] ?></td>
                                                    <td><?php echo $d['gravitons'] ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </section>
            </div>
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="./profile/js/menu-main.js"></script>

</body>

</html>