<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>

<?php 
    $permit=getPermit();
	if($permit==0 or $permit==2 or $permit==5){
        $users=array_reverse(show_accos());
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
			 	<th scope="col">Phone</th>
				<th scope="col">Email</th>
                <th scope="col">Gender</th>
                <th scope="col">Day1</th>
                <th scope="col">Day2</th>
                <th scope="col">Day3</th>
                <th scope="col">Amount</th>
			</tr>
		</thead>
		<tbody>
			<?php $count=1; foreach($users as $ca) { ?>
				<tr>
					<th scope='row'><?php echo $count++; ?></th>
					<td><?php echo $ca['celestaid']; ?></td>
					<td><?php echo $ca['names']; ?></td>
					<td><?php echo $ca['phone']; ?></td>
					<td><?php echo $ca['email']; ?></td>
					<td><?php echo $ca['gender']; ?></td>
                    <td><?php echo $ca['day1']; ?></td>
                    <td><?php echo $ca['day2']; ?></td>
                    <td><?php echo $ca['day3']; ?></td>
                    <td><?php echo $ca['amount_paid']; ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

<?php include('includes/footer.php') ?>	