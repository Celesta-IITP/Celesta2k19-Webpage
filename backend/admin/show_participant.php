<?php include('includes/header.php') ?>

<?php include('includes/nav.php') ?>

	<div class="jumbotron">
        
        <?php
            display_message() ;
            $row=showEventParticipants();
            if($row!=false){
                $participants=json_decode($row["ev_registrations"]);
                $is_team_event=$row["is_team_event"];
            }else{
                echo "<p class='bg-danger text-center'>No data found!!</p>";
            }
            ?>
             <h1 class="text-center"> Participants of the event <?php echo $row["ev_name"] ?></h1>
	</div>

    <div>
            <dl>
            <?php 
                foreach($participants as $part){
                    if($is_team_event==1){
                        $team_name=$part->team_name;
                        $cap_name=$part->cap_name;
                        $cap_celestaid=$part->cap_celestaid;
                        $cap_phone=$part->cap_phone;
                        $cap_email=$part->cap_email;
                        $amount=$part->amount;
                        ?>
                        <dt><?php echo $team_name ?></dt>
                        <dd>Captain Name: <?php echo $cap_name?></dd>
                        <dd>Captain Celestaid: <?php echo $cap_celestaid?></dd>
                        <dd>Captain Phone: <?php echo $cap_phone?></dd>
                        <dd>Captain email: <?php echo $cap_email?></dd>
                        <dd>Amount: <?php echo $amount ?></dd>
                        <br>
                        <?php ?>
                    <?php
                    }else{
                        $celestaid=$part->celestaid;
                        $name=$part->name;
                        $phone=$part->phone;
                        $amount=$part->amount;
                        ?>
                        <dd>Name: <?php echo $name ?></dd>
                        <dd>CelestaID: <?php echo $celestaid ?></dd>
                        <dd>Amount: <?php echo $amount ?></dd>
                        <dd>Phone: <?php echo $phone ?></dd>
                        <br>
                        <?php
                    }
                }
                ?>
            </dl>

    </div>