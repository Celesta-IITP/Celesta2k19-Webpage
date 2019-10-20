<?php include('includes/header.php') ?>

<?php include('includes/nav.php') ?>

	<div class="jumbotron">
		<?php display_message() ;?>
		
		<h1 class="text-center">List of Registered Users</h1>
	</div>

	<table class="table">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">CelestaID</th>
				<th scope="col">Date</th>
				<th scope="col">Name</th>
			 	<th scope="col">School/College</th>
			 	<th scope="col">Phone</th>
				<th scope="col">T-Shirt</th>
				<th scope="col">Accommodation</th>
				<th scope="col">Registration</th>
				<th scope="col">Events</th>
				<th scope="col">Total</th>
			</tr>
		</thead>
		<tbody>
	<?php total_register(); ?>
		</tbody>
	</table>	

<?php include('includes/footer.php') ?>	