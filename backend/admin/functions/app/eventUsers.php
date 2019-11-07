<?php
include('./../init.php');

$response=array();
$message=array();

if($_SERVER['REQUEST_METHOD']=='POST'){
    $access_token=clean($_POST['access_token']);
    // $permit=clean($_POST['permit']);
    $ev_id=clean($_POST['ev_id']);
    $admin=clean($_POST['email']);

    $sql2="SELECT id,permit FROM admins where access_token='$access_token' and email='$admin'";
    $result2=query($sql2);
    $row2=fetch_array($sql2);
    if(row_count($result2)!=1){
        $response['status']=401;
        $message="Admin not found.";
    }else{
        $permit=$row2['permit'];
        if($permit==0 || $permit==4){
            $sql="SELECT ev_name, is_team_event, ev_registrations FROM events where ev_id='$ev_id'";
            $result=query($sql);
            $row=fetch_array($result);

            $response['status']=200;
            $response['ev_id']=$ev_id;
            $response['ev_name']=$row['ev_name'];
            $response['is_team_event']=$row['is_team_event'];
            if($row['is_team_event']==1){
                $response['team_details']=json_decode($row['ev_registrations']);
            }else{
                $response['registered_users']=json_decode($row['ev_registrations']);
            }
            $message="Successfully fetched events data.";
        }else{
            $response['status']=401;
            $message="Admin unauthorized to perform this action.";
        }
    }
    $response['message']=$message;

    echo json_encode($response);
}//Ending of if part of post method
