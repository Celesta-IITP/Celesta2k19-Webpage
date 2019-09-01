<?php include('includes/header.php') ?>

<?php include('includes/nav.php') ?>

<?php ca_calls()?>
	<div class='row justify-content-md-center'>
		<div class="col-md-auto">
		<form class="form-inline" method="post" role="form" id="show_data">
		  <div class="form-group mb-2">
		    <label for="staticEmail2" class="sr-only">Email</label>
		    <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Enter the Celesta ID:">
		  </div>
          <input type="hidden" value="search_ca" name="search_ca" id="search_ca">
		  <div class="form-group mx-sm-3 mb-2">
		    <label for="celestaid" class="sr-only">Celesta ID</label>
		    <input type="text" class="form-control" name='celestaid' id="celestaid" placeholder="CLST1504" value="CLST">
		  </div>
		  <button type="submit" name="get_details" class="btn btn-primary mb-2" target="_blank">Update Points</button>
		</form>
		</div>
	</div>

	<div class="jumbotron">
		<?php display_message() ;?>
		
		<h1 class="text-center">List of Campus Ambassadors</h1>
	</div>

	<table class="table">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Celesta ID</th>
				<th scope="col">Name</th>
			 	<th scope="col">School/College</th>
			 	<th scope="col">Phone</th>
				<th scope="col">Excitons</th>
                <th scope="col">Gravitons</th>
                <th scope="col">Total</th>
			</tr>
		</thead>
		<tbody>
	<?php show_ca_users(); ?>
		</tbody>
	</table>	

<?php include('includes/footer.php') ?>	