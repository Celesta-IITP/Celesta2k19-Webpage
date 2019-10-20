<?php
include("functions/init.php");
if (!logged_in()) {
    redirect("login.php");
}
$celestaid;
$imgsrc;
if (isset($_SESSION['celestaid'])) {
    $celestaid = $_SESSION['celestaid'];
    $imgsrc = $_SESSION['qrcode'];
    $access_token = $_SESSION['access_token'];
}

$cadata = ca_leaderboard();
$data = array();
foreach ($cadata as $cd) {
    $e = array();
    $e['name'] = $cd['first_name'] . " " . $cd['last_name'];
    $e['celestaid'] = $cd['celestaid'];
    $e['excitons'] = $cd['excitons'];
    $e['gravitons'] = $cd['gravitons'];
    $e['points'] = $cd['excitons'] * 1.5 + $cd['gravitons'];
    array_push($data, $e);
}
$points = array_column($data, 'points');
array_multisort($points, SORT_DESC, $data);
$profile = user_details($celestaid);
$user_registered_events = json_decode($profile['events_registered']);

function getEventAmount($ev_id)
{
    $sql = "SELECT id, ev_amount from events where ev_id='$ev_id'";
    $result = query($sql);
    if (row_count($result) == 1) {
        $row = fetch_array($result);
        return $row['ev_amount'];
    } else {
        return -1;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Celesta'19</title>
    <link rel="stylesheet" href="./profile/css/styles.css">
    <link rel="stylesheet" href="./profile/css/menu-styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="page">
        <span class="menu_toggle">
            <i class="menu_open fa fa-bars fa-lg"></i>
            <i class="menu_close fa fa-times fa-lg"></i>
        </span>
        <ul class="menu_items">
            <li><a href="./../../index.php"><i class="icon fa fa-home fa-2x"></i> Home</a></li>
            <li><a href="./../../events.php"><i class="icon fa fa-heart fa-2x"></i> Events</a></li>
            <li><a href="./../../team.php"><i class="icon fa fa-users fa-2x"></i> Team</a></li>
        </ul>
        <main class="content">
            <div class="content_inner">
                <section class="speakers-section" style="background-image: url(https://i.ibb.co/92HJxz2/team-bg.jpg);">
                    <?php if ($profile['isCA']) { ?>
                        <button class="btn btn-primary float-right" style="margin-right: 20px;"><a href="./ca_logout.php" style="color: #fff">Logout</a></button>
                    <?php } else { ?>
                        <button class="btn btn-primary float-right" style="margin-right: 20px;"><a href="./logout.php" style="color: #fff">Logout</a></button>
                    <?php } ?>
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
                                                <h5 class="text-center" style="color: #fff"><?php echo $profile['first_name'] . " " . $profile['last_name'] ?></h5>
                                            </div>
                                        </figure>
                                    </div>
                                    <div class="caption-box text-center">
                                        <h4 class="name"><?php echo $profile['first_name'] . " " . $profile['last_name'] ?></h4>
                                        <h4 class="name">CelestaID: <?php echo $celestaid ?></h4>
                                        <span class="designation"><a href="mailto:<?php echo $profile['email'] ?>"><?php echo $profile['email'] ?></a></span>
                                        <hr>
                                        <?php if ($profile['isCA']) { ?>
                                            <button class="btn btn-success">Excitons: <?php echo $profile['ca']['excitons'] ?></button> <button class="btn btn-success">Gravitons: <?php echo $profile['ca']['gravitons'] ?></button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div style="margin: 0 10px">
                        <div class="container tableContainer">
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-10" style="overflow-x: auto; padding: 0">
                                    <h2 class="text-center" style="color: #fff">Events Registered</h2>
                                    <table class="table table-hover" style="color: #fff; background: rgba(0,0,0,.5)">
                                        <thead>
                                            <tr>
                                                <th scope="col">S.No.</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Event ID</th>
                                                <th scope="col">Event Amount</th>
                                                <th scope="col">Is Team Event</th>
                                                <th scope="col">Amount Paid</th>
                                                <th>Payment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            foreach ($user_registered_events as $ev) { ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i++; ?></th>
                                                    <td><?php echo $ev->ev_name ?></td>
                                                    <td><?php echo $ev->ev_id ?></td>
                                                    <td><?php $event_amount = getEventAmount($ev->ev_id);
                                                            echo $event_amount;
                                                            ?></td>
                                                    <td>
                                                        <?php if (isset($ev->team_name)) { ?>
                                                            Yes
                                                        <?php } else { ?>
                                                            No
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php echo $ev->amount ?></td>
                                                    <td>
                                                        <!-- http://techprolabz.com/pay/dataFrom.php -->
                                                        <?php if ($event_amount == 0) { ?>
                                                            <p class="text-primary">Free event<p>
                                                                <?php } else if ($event_amount - ($ev->amount) > 0) { ?>
                                                                    <form action="http://techprolabz.com/pay/dataFrom.php" method="POST">
                                                                        <input type="text" hidden value="<?php echo $ev->ev_id ?>" name="ev_id">
                                                                        <input type="text" hidden value="<?php echo $celestaid ?>" name="celestaid">
                                                                        <input type="text" hidden value="<?php echo $access_token ?>" name="access_token">
                                                                        <input type="text" hidden value="<?php echo $event_amount ?>" name="ev_amount">
                                                                        <input type="text" hidden value="<?php echo $profile['email'] ?>" name="email">
                                                                        <input type="text" hidden value="<?php echo $profile['phone'] ?>" name="phone">
                                                                        <input type="text" hidden value="<?php echo $profile['first_name'] . ' ' . $profile['last_name'] ?>" name="name">
                                                                        <button type="submit" class="btn btn-success">Pay</button>
                                                                    </form>
                                                                <?php } else { ?>
                                                                    <p class="text-success">Paid<p>
                                                                        <?php } ?>
                                                    </td>

                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <?php if ($profile['isCA']) { ?>
                            <div class="container tableContainer" style="margin-top: 50px">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-10" style="overflow-x: auto; padding: 0">
                                        <h2 class="text-center" style="color: #fff">CA Leaderboard</h2>
                                        <p class="text-center" style="color: #eee; font-size: 12px">Points = 1.5*Excitons + Gravitons</p>
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
                                                <?php $i = 1;
                                                    foreach ($data as $d) {
                                                        if ($i <= 21) { ?>
                                                        <tr>
                                                            <th scope="row"><?php echo $i++; ?></th>
                                                            <td><?php echo $d['name'] ?></td>
                                                            <td><?php echo $d['celestaid'] ?></td>
                                                            <td><?php echo $d['excitons'] * 1.5 + $d['gravitons'] ?></td>
                                                            <td><?php echo $d['excitons'] ?></td>
                                                            <td><?php echo $d['gravitons'] ?></td>
                                                        </tr>
                                                <?php }
                                                    } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                </section>
            </div>
        </main>
    </div>

    <!-- toasts -->
    <?php if(isset($_GET['status']) && isset($_GET['msg'])) { ?>
        <div class="toastContainer" style="position: absolute; top: 0; right: 0; margin: 20px; z-index: 99999;">
            <?php if($_GET['status']==200) { ?>
                <div class="toast fade show" style="z-index: 999">
                    <div class="toast-header bg-success">
                        <strong class="mr-auto"><i class="fa fa-globe"></i> Success</strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                    </div>
                    <div class="toast-body"><?php echo $_GET['msg'];?></div>
                </div>
            <?php } elseif($_GET['status']==400) { ?>
                <div class="toast fade show" style="z-index: 999">
                    <div class="toast-header bg-danger">
                        <strong class="mr-auto"><i class="fa fa-globe"></i> Error</strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                    </div>
                    <div class="toast-body"><?php echo $_GET['msg'];?></div>
                </div>
            <?php } elseif($_GET['status']==204) { ?>
                <div class="toast fade show" style="z-index: 999">
                    <div class="toast-header bg-danger">
                        <strong class="mr-auto"><i class="fa fa-globe"></i> Not Found</strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                    </div>
                    <div class="toast-body"><?php echo $_GET['msg'];?></div>
                </div>
            <?php } elseif($_GET['status']==401) { ?>
                <div class="toast fade show" style="z-index: 999">
                    <div class="toast-header bg-danger">
                        <strong class="mr-auto"><i class="fa fa-globe"></i> Unauthorized</strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                    </div>
                    <div class="toast-body"><?php echo $_GET['msg'];?></div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="./profile/js/menu-main.js"></script>

    <!-- js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>