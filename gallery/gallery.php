<?php
    $strJsonFileContents = file_get_contents("gallery.json"); 
    $array = json_decode($strJsonFileContents, true);
    $array=$array['img'];
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

  <style>
    .sec_head h3{
      color:white;
    }
  </style>
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

  <a href="https://celesta.org.in/njath" class="njath">NJATH is live now</a>
   <style>
     .njath{
       position: absolute;
       bottom: 10px;
       right: 10px;
       z-index: 9999;
       background: #32489D;
       color: #fff;
       padding: 10px;
       border: 5px solid #fff;
       border-radius: 10px;
       box-shadow: 0px 5px 10px rgba(0,0,0,.5);
     }
     .njath:hover{
       color: #fff;
     }
   </style>

  <!--==========================
      Gallery Section
    ============================-->
  <div class="page">
    <span class="menu_toggle">
      <i class="menu_open fa fa-bars fa-lg"></i>
      <i class="menu_close fa fa-times fa-lg"></i>
    </span>
    <ul class="menu_items">
      <li><a href="../index.php"><i class="icon fa fa-home fa-2x"></i> Home</a></li>
      <li><a href="../events.php"><i class="icon fa fa-heart fa-2x"></i> Events</a></li>
      <li><a href="../team.php"><i class="icon fa fa-users fa-2x"></i> Team</a></li>
    </ul>
    <main class="content">
      <div class="content_inner">
        <section id="gallery" class="section-bg">
          <div class="container">
            <header class="section-header sec_head">
              <h3 class="section-title">Celesta gallery</h3>
            </header>

            <div class="row">
              <div class="col-lg-12">
                <!-- <ul id="gallery-flters">
                  <li data-filter="*" class="filter-active">All</li>
                  <li data-filter=".filter-clubs">Clubs</li>
                  <li data-filter=".filter-events">Events</li>
                </ul> -->
              </div>
            </div>
            <br><br>

            <div class="row gallery-container">

                <?php foreach($array as $data){ ?>
                <div class="col-lg-4 col-md-6 gallery-item filter-clubs">
                    <div class="gallery-wrap">
                    <figure>
                        <img src="<?php echo $data['reduced']?>" class="img-fluid" alt="" />
                        <a href="<?php echo $data['normal']?>" data-lightbox="gallery" data-title="" class="link-preview" title="Preview"><i
                            class="ion ion-eye"></i></a>
                    </figure>
                    <!-- <div class="gallery-info">
                        <h4>Club 1</h4>
                    </div> -->
                    </div>
                </div>
                <?php } ?>

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