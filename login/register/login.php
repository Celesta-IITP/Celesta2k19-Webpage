<?php include('includes/header.php') ?>

<?php include('includes/nav.php') ?>

	
	<div class="jumbotron">
		<h1 class="text-center">Registrar Login Here<br/>
			<?php display_message() ?><br/>
			<?php login_registrar() ?></h1>
	</div>

	<form id="registrar-login-form"  method="post" role="form" style="display: block;">
	  <div class="form-group">
	    <label for="email">Email address:</label>
	    <input type="email" class="form-control" id="email" name="email" required>
	  </div>
	  <div class="form-group">
	    <label for="password">Password:</label>
	    <input type="password" class="form-control" id="password" name="password" required>
	  </div>
	  <div class="form-group form-check">
	    <label class="form-check-label">
	      <input class="form-check-input" type="checkbox" name="remember" id="remember"> Remember me
	    </label>
	  </div>
	  <button type="submit" class="btn btn-primary">Submit</button>
	</form>


<?php include('includes/footer.php') ?>