<?php
include('./init.php');

if($_SERVER['REQUEST_METHOD']=="GET"){
    
    $errors=array();
    $response=array();
    
    // Execute 
    $eventid=clean($_GET["eventid"]);
    $celestaid=clean($_GET["celestaid"]);
    $access_token=clean($_GET["access_token"]);

    if(eventExists($eventid)){ // Checking for existence of event. Declared in functions.php

        $sql = "SELECT first_name,last_name, phone, events_registered FROM users WHERE celestaid='$celestaid' and access_token='$access_token'";
        $result=query($sql);
        confirm($result);
        // Checking if user is valid or not
        if(row_count($result)==1){

            // Fetch event details
            $sql1="SELECT * FROM events WHERE ev_id='$eventid'";
            $result1=query($sql1);
            $row1=fetch_array($result1);
            $regis=json_decode($row1["ev_registrations"]);
            $ev_name=$row1["ev_name"];

            $row=fetch_array($result);

            // Check if user has already registered or not
            if(alreadyRegistered($celestaid, $regis)){
                $response['status']=302;
                $errors[]="Already registered.";
            }else{

                /**  Things to be implemented
                 * 1. Enter the data into the ev_registrations column of events table.
                 * 2. Update the event registration in the user table corresponding to that user
                 * 3. Update the data in the present users table events_registered column
                 */

                // Updating the data into the events table.
                $reg=array();
                $reg["celestaid"]=$celestaid;
                $reg["name"]=$row["first_name"]." ".$row["last_name"];
                $reg["phone"]=$row["phone"];
                $reg["time"]=date('Y-m-d H:i:s');
                $regis[]=$reg;
                $regis=json_encode($regis);
                $sql2="UPDATE events SET ev_registrations='$regis' WHERE ev_id='$eventid'";
                $result2=query($sql2);

                // Updating the data into the user table.
                $ev_registered=json_decode($row["events_registered"]);
                $add_event=array();
                $add_event["ev_name"]=$ev_name;
                $add_event["ev_id"]=$eventid;
                $ev_registered[]=$add_event;
                $ev_registered=json_encode($ev_registered);
                $sql3="UPDATE users SET events_registered='$ev_registered' WHERE celestaid='$celestaid'";
                $result3=query($sql3);

                // Check if user is present in the present user table or not
                $sql4="SELECT * FROM present_users WHERE celestaid='$celestaid'";
                $result4=query($sql4);
                if(row_count($result4)==1){
                    // Update the data in the present users table events_registered columnr
                    $sql5="UPDATE present_users SET events_registered='$ev_registered' WHERE celestaid='$celestaid'";
                    $result5=query($sql5);
                }

                $response['status']=202;
                $errors[]="Successfully registered the user.";

            }

        }else{
            $response['status']=401;
            $errors[]="Unauthorized access. Celesta ID or access token doesn't match.";
        } // End of else part of user authentication.
    }else{
        $response['status']=404;
        $errors[]="Event not found.";
    } // End of checking if event exists or not

    $response['message']=$errors;
    echo json_encode($response);
}

// To check if a person has already registered or not
function alreadyRegistered($celestaid,$regis){
    foreach($regis as $reg){
        $value[]=$reg ->celestaid;
    }
    foreach($value as $id){
        if($id==$celestaid){
            return true;
        }
    }
    return false;
}