<?php
    include('../backend/user/functions/init.php');
    $loggedIn=false;
    if(logged_in()){
        $loggedIn = true;
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Campus Ambassador</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="./css/ca-styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
</head>

<body style="background-color:#181818;">

    <nav class="navbar navbar-expand-lg navbar-#181818 bg-#181818">
        <!-- <div class="container"> -->
  `      <a style="color:white;"class="navbar-brand" href="../"> C E L E S T A'19</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a style="color:LavenderBlush;" class="nav-link" href="../">Home</a>
                </li>
                <?php if($loggedIn) {?>
                    <li class="nav-item active">
                        <a style="color:LavenderBlush;" class="nav-link" href="../backend/user/profile.php">Profile</a>
                    </li>
                    <li class="nav-item active">
                        <a style="color:LavenderBlush;"class="nav-link" href="../backend/user/ca_logout.php">Logout</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item active">
                        <a style="color:LavenderBlush;"class="nav-link" href="../backend/user/ca_register.php">Register</a>
                    </li>
                    <li class="nav-item active">
                        <a style="color:LavenderBlush;"class="nav-link" href="../backend/user/reg.php">Login</a>
                    </li>
                <?php } ?>
                <li class="nav-item active">
                    <a style="color:LavenderBlush;"class="nav-link" href="https://internshala.com/internship/detail/campus-ambassador-programme-at-celesta-iit-patna1570467717">Register via Internshala</a>
                </li>
            </ul>
        </div>
        <!-- </div> -->
    </nav>

    <!-- Header -->
    <div id="header">
        <h6 style="color:red">
            <!-- IIT Patna's -->
        </h6>

        <h1 style="color: #fff">Celesta'19</h1><br>
        <h1 style="color: #fff">Campus Ambassador Programme</h1><br>

        <center>
            <a href="https://drive.google.com/file/d/10-NSUM3Y7D2gg1Eg7lkRsH7IbK8zJ7Nl/view" target="_blank">
                <div id="FB-Oauth">
                    <div class="fb-text">
                        <h3>Rulebook</h3>
                    </div>
                </div>
            </a>
            <?php if($loggedIn) {?>
                <a href="../backend/user/ca_register.php">
                    <div id="FB-Oauth">
                        <div class="fb-text">
                            <h3>Profile</h3>
                        </div>
                    </div>
                </a>
            <?php } else { ?>
                <a href="../backend/user/ca_register.php">
                    <button class="btn btn-success" style="padding: 10px; font-size: 18px">Register</button>
                </a>
                <a href="../backend/user/reg.php">
                    <button class="btn btn-success" style="padding: 10px; font-size: 18px">Login</button>
                </a>
                <br><br>
            <?php } ?>
            <a href="https://internshala.com/internship/detail/campus-ambassador-programme-at-celesta-iit-patna1570467717">
                <button class="btn btn-warning" style="padding: 10px; font-size: 18px">Register via Internshala</button>
            </a>
        </center>
        <div class="imgClass type1 img1"><img src="./images/img/1.png"></div>
        <div class="imgClass type1 img2"><img src="./images/img/2.png"></div>
        <div class="imgcontainer type1 imgClass">
        </div>
    </div>

    <!-- Main -->
    <div id="main" style="background-color:#181818;">

        <header class="major container 95%">
            <h1 style="font-size: 40px">About us</h1><br>
            <p style="color:#282828">
                Celesta is the annual techno-management extravaganza celebrated with utmost pomp and vigour, in autumn. Since it's inception in 2010, it has grown into one of the most anticipated student organized youth festival. From NASA scientists to college geniuses, from ethical hackers to breathtaking treasure hunters, from game development to gaming war, from robotics to IPL Auction, from Model United Nations to foreign exchange conferences, Celesta, lives up to every expectations and more, urging every individual to unleash their inner passion to reach their ultimate dream. Student fraternity who work day in day out, pouring out all of their heart into promoting intellectualism and creativity, while also maintaing the brand value of one of the most prestigious institute of the nation, IIT. Celesta saw a footfall of around 4K, of people belonging to a plethora of sectos such as computer geeks, gaming freaks, technoholics, treasure hunters, and robotic geniuses hailing from well-known institutes across the country. </p>
        </header>

        <div class="box alt container">
            <section class="feature left">
                <a class="image icon  fa-retweet"><img src="./images/pic07.jpg" alt="" height="700" /></a>
                <div class="content">
                    <h3 style="color:white;">What is Campus Ambassador?</h3>
                    <p style="color:LavenderBlush;">
                        The Campus Ambassador program is one of the leading publicity programs of Celesta. The promotion of the fest in the respective colleges is assigned to the campus ambassadors. They serve as the intermediaries who bridge the gap between their college and our campus i.e, as a nodal point for any kind of communication or promotion. Campus ambassadors act as the face of one of the biggest techno-management festival in the entire North-East India and are entrusted with the job of increasing the outreach of the fest through on field and social media publicity. The campus ambassadors are entitled to exciting prizes, apart from the coveted certificate and many other goodies.
                    </p>
                </div>
            </section>
            <section class="feature right">
                <a class="image icon fa-sitemap"><img src="./images/pic07.jpg" alt="" height="700" /></a>
                <div class="content">
                    <h3 style=" color:white">Why CA?</h3>
                    <p style="color:LavenderBlush;">
                        This is an extremely edifying opportunity where one gets to improve their oratory skills and managerial skills by interacting with people and encouraging them to take part in a fest of such huge grandeur. Apart from being advantageous on both personal and managerial grounds, working as a CA also comes with the additional perks of being conferred with an assured certificate from Celesta, IIT Patna validating your work as a campus ambassador. Not to forget are the exhilaratinging prizes and goodies that a CA receives.
                    </p>
                </div>
            </section>
        </div>


        <div class="box container blahh">
            <section>
                <header>
                    <h3>CA's Experience</h3>
                </header>
                <blockquote style="color:#282828"> Celesta .. whenever I think about it...the word comes in my mind is....#teamwork & path provider of talents..Before celesta...I was just a boy in my college...but when I participated in 2k17 addition..i got a chance to work & perform with super talented guys.. now..it's just because of Celesta..I am Tech Coordinator of my College..In short it brings ...a revolutionary changes in my life... Thanks team Celesta<br>-<b>Prince Singh</b> </blockquote>
                <blockquote style="color:#282828"> Hello IITP, I remember I went to Celesta when I was in the first year of my college. I was scared but yeah that experience pulled me again and again and Celesta 2K18 was my third year in a row. And this year was damn amazing...The environment was spellbinding. And yeah, I really enjoyed working and sharing the notifications of Celesta 2k18. In between of those times sometimes I started feeling like I am the part of the Team and yeah, it was great being a part of such great environment and such enthusiastic people.. Celesta is not just a college fest, it feels like it's a Festival that comes every year and we all celebrate it together.. 🖤 <br>-<b>Mridul Choudhary</b> </blockquote>
                <blockquote style="color:#282828">As you mentioned, Celesta is the biggest techno-management fest of north-east India. Being a campus ambassador for it was an amazing experience. I not only enjoyed being working as the campus ambassador, but also enjoyed your fest. The participants from my college were also very happy by your organisation. Hope to continue to work with you all more as I gained a good experience. Thank you for selecting me as the campus ambassador of my college. <br>-<b>Kamal Kant</b> </blockquote>
            </section>

        </div>
    </div>

    <!-- Footer -->
    <div id="footer">
        <div class="container 75%">

            <header class="major last">
                <h2>Sign-Up</h2>
                <center>
                    <h2>Step 1</h2>
                    <div id="FB-Oauth2" class="fb2css">
                        <div class="fb-text">Sign-Up</div>
                    </div>
                </center>
            </header>
            <div id="message"></div><br>
            <ul class="icons">
                <li><a href="https://www.facebook.com/anwesha.iitpatna/" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                <li><a href="https://www.instagram.com/anwesha.iitp/" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
                <li><a href="https://www.youtube.com/user/AnweshaIITP" class="icon fa-youtube"><span class="label">Youtube</span></a></li>

            </ul>

            <ul class="copyright">
                <li>Celesta IIT Patna</li>
            </ul>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>