<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>

<?php 	
    $permit = getPermit();
    echo $permit;
    if($permit==0 || $permit==4){
		$events=show_events();
        // ca_calls();
    }else{
        redirect("./logout.php");
    }
?>
	<div class="jumbotron">
		<?php display_message() ;?>
		<h1 class="text-center">Events/Workshops/ProNites/Guest Talk</h1>
	</div>

	<table class="table">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Event ID</th>
				<th scope="col">Event Name</th>
			 	<th scope="col">Club</th>
				<th scope="col">Event Category</th>
			 	<th scope="col">Organizer</th>
				<th scope="col">Organizer' Phone</th>
				<th scope="col">Event Date</th>
				<th scope="col">Edit</th>
                
			</tr>
		</thead>
		<tbody>
			<?php $count=1; foreach($events as $event) { ?>
				<tr>
					<th scope='row'><?php echo $count++; ?></th>
					<td><?php echo $event['ev_id']; ?></a></td>
					<td><?php echo $event['ev_name']; ?></td>
					<td><?php echo $event['ev_club']; ?></td>
					<td><?php echo $event['ev_category']; ?></td>
					<td><?php echo $event['ev_organiser']; ?></td>
					<td><?php echo $event['ev_org_phone']; ?></td>
					<td><?php echo $event['ev_date']; ?></td>
					<td><a href="./update_event.php?eventid=<?php echo $event['ev_id']; ?>"><i class="fa fa-edit" style="font-size:24px"></i></a></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>	

<?php include('includes/footer.php') ?>	