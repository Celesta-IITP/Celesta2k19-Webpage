<?php
include('./../init.php');

$response=array();
$message="";

if($_SERVER['REQUEST_METHOD']=='POST'){
    $access_token=clean($_POST['access_token']);
    // $permit=clean($_POST['permit']);
    // $celestaid=clean($_POST['celestaid']);
    $admin=clean($_POST['email']);

    $sql2="SELECT id, permit FROM admins where access_token='$access_token' and email='$admin'";
    $result2=query($sql2);
    $row2=fetch_array($result2);
    // echo $sql2;
    if(row_count($result2)!=1){
        $response['status']=401;
        $message="Admin not found.";
    }else{
        $permit=$row2['permit'];
        if($permit==0 || $permit==5 || $permit==2){
            $sql="SELECT id, names, phone, amount_paid, gender, celestaid FROM accommodation";
            $result=query($sql);
            $users=array();
            while ($row = $result->fetch_assoc()) {
                $users[]=$row;
            }
            $response['users']=$users;
            $response['status']=200;
            $message="Successfully send data.";
        }else{
            $response['status']=401;
            $message="Admin unauthorized to perform this action.";
        }
    }
    $response['message']=$message;

    echo json_encode($response);
}//Ending of if part of post method
