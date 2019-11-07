<?php
include('./../init.php');

$response=array();
$message=array();

if($_SERVER['REQUEST_METHOD']=='POST'){
    $access_token=clean($_POST['access_token']);
    // $permit=clean($_POST['permit']);
    $celestaid=clean($_POST['celestaid']);
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
        if($permit==0 || $permit==4 || $permit==2 || $permit==5 || $permit==3){
            $sql="SELECT id, first_name, last_name, email, registration_desk, phone, college, amount_paid, iit_patna, accommodation_charge, events_registered FROM users WHERE celestaid='$celestaid'";
            $result=query($sql);
            if(row_count($result)==1){
                $row=fetch_array($result);

                $response['name']=$row['first_name']." ".$row['last_name'];
                $response['email']=$row['email'];
                $response['registration_desk']=$row['registration_desk'];
                $response['phone']=$row['phone'];
                $response['college']=$row['college'];
                $response['amount_paid']=$row['amount_paid'];
                $response['iit_patna']=$row['iit_patna'];
                $response['accommodation_charge']=$row['accommodation_charge'];
                $response['events_registered']=json_decode($row['events_registered']);

                $accommodation=0;

                // Check accommodation table
                // 0: Not registered for accommodation
                // 1: Accommodation booked and amount paid
                // 2: Accommodation booked but amount not paid
                $sql1="SELECT id, amount_paid FROM accommodation where celestaid='$celestaid'";
                $result1=query($sql1);
                if(row_count($result1)==1){
                    $row1=fetch_array($result1);
                    if($row1['amount_paid']==600){
                        $accommodation=1;
                    }else{
                        $accommodation=2;
                    }
                }
                $sql4="SELECT ev_id, ev_amount FROM events";
                $result4=query($sql4);
                $events=array();
                if ($result4->num_rows > 0) {
                    while($row4 = $result4->fetch_assoc()) {
                        $event=array();
                        $event['ev_id']=$row4['ev_id'];
                        $event['ev_amount']=$row4['ev_amount'];
                        $events[]=$event;
                    }
                }
                $response['events']=$events;

                $response['accommodation']=$accommodation;
                $response['status']=200;
                $message="Successfully sent the user details";
            }else{
                $response['status']=204;
                $message="User not found";
            }
        }else{
            $response['status']=401;
            $message="Admin unauthorized to perform this action.";
        }
    }
    $response['message']=$message;

    echo json_encode($response);
}//Ending of if part of post method
