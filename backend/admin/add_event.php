<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>

<?php 	
    $permit = getPermit();
    // echo $permit;
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
        <label for="exampleFormControlSelect1">Choose The organizing Club</label></label>
        <select class="form-control" id="ev_club" name="ev_club" required>
        <option>TECH</option>
        <option>NON-TECH</option>
        <option>CODING</option>
        <option>MANAGEMENT</option>
        <option>ROBOTICS</option>
        <option>QUIZ</option>
        <option>TREASURE-HUNT</option>
        </select>
    </div>

    <div class="form-group">
        <label for="event_name">Event/Workshop Name</label>
        <input type="text" class="form-control" id="event_name" name="event_name" placeholder="Type the event name" required>
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
        <label for="event_organizer">Event Description</label>
        <textarea type="text" class="form-control" id="event_desc" name="event_desc" placeholder="Write about the event"rows="3" required></textarea>
    </div>

    <div class="form-group">
        <label for="exampleFormControlSelect1">Is it a Team Event?</label>
        <select class="form-control" id="team_event" name="team_event" required>
            <option>True</option>
            <option selected="selected">False</option>
        </select>
    </div>
    <div class="form-group">
        <label for="event_organizer">Maximum number of participants?</label>
        <small>(By default max_participants value is 1. If its a team event then enter total number of participants including team captain.)</small>
        <input type="number" class="form-control" id="max_participants" name="max_participants" value=1 required>
    </div>

    <div class="form-group">
        <label for="event_organizer">Event Date</label>
        <input type="text" class="form-control" id="event_date" name="event_date" placeholder="Date of the event" required>
    </div>
    
    <div class="form-group">
        <label for="event_organizer">Event Venue</label>
        <input type="text" class="form-control" id="event_venue" name="event_venue" placeholder="Venue of the event" required>
    </div>

    <div class="form-group">
        <label for="event_organizer">Map URL of Venue</label>
        <input type="text" class="form-control" id="map_url" name="map_url" placeholder="Map url of the venue" >
    </div>

    <div class="form-group">
        <label for="event_organizer">Event registration fee</label>
        <input type="text" class="form-control" id="event_amount" name="event_amount" placeholder="Registration fee for the event" required>
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