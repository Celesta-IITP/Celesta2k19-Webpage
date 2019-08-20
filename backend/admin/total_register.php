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
				<th scope="col">Celesta ID</th>
				<th scope="col">Date</th>
				<th scope="col">Name</th>
			 	<th scope="col">School/College</th>
			 	<th scope="col">Phone</th>
				<th scope="col">QR Code</th>
			</tr>
		</thead>
		<tbody>
	<?php total_register(); ?>
		</tbody>
	</table>	

<?php include('includes/footer.php') ?>	