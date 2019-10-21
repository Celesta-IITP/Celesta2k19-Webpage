<?php
include('./../init.php');
    
$response=array();
$message=array();

// API to login the admin users
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email=escape($_POST['email']);
    $password=escape($_POST['password']);
    $password=md5($password);

    $sql="SELECT * FROM admins WHERE email='$email'";
    $result=query($sql);
    confirm($result);

    if(row_count($result)==1){
        $row=fetch_array($result);
        $db_pass=$row['password'];

        if($db_pass!=$password){
            $response['status']=401;
            $message[]="Password you entered is incorrect. Try again.";
        }else{
            $access_token=md5($email.$password);
            $permit=$row['permit'];
            $position=$row['position'];

            $sql1="UPDATE admins SET access_token='$access_token' WHERE email='$email'";
            $result1=query($sql1);
            confirm($result1);

            $response['access_token']=$access_token;
            $response['permit']=$permit;
            $response['status']=200;
            $response['position']=$position;
            $message[]="Successfully logged in";
        }

    }else{
        $response['status']=204;
        $message[]="User not found";
    }
    $response['message']=$message;
    echo json_encode($response);

}else{
    $response['status']=405;
    $message[]="Method Not Allowed";
    $response['message']=$message;
    echo json_encode($response);
}
