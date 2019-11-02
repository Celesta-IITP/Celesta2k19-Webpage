<?php
    include('./init.php');
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $response=array();
        $message=array();

        $password = $_POST['password'];
        $password1 = $_POST['password1'];
        $email = $_POST['email'];
        $validation_code = $_POST['validation_code'];

        $sql="SELECT id,celestaid FROM users WHERE email='$email' AND validation_code='$validation_code'";
		$result=query($sql);
		confirm($result);

        if(row_count($result)==1){
            $row=fetch_array($result);
            $celestaid=$row['celestaid'];
            
            if($password != $password1) {
                $response['status']=300;
                $message[]="Passwords do not match";
            } else {
                $password=md5($password);
                $email = escape($email);
                $subject = "Password Updated Successfully";
                $msg="<p>Your Celesta account password has been updated successfully.</p>";
                $headers = "From: noreply@yourwebsite.com";
                if(send_email($email, $subject, $msg, $headers)) {
                    $sql = "UPDATE users SET password = '$password' WHERE email = '$email'";
                    $result = query($sql);
                    confirm($result);
                    $response['status']=200;
                    $message[]="Password updated successfully";
                } else {
                    $response['status']=500;
                    $message[]="Mail could not be sent to your registered email";
                }
            }
        } else {
            $response['status']=500;
            $message[]="Server Error";
        }
        $response['message']=$message;
        echo json_encode($response);
}