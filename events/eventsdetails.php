<?php
$id = $_GET['id'];
// $service_url = 'http://localhost/celesta2k19-webpage/backend/admin/functions/events_api.php';
$service_url = 'https://celesta.org.in/backend/admin/functions/events_api.php';
$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_response = curl_exec($curl);
if ($curl_response === false) {
  $info = curl_getinfo($curl);
  curl_close($curl);
  die('Error occured during curl exec. Additioanl info: ' . var_export($info));
}
curl_close($curl);
$data = json_decode($curl_response, true);
$event;
foreach ($data as $d) {
  if ($d['ev_id'] == $id) {
    $event = $d;
  }
}
?>

<?php
include("../backend/user/functions/init.php");
$loggedIn = logged_in();
$celestaid = "";
$access_token = "";
if (logged_in()) {
  $celestaid = $_SESSION['celestaid'];
  $access_token = $_SESSION['access_token'];
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
                <img src="<?php echo $event['ev_poster_url'] ?>" width="100%">
              </div>
              <div class="col-lg-6 col-md-6">
                <h3 style="color: #219999">Name: <span style="color: #fff"><?php echo $event['ev_name'] ?></span></h3>
                <h5 style="color: #219999">Description: <span style="color: #fff"><?php echo $event['ev_description'] ?></span></h5>
                <h5 style="color: #219999">Organiser: <span style="color: #fff"><?php echo $event['ev_organiser'] ?></span></h5>
                <h5 style="color: #219999">Club: <span style="color: #fff"><?php echo $event['ev_club'] ?></span></h5>
                <h5 style="color: #219999">Organizer's Phone: <span style="color: #fff"><?php echo $event['ev_org_phone'] ?></span></h5>
                <h5 style="color: #219999">Date: <span style="color: #fff"><?php echo $event['ev_date'] ?></span></h5>
                <h5 style="color: #219999">Start Time: <span style="color: #fff"><?php echo $event['ev_start_time'] ?></span></h5>
                <h5 style="color: #219999">End Time: <span style="color: #fff"><?php echo $event['ev_end_time'] ?></span></h5>
                <?php if($event['is_team_event']){ ?>
                  <h5 style="color: #219999; margin-bottom: 0">Total Amount: <span style="color: #fff">₹<?php echo $event['ev_amount'] ?></span></h5>
                  <small style="color: #fff">This is the total amount to be paid by the captain only.</small>
                  <br><br>
                <?php }else{ ?>
                  <h5 style="color: #219999">Amount: <span style="color: #fff">₹<?php echo $event['ev_amount'] ?></span></h5>
                <?php } ?>
                <a class="btn btn-success" style="color: #fff" href="<?php echo $event['ev_rule_book_url'] ?>">Rulebook</a>
                <?php if ($loggedIn) { ?>
                  <?php if (!$event['is_team_event']) { ?>
                    <button class="btn btn-success" style="color: #fff" id="regEvBtn" onclick="regEvFunc('<?php echo $event['ev_id'] ?>', '<?php echo $celestaid ?>', '<?php echo $access_token ?>')"><span class="spinner-border spinner-border-sm spinner" style="display: none"></span> Register Event</button>
                  <?php } else { ?>
                    <!-- <button class="btn btn-success" style="color: #fff" id="regTeamEvBtn" data-toggle="modal" data-target="#regTeamEvModal">Register Team Event</button> -->
                  <?php } ?>
                <?php } else { ?>
                  <a class="btn" style="color: #fff; background: 	rgb(139,0,139,.8); font-size: 12px" href="./../backend/user/reg.php">Login to Register</a>
                <?php } ?>

              </div>
            </div>
          </div>

      </div>
      </section>
  </div>
  </main>
  </div>

  <!-- modal -->
  <div class="modal" id="regTeamEvModal" style="padding-left: 0px;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><?php echo $event['ev_name']?> Registration Form</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <small>
            <b>Notes:</b><br>
            * Team should consisit of maximum 6 members including team captain.<br>
            * A team can consist of only captain if there are no other members in the team.<br>
          </small>
          <br>
          <form id="regTeamEvForm">
          <div class="form-group">
              <label for="member1">Celesta Id Of Team Captain</label>
              <input type="text" class="form-control" name="celestaid" id="celestaid" value="<?php echo $celestaid?>" disabled>
            </div>
            <div class="form-group">
              <label for="member4">Team Name</label>
              <input type="text" class="form-control" name="team_name" id="team_name" required>
            </div>
            <div class="form-group">
              <label for="member1">Celesta Id of member 1</label>
              <input type="text" class="form-control" name="member1" id="member1">
            </div>
            <div class="form-group">
              <label for="member2">Celesta Id of member 2</label>
              <input type="text" class="form-control" name="member2" id="member2">
            </div>
            <div class="form-group">
              <label for="member3">Celesta Id of member 3</label>
              <input type="text" class="form-control" name="member3" id="member3">
            </div>
            <div class="form-group">
              <label for="member4">Celesta Id of member 4</label>
              <input type="text" class="form-control" name="member4" id="member4">
            </div>
            <div class="form-group">
              <label for="member4">Celesta Id of member 5</label>
              <input type="text" class="form-control" name="member5" id="member5">
            </div>
            <button type="submit" class="btn btn-primary"><span class="spinner-border spinner-border-sm spinner" style="display: none"></span> Register</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- toasts -->
  <div class="toastContainer" style="position: absolute; top: 0; right: 0; margin: 20px; z-index: 99999;">
  </div>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="./js/menu-main.js"></script>
  <!-- #gallery -->

  <!-- events registration js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="regEv.js"></script>

  <!-- team ev registration js -->
  <script>
    var regTeamEvForm = document.querySelector('#regTeamEvForm');
    regTeamEvForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      let spinner = document.querySelector(".spinner");
      spinner.style.display = "inline-block";
      var celestaid="<?php echo $celestaid?>";
      var eventid="<?php echo $event['ev_id']?>";
      var access_token="<?php echo $access_token?>";
      var team_name=document.querySelector('#team_name').value;
      var member1=document.querySelector('#member1').value;
      var member2=document.querySelector('#member2').value;
      var member3=document.querySelector('#member3').value;
      var member4=document.querySelector('#member4').value;
      var member5=document.querySelector('#member5').value;
      console.log(celestaid, eventid, access_token, team_name, member1, member2, member3, member4, member5);

      let formData = new FormData();
      formData.append("eventid", eventid);
      formData.append("celestaid", celestaid);
      formData.append("access_token", access_token);
      formData.append("team_name", team_name);
      formData.append("member1", member1);
      formData.append("member2", member2);
      formData.append("member3", member3);
      formData.append("member4", member4);
      formData.append("member5", member5);
      let url="http://celesta.org.in/backend/admin/functions/reg_team_event.php";
      // let url="http://localhost/celesta2k19-webpage/backend/admin/functions/reg_team_event.php";
      let res = await fetch(
        url,
        {
          body: formData,
          method: "post"
        }
      );
      res = await res.json();
      spinner.style.display = "none";
      console.log(res);

      let htmlData = "";
      if (res.status === 302) {
        res.message.forEach(mes => {
          htmlData += `
              <div class="toast fade show" style="z-index: 999">
                  <div class="toast-header bg-warning">
                      <strong class="mr-auto"><i class="fa fa-globe"></i> Warning</strong>
                      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                  </div>
                  <div class="toast-body">${mes}</div>
              </div>
              `;
        });
      }
      else if (res.status === 302) {
        res.message.forEach(mes => {
          htmlData += `
              <div class="toast fade show" style="z-index: 999">
                  <div class="toast-header bg-warning">
                      <strong class="mr-auto"><i class="fa fa-globe"></i> Warning</strong>
                      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                  </div>
                  <div class="toast-body">${mes}</div>
              </div>
              `;
        });
      }
      else if (res.status === 404) {
        res.message.forEach(mes => {
          htmlData += `
              <div class="toast fade show" style="z-index: 999">
                  <div class="toast-header bg-danger">
                      <strong class="mr-auto"><i class="fa fa-globe"></i> Error</strong>
                      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                  </div>
                  <div class="toast-body">${mes}</div>
              </div>
              `;
        });
      }
      else if (res.status === 405) {
        res.message.forEach(mes => {
          htmlData += `
              <div class="toast fade show" style="z-index: 999">
                  <div class="toast-header bg-danger">
                      <strong class="mr-auto"><i class="fa fa-globe"></i> Error</strong>
                      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                  </div>
                  <div class="toast-body">${mes}</div>
              </div>
              `;
        });
      }
      else if (res.status === 302) {
        res.message.forEach(mes => {
          htmlData += `
              <div class="toast fade show" style="z-index: 999">
                  <div class="toast-header bg-warning">
                      <strong class="mr-auto"><i class="fa fa-globe"></i> Error</strong>
                      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                  </div>
                  <div class="toast-body">${mes}</div>
              </div>
              `;
        });
      }
      else if (res.status === 401) {
        res.message.forEach(mes => {
          htmlData += `
              <div class="toast fade show" style="z-index: 999">
                  <div class="toast-header bg-danger">
                      <strong class="mr-auto"><i class="fa fa-globe"></i> Error</strong>
                      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                  </div>
                  <div class="toast-body">${mes}</div>
              </div>
              `;
        });
      }
      else if (res.status === 202) {
        res.message.forEach(mes => {
          htmlData += `
              <div class="toast fade show" style="z-index: 999">
                  <div class="toast-header bg-success">
                      <strong class="mr-auto"><i class="fa fa-globe"></i> Success</strong>
                      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                  </div>
                  <div class="toast-body">${mes}</div>
              </div>
              `;
        });
      }
      var toastContainer = document.querySelector(".toastContainer");
      toastContainer.innerHTML = htmlData;
      $(".toast").toast();
    });
  </script>
</body>

</html>