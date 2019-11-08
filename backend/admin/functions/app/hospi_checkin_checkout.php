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
    // $permit=clean($_POST['permit']);
    $admin=clean($_POST['email']);

    $sql2="SELECT id,permit FROM admins where access_token='$access_token' and email='$admin'";
    $result2=query($sql2);
    $row2=fetch_array($sql2);
    if(row_count($result2)!=1){
        $response['status']='401';
        $message[]="Invalid admin.";
    }else{
        $permit=$row2['permit'];
        if($permit==0 || $permit==2 || $permit==5){

            $sql="SELECT registration_desk, accommodation_charge FROM users WHERE celestaid='$celestaid' and active=1";
            $result=query($sql);

            if(row_count($result)==1){
                $row=fetch_array($result);
                $registration_desk=$row['registration_desk'];
                if($registration_desk!=1){
                    $response['status']='203';
                    $message[]="Account has not been verified at registration desk.";
                }elseif($row['accommodation_charge']==0){
                    $sql5="SELECT id, amount_paid from accommodation where celestaid='$celestaid'";
                    $result5=query($sql5);
                    if(row_count($result5)==1){
                        $response['status']='204';
                        $message[]="User has not payed accommodation fee. Please pay first.";
                    }else{
                        $response['status']='204';
                        $message[]="User has not booked accommodation.";
                    }
                }
                else{
                    $sql1="SELECT checkin_checkout from accommodation where celestaid='$celestaid'";
                    $result1=query($sql1);
                    $row1=query($result1);
                    $checkin_checkout=json_decode($row1['checkin_checkout']);
                    if(!empty($checkin_checkout)){
                        $reverse_data=$checkin_checkout;
                        $last_row=end($reverse_data);

                        //If user have just checked in, he needs to be checked out
                        if($last_row[0]=="checkin"){
                            $toadd[]="checkout";
                            $toadd[]=$date_time;
                            $checkin_checkout[]=$toadd;
                            
                            $checkin_checkout=json_encode($checkin_checkout);
                            $sql2="UPDATE accommodation SET checkin_checkout='$checkin_checkout' WHERE celestaid='$celestaid'";
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
                            $sql3="UPDATE accommodation SET checkin_checkout='$checkin_checkout' WHERE celestaid='$celestaid'";
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
                        $sql1="UPDATE accommodation SET checkin_checkout='$checkin_checkout' WHERE celestaid='$celestaid'";
                        $result1=query($sql1);
                        $response['status']='200';
                        $message[]="Successfully checked in.";
                        $action="Checked In";
                    }
                    $response['last_action']=$last_row;
                }//End of main working part


            }else{
                $response['status']='404';
                $message[]="Celestaid not found.";
            }
        }else{
            $response['status']='401';
            $message[]="Admin unauthorized to perform this action.";
        }
    }
 
    $response['message']=$message;
    $response['action']=$action;
    echo json_encode($response);
}//Ending of if part of post method
