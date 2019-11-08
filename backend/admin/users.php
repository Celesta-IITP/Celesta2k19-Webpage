<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>

<?php 
	if(getPermit()==0 || getPermit()==2){
        $users=array_reverse(show_users());
	}else{
		redirect("./logout.php");
	}
?>

	<div class="jumbotron">
		<?php display_message() ;?>
		<h1 class="text-center">List of Users</h1>
	</div>

	<table class="table">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Celesta ID</th>
				<th scope="col">Name</th>
			 	<th scope="col">School/College</th>
			 	<th scope="col">Phone</th>
				<th scope="col">Email</th>
                <th scope="col">Gender</th>
			</tr>
		</thead>
		<tbody>
			<?php $count=1; foreach($users as $ca) { ?>
				<tr>
					<th scope='row'><?php echo $count++; ?></th>
					<td><?php echo $ca['celestaid']; ?></td>
					<td><?php echo $ca['first_name'] ." ". $ca['last_name']; ?></td>
					<td><?php echo $ca['college']; ?></td>
					<td><?php echo $ca['phone']; ?></td>
					<td><?php echo $ca['email']; ?></td>
					<td><?php echo $ca['gender']; ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>	

<?php include('includes/footer.php') ?>	