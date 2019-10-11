<?php include('functions/init.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Celesta2k19 || Registration Desk</title>
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/register.css">
</head>
<body>


<!------ Include the above in your HEAD tag ---------->
<div class="container">
	<?php include('includes/nav.php') ?>
	<?php display_message()?>
</div>	

<div class="container">
	<br>
	<br>
	<div class='row justify-content-md-center'>
		<div class="col-md-auto">
		<form class="form-inline" method="post" role="form" id="show_data">
		  <div class="form-group mb-2">
		    <label for="staticEmail2" class="sr-only">Email</label>
		    <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Enter the Celesta ID:">
		  </div>
		  <div class="form-group mx-sm-3 mb-2">
		    <label for="celestaid" class="sr-only">Celesta ID</label>
		    <input type="text" class="form-control" name='celestaid' id="celestaid" placeholder="CLST1504" value="CLST">
		  </div>
		  <button type="submit" name="get_details" class="btn btn-primary mb-2">Search Details</button>
		</form>
		</div>
	</div>

	<?php registrar_register() ?>

	
</div>

</body>
</html>