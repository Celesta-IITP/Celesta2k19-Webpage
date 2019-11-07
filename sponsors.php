<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Celesta'19</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="keywords" />
  <meta content="" name="description" />
  <!-- Projects Bootstrap CSS File -->
  <link href="./events/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="./events/lib/lightbox/css/lightbox.min.css" rel="stylesheet" />
  <link href="./events/css/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="./events/css/bg.css" />

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-151382188-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-151382188-1');
  </script>

  <link rel="stylesheet" href="./events/css/menu-styles.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
      <li><a href="../index.php"><i class="icon fa fa-home fa-2x"></i> Home</a></li>
      <li><a href="../events.php"><i class="icon fa fa-heart fa-2x"></i> Events</a></li>
      <li><a href="../team.php"><i class="icon fa fa-users fa-2x"></i> Team</a></li>
    </ul>
    <main class="content">
      <div class="content_inner">

        <div class="container" style="margin-top: 50px; margin-bottom: 50px;">
          <header class="section-header">
            <h3 class="section-title" style="color: #fff">Our Sponsors</h3>
          </header>
          <br><br>

          <div class="row">
            <div class="col-lg-12">
              <h1 class="text-center" style="color: #fff">Associate <span style="color: #f00">Sponsor</span></h1>
              <div class="container d-flex justify-content-center align-items-center parent">
                <img src="assets/images/sponsors/beltron.png" width="20%" style="margin: 20px" data-tilt id="1111" onClick="clickk('http://www.bsedc.bihar.gov.in/')">
                <img src="assets/images/sponsors/ruban.png" width="20%" style="margin: 20px" data-tilt id="2222" onClick="clickk('http://www.rubanpatliputrahospital.com/')">
              </div>
            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="col-lg-12">
              <h1 class="text-center" style="color: #fff">Power <span style="color: #f00">Sponsor</span></h1>
              <div class="container d-flex justify-content-center align-items-center parent">
                <img src="assets/images/sponsors/sbi.png" width="20%" style="margin: 20px" data-tilt id="1111" onClick="clickk('https://www.onlinesbi.com/')">
                <img src="assets/images/sponsors/axis.png" width="20%" style="margin: 20px" data-tilt id="2222" onClick="clickk('https://www.axisbank.com/')">
                <img src="assets/images/sponsors/ntpc.png" width="20%" style="margin: 20px" data-tilt id="2222" onClick="clickk('https://www.ntpc.co.in')">
              </div>
            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="col-lg-12">
              <h1 class="text-center" style="color: #fff">Event <span style="color: #f00">Sponsor</span></h1>
              <div class="container d-flex justify-content-center align-items-center parent">
                <img src="assets/images/sponsors/icetl.png" width="20%" style="margin: 20px" data-tilt id="1111" onClick="clickk('http://icetl.com/')">
                <img src="assets/images/sponsors/engconvo.png" width="20%" style="margin: 20px" data-tilt id="2222" onClick="clickk('https://www.engconvo.com/')">
              </div>
            </div>
          </div>
          <br><br>

        </div>

      </div>
    </main>
  </div>

  <!-- tilt js -->
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="./_compiled/tilt.jquery.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="./events/js/menu-main.js"></script>
  <!-- #gallery -->

  <script>
    function clickk(data){
      window.location.assign(data);
    }
  </script>

</body>

</html>