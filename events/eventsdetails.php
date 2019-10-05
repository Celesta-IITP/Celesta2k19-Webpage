<?php
  $id=$_GET['id'];

  $service_url = 'http://localhost/celesta2k19-webpage/backend/admin/functions/events_api.php';
  // $service_url = 'https://celesta.org.in/backend/admin/functions/events_api.php';
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

  $event;
  foreach($data as $d){
    if($d['ev_id']==$id){
      $event=$d;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Celesta'19</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="keywords" />
  <meta content="" name="description" />

  <!-- Projects Bootstrap CSS File -->
  <link href="./lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="./lib/lightbox/css/lightbox.min.css" rel="stylesheet" />
  <link href="./css/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="./css/bg.css" />

  <link rel="stylesheet" href="./css/menu-styles.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
</head>

<body>

  <div class="waveWrapper waveAnimation">
    <div class="waveWrapperInner bgTop">
      <div class="wave waveTop" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-top.png')"></div>
    </div>
    <div class="waveWrapperInner bgMiddle">
      <div class="wave waveMiddle" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-mid.png')"></div>
    </div>
    <div class="waveWrapperInner bgBottom">
      <div class="wave waveBottom" style="background-image: url('http://front-end-noobs.com/jecko/img/wave-bot.png')"></div>
    </div>
  </div>


  <!--==========================
      Gallery Section
    ============================-->
  <div class="page">
    <span class="menu_toggle">
      <i class="menu_open fa fa-bars fa-lg"></i>
      <i class="menu_close fa fa-times fa-lg"></i>
    </span>
    <ul class="menu_items">
      <li><a href="../index.html"><i class="icon fa fa-home fa-2x"></i> Home</a></li>
      <li><a href="../events.html"><i class="icon fa fa-heart fa-2x"></i> Events</a></li>
      <li><a href="../team.html"><i class="icon fa fa-users fa-2x"></i> Team</a></li>
    </ul>
    <main class="content">
      <div class="content_inner">
        <section id="gallery" class="section-bg">

          <div class="container">
            <header class="section-header">
              <h3 class="section-title"><?php echo $event["ev_category"] ?>: <?php echo $event["ev_name"] ?></h3>
            </header>
            <br>
            <div class="row">
              <div class="col-lg-6 col-md-6">
                <img src="https://celesta.org.in/backend/admin/events/posters/ATM5042_Robowars.jpg" width="100%">
              </div>
              <div class="col-lg-6 col-md-6">
                <h3 style="color: #219999">Name: <span style="color: #fff"><?php echo $event['ev_name']?></span></h3>
                <h5 style="color: #219999">Description: <span style="color: #fff"><?php echo $event['ev_description']?></span></h5>
                <h5 style="color: #219999">Organiser: <span style="color: #fff"><?php echo $event['ev_organiser']?></span></h5>
                <h5 style="color: #219999">Club: <span style="color: #fff"><?php echo $event['ev_club']?></span></h5>
                <h5 style="color: #219999">Organizer's Phone: <span style="color: #fff"><?php echo $event['ev_org_phone']?></span></h5>
                <h5 style="color: #219999">Date: <span style="color: #fff"><?php echo $event['ev_date']?></span></h5>
                <h5 style="color: #219999">Start Time: <span style="color: #fff"><?php echo $event['ev_start_time']?></span></h5>
                <h5 style="color: #219999">End Time: <span style="color: #fff"><?php echo $event['ev_end_time']?></span></h5>
                <button class="btn btn-success"><a style="color: #fff" href="<?php echo $event['ev_rule_book_url']?>">Rulebook</a></button>
                <button class="btn btn-success"><a style="color: #fff" href="<?php echo $event['ev_rule_book_url']?>">Register</a></button>
              </div>
            </div>
            </div>

          </div>
        </section>
      </div>
    </main>
</div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="./js/menu-main.js"></script>
  <!-- #gallery -->


  <!--gallery JavaScript Libraries -->
  <script src="./lib/jquery/jquery.min.js"></script>
  <script src="./lib/jquery/jquery-migrate.min.js"></script>
  <script src="./lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="./lib/superfish/hoverIntent.js"></script>
  <script src="./lib/superfish/superfish.min.js"></script>
  <script src="./lib/wow/wow.min.js"></script>
  <script src="./lib/waypoints/waypoints.min.js"></script>
  <script src="./lib/counterup/counterup.min.js"></script>
  <script src="./lib/isotope/isotope.pkgd.min.js"></script>
  <script src="./lib/lightbox/js/lightbox.min.js"></script>
  <script src="./lib/touchSwipe/jquery.touchSwipe.min.js"></script>
  <script src="./js/main.js"></script>
</body>

</html>
