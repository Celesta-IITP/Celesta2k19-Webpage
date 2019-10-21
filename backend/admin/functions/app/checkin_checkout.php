<?php
include('./../init.php');

$response=array();
$message=array();
$toadd=array();
$last_row=array();
$checkin_checkout=array();
$action="";

if($_SERVER['REQUEST_METHOD']=='POST'){
    $celestaid=clean($_POST['celestaid']);
    $date_time=clean($_POST['date_time']);
    $access_token=clean($_POST['access_token']);
    $permit=clean($_POST['permit']);

    $sql2="SELECT id FROM admins where access_token='$access_token' and permit=$permit";
    $result2=query($sql2);
    if(row_count($result2)!=1){
        $response['status']='401';
        $message[]="Unauthorized to access this feature.";
    }else{
        $sql="SELECT checkin_checkout, registration_desk FROM users WHERE celestaid='$celestaid' and active=1";
        $result=query($sql);

        if(row_count($result)==1){
            $row=fetch_array($result);
            $registration_desk=$row['registration_desk'];
            if($registration_desk!=1){
                $response['status']='203';
                $message[]="Account has not verified at registration desk.";
            }else{
                $checkin_checkout=json_decode($row['checkin_checkout']);
                if(!empty($checkin_checkout)){
                    $reverse_data=$checkin_checkout;
                    $last_row=end($reverse_data);

                    //If user have just checked in, he needs to be checked out
                    if($last_row[0]=="checkin"){
                        $toadd[]="checkout";
                        $toadd[]=$date_time;
                        $checkin_checkout[]=$toadd;
                        
                        $checkin_checkout=json_encode($checkin_checkout);
                        $sql2="UPDATE users SET checkin_checkout='$checkin_checkout' WHERE celestaid='$celestaid'";
                        $result2=query($sql2);
                        $response['status']='200';
                        $message[]="Successfully checked out.";
                        $action="Checked Out";
                        
                    }//Check in user if his last state is checked in
                    else{
                        $toadd[]="checkin";
                        $toadd[]=$date_time;
                        $checkin_checkout[]=$toadd;
                        $checkin_checkout=json_encode($checkin_checkout);
                        $sql3="UPDATE users SET checkin_checkout='$checkin_checkout' WHERE celestaid='$celestaid'";
                        $result3=query($sql3);
                        // confirm($result1);
                        $response['status']='200';
                        $message[]="Successfully checked in.";
                        $action="Checked In";
                    }

                }else{
                    $toadd=array();
                    $toadd[]="checkin";
                    $toadd[]=$date_time;
                    $checkin_checkout[]=$toadd;
                    $checkin_checkout=json_encode($checkin_checkout);
                    $sql1="UPDATE users SET checkin_checkout='$checkin_checkout' WHERE celestaid='$celestaid'";
                    $result1=query($sql1);
                    $response['status']='200';
                    $message[]="Successfully checked in.";
                    $action="Checked In";
                }
                $message[]=$last_row;
            }//End of main working part

        }else{
            $response['status']='404';
            $message[]="Celestaid not found.";
        }

    }

 
    $response['message']=$message;
    $response['action']=$action;
    echo json_encode($response);
}//Ending of if part of post method
