<?php
    include('./init.php');
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $response=array();
        $message=array();

        $email = $_POST['email'];

        $sql="SELECT id,celestaid FROM users WHERE email='$email'";
		$result=query($sql);
		confirm($result);

        if(row_count($result)==1){
            $row=fetch_array($result);
			$celestaid=$row['celestaid'];
            $validation_code=md5($celestaid.microtime());

            $email = escape($email);
            $activation_link="https://celesta.org.in/backend/user/resetPassword.php?email=$email&code=$validation_code";
            $subject = "Reset your Celesta Account password";
            $msg="<p>
				Please click the link below to reset your celesta account password.<br/>
					<a href='$activation_link'>$activation_link</a>
					</p>
				";
            $headers = "From: noreply@yourwebsite.com";
            if(send_email($email, $subject, $msg, $headers)) {
                $sql = "UPDATE users SET validation_code = '$validation_code' WHERE email = '$email'";
                $result = query($sql);
                confirm($result);
                $response['status']=200;
                $message[]="Please check your email or spam folder for a password reset code";
            } else {
                $response['status']=500;
                $message[]="Mail could not be sent to your registered email";
            }
        } else {
            $response['status']=404;
            $message[]="This email does not exist";
        }
        $response['message']=$message;
        echo json_encode($response);
}