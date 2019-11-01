<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>

<?php 	
    if(!registrar_logged_in()){
		redirect("login.php");
	}
    $permit = getPermit();
    if($permit==0 || $permit==4){?>
    	<div class="jumbotron">
            <?php 
                display_message() ;
            ?>
            <h1 class="text-center">Send Mail</h1>
        </div>
    <?php
    }else{
        redirect("./logout.php");
    }
    
    $sql="SELECT id, email, celestaid FROM users WHERE active='1'";
    $result=query($sql);
    confirm($result);
    $data_emails=array();
    while ($row = $result->fetch_assoc()) {
        $data_emails[]=$row['email'];
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(isset($_POST['send_bulk_mail'])){
            $subject=$_POST['subject'];
            $msg=$_POST['message'];
			$header="From: celesta19@gmail.com";
	        if(send_bulk_email($data_emails,$subject,$msg,$header)){
                echo "<p class='bg-success'>Mails sent</p>";
            } else {
                echo "<p class='bg-danger'>Mails not sent</p>";
            }
		}else{
			return false;
		}
	}
?>

<!-- Add the HTML codes from here-->
<form method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="subject">Subject</label>
        <input type="text" class="form-control" id="subject" name="subject" required>
    </div>
    <div class="form-group">
        <label for="subject">Message</label>
        <textarea type="text" class="form-control" id="message" name="message" required></textarea>
    </div>
   <button type="submit" class="btn btn-primary" name="send_bulk_mail">Send mail to all users</button>
</form>

<!-- End the HTML codes from here-->
<?php include('includes/footer.php') ?>	