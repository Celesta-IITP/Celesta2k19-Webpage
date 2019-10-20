<?php include('includes/header.php') ?>

<?php include('includes/nav.php') ?>

	<div class="jumbotron">
        <?php display_message() ;
            updateEventCalls();
        ?>
        <?php 
            if(!isset($_GET['eventid'])){
                redirect("events.php");
            }
            $eventid=$_GET['eventid'];
            $event = getEvent($eventid) ?>
		
		<h1 class="text-center"> Update Event</h1>
	</div>

<form method="POST" enctype="multipart/form-data">

    <div class="form-group">
        <label for="event_name">Event/Workshop Name</label>
        <input type="text" class="form-control" id="event_name" name="event_name" placeholder="Type the event name" required value="<?php echo $event['ev_name']?>">
    </div>

    <input type="hidden" name="eventid" id="eventid" value="<?php echo $eventid ?>" />

    <div class="form-group">
        <label for="exampleFormControlSelect1">Category</label>
        <select class="form-control" id="event_category" name="event_category" required>
        <option selected="selected"><?php echo $event['ev_category']?></option>
        <option>Eventsall</option>
        <option>Eventscollege</option>
        <option>Eventsschool</option>
        <option>Ozone</option>
        <option>Schoolevents</option>
        <option>Workshops</option>
        <option>Exhibitions</option>
        <option>Pronites</option>
        <option>Guesttalks</option>
        </select>
    </div>

    <div class="form-group">
        <label for="exampleFormControlSelect1">Choose The organizing Club</label></label>
        <select class="form-control" id="ev_club" name="ev_club" required>
        <option selected="selected"><?php echo $event['ev_club']?></option>
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
        <label for="event_organizer">Organizers Name</label>
        <input type="text" class="form-control" id="event_organizer" name="event_organizer" placeholder="Enter the name of event organizer"  value="<?php echo $event['ev_organiser']?>">
    </div>

    <div class="form-group">
        <label for="event_organizer">Organizers Phone Number</label>
        <input type="text" class="form-control" id="event_org_phone" name="event_org_phone" placeholder="Enter the phone numbers of event organizers"  value="<?php echo $event['ev_org_phone']?>">
    </div>
    
    <div class="form-group">
        <label for="exampleFormControlSelect1">Is it a Team Event?</label>
        <select class="form-control" id="team_event" name="team_event" required>
        <?php if($event['is_team_event']==0){ ?>
            <option>True</option>
            <option selected="selected">False</option>
        <?php }else{?>
            <option selected="selected">True</option>
            <option>False</option>
        <?php }?>
        </select>
    </div>

    <div class="form-group">
        <label for="exampleFormControlSelect1">Maximum no of team members (If its a team event)</label>
        <select class="form-control" id="team_members" name="team_members" required>
            <option selected="selected"><?php echo $event["team_members"] ?></option>
            <option >1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
        </select>
    </div>

    <div class="form-group">
        <label for="event_organizer">Event Description</label>
        <textarea type="text" class="form-control" id="event_desc" name="event_desc" placeholder="Write about the event"rows="3"  ><?php echo $event['ev_description']?></textarea>
    </div>

    <div class="form-group">
        <label for="event_organizer">Event Date</label>
        <input type="text" class="form-control" id="event_date" name="event_date" placeholder="Date of the event"  value="<?php echo $event['ev_date']?>">
    </div>
        
    <div class="form-group">
        <label for="event_organizer">Event Venue</label>
        <input type="text" class="form-control" id="event_venue" name="event_venue" placeholder="Venue of the event"  value="<?php echo $event['ev_venue']?>" >
    </div>

    <div class="form-group">
        <label for="event_organizer">Map URL of Venue</label>
        <input type="text" class="form-control" id="map_url" name="map_url" placeholder="Map url of the venue"  value="<?php echo $event['map_url']?>" >
    </div>

    <div class="form-group">
        <label for="event_organizer">Event registration fee</label>
        <input type="text" class="form-control" id="event_amount" name="event_amount" placeholder="Registration fee for the event"  value="<?php echo $event['ev_amount']?>" >
    </div>

    <div class="form-group">
        <label for="event_organizer">Event Start Time</label>
        <input type="text" class="form-control" id="event_start_time" name="event_start_time" placeholder="Event start time"  value="<?php echo $event['ev_start_time']?>">
    </div>

    <div class="form-group">
        <label for="event_organizer">Event End Time</label>
        <input type="text" class="form-control" id="event_end_time" name="event_end_time" placeholder="Event end time"  value="<?php echo $event["ev_end_time"]?>">
    </div>

    <div class="form-group">
        <label for="event_organizer">Event Prize</label>
        <input type="text" class="form-control" id="ev_prize" name="ev_prize" placeholder="Event prize money" value="<?php echo $event['ev_prize'] ?>">
    </div>

    <div class="form-group">
        <label for="exampleFormControlFile1">Event Poster</label>
        <input type="file" class="form-control-file" id="event_poster" name="event_poster"  accept="image/gif, image/jpeg, image/png, image/jpg">
    </div>

    <div class="form-group">
        <label for="exampleFormControlFile1">Event RuleBook</label>
        <input type="file" class="form-control-file" id="event_rulebook" name="event_rulebook" accept="application/pdf">
    </div>

   <button type="submit" name="update_event" id="update_event" class="btn btn-primary">Update Event</button>
   <button type="submit" name="cancel_event" id="cancel_event" class="btn btn-primary">Cancel</button>
   <button type="submit" name="delete_event" id="delete_event" class="btn btn-danger pull-right">Delete Event</button>
</form>


<?php include('includes/footer.php') ?>