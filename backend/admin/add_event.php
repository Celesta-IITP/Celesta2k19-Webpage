<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>

<?php 	
    $permit = getPermit();
    echo $permit;
    if($permit==0 || $permit==4){?>
    	<div class="jumbotron">
            <?php 
                display_message() ;
                addEvent(); ?>
            <h1 class="text-center">Add an Event</h1>
        </div>
    <?php
    }else{
        redirect("./logout.php");
    }
?>

<!-- Add the HTML codes from here-->
<form method="POST" enctype="multipart/form-data">

    <div class="form-group">
        <label for="event_name">Event/Workshop Name</label>
        <input type="text" class="form-control" id="event_name" name="event_name" placeholder="Type the event name" required>
    </div>

    <div class="form-group">
        <label for="exampleFormControlSelect1">Category</label>
        <select class="form-control" id="event_category" name="event_category" required>
        <option>Events</option>
        <option>Workshops</option>
        <option>Exhibitions</option>
        <option>ProNite</option>
        <option>Guest Talks</option>
        </select>
    </div>

    <div class="form-group">
        <label for="event_organizer">Organizers Name</label>
        <input type="text" class="form-control" id="event_organizer" name="event_organizer" placeholder="Enter the name of event organizer" required>
    </div>

    <div class="form-group">
        <label for="event_organizer">Organizers Phone Number</label>
        <input type="text" class="form-control" id="event_org_phone" name="event_org_phone" placeholder="Enter the phone numbers of event organizers" required>
    </div>

    <div class="form-group">
        <label for="exampleFormControlSelect1">Choose The organizing Club</label></label>
        <select class="form-control" id="ev_club" name="ev_club" required>
        <option>SCME</option>
        <option>NJACK</option>
        <option>SPARKONICS</option>
        <option>CHESSX</option>
        <option>ACE</option>
        <option>E-CLUB</option>
        <option>LOCK-N-LOAD</option>
        <option>ANONYMOUS</option>
        <option>ROBOTICS</option>
        <option>MAIN STAGE</option>
        <option>FUN EVENTS</option>
        <option>TINKERER LAB</option>
        <option>ROBOTICS AND IOT</option>
        <option>AUTOMOBILES AND IC ENGINES</option>
        <option>EXHIBITIONS</option>
        <option>CONCLAVE</option>
        </select>
    </div>

    <div class="form-group">
        <label for="event_organizer">Event Description</label>
        <textarea type="text" class="form-control" id="event_desc" name="event_desc" placeholder="Write about the event"rows="3" required></textarea>
    </div>

    <div class="form-group">
        <label for="event_organizer">Event Date</label>
        <input type="text" class="form-control" id="event_date" name="event_date" placeholder="Date of the event" required>
    </div>

    <div class="form-group">
        <label for="event_organizer">Event Start Time</label>
        <input type="text" class="form-control" id="event_start_time" name="event_start_time" placeholder="Event start time" required>
    </div>

    <div class="form-group">
        <label for="event_organizer">Event End Time</label>
        <input type="text" class="form-control" id="event_end_time" name="event_end_time" placeholder="Event end time" required>
    </div>


    <div class="form-group">
        <label for="exampleFormControlFile1">Event Poster</label>
        <input type="file" class="form-control-file" id="event_poster" name="event_poster"  accept="image/gif, image/jpeg, image/png, image/jpg" required >
    </div>

    <div class="form-group">
        <label for="exampleFormControlFile1">Event RuleBook</label>
        <input type="file" class="form-control-file" id="event_rulebook" name="event_rulebook" accept="application/pdf" required>
    </div>

   <button type="submit" class="btn btn-primary">Submit</button>
</form>

<!-- End the HTML codes from here-->
<?php include('includes/footer.php') ?>	