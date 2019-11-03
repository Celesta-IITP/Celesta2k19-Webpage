<?php
include('./../init.php');

$response=array();
$message=array();

if($_SERVER['REQUEST_METHOD']=='POST'){
    $access_token=clean($_POST['access_token']);
    $permit=clean($_POST['permit']);

    $sql2="SELECT id,permit FROM admins where access_token='$access_token'";
    $result2=query($sql2);
    $row2=fetch_array($sql2);
    if(row_count($result2)!=1){
        $response['status']='401';
        $message="Invalid user.";
    }else{
        if($permit==0 || $permit==4){
            $sql="SELECT ev_name, ev_id, is_team_event FROM events";
            $result=query($sql);
            $event=[];
        while ($row = $result->fetch_assoc()) {
            $events[]=$row;
        }
        $response['status']=200;
        $response['events']=$events;
        $message="Successfully fetched events data.";
        }else{
            $response['status']='401';
            $message="Admin unauthorized to perform this action.";
        }
    }
    $response['message']=$message;

    echo json_encode($response);
}//Ending of if part of post method
