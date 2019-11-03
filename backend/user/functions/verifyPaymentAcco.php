<?php
    include("./init.php");
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        if(isset($_GET["atm"]) && isset($_GET["access_token"]) && isset($_GET["celestaid"]) && isset($_GET["order_status"])){
            $response=array();
            $message = array();

            $celestaid=$_GET["celestaid"];
            $access_token=clean($_GET["access_token"]);
            $atm=clean($_GET["atm"]);
            $acco_amount=clean($_GET["acco_amount"]);
            $order_status=clean($_GET["order_status"]);

            $user_data=getUserDetails($celestaid);
            $acco_data=getAccoDetails($celestaid);

            if($user_data==false || $user_data["access_token"]!=$access_token){
                $response['status']=401;
                $message[]="Unauthorized access.";
            }else{
                if($order_status=="Success" && $atm="love_u_atm"){
                    updateUserAndAcco($celestaid,$acco_amount,$user_data);
                    $message[]="Payment Successfully Updated in the user data catalogue.";
                    $response["status"]=200;

                }elseif($order_status=="Aborted" && $atm="atm_abort_ho_gaya_payment"){
                    $message[]="Payment failed.";
                    $response["status"]=400;

                }elseif($order_status="Failure" && $atm="atm_fail_ho_gaya_payment"){
                    $message[]="Payment failed.";
                    $response["status"]=400;

                }else{
                    $message[]="Payment failed.";
                    $response["status"]=400;
                }
            }
            $message=implode(' ', $message);
            $response['message']=$message;
            $status=$response['status'];
            // redirect("./../profile.php?status=$status&msg=$message");
            echo json_encode($response);
        }
    }

    
    /********************************************** Utility Functions *********************************************************/
    function updateUserAndAcco($celestaid,$acco_amount,$user_data){
        $email=$user_data["email"];
        $amount_paid=$user_data["amount_paid"];
        $amount_paid+=$acco_amount;
        
        $sql="UPDATE users set accommodation_charge='$acco_amount', amount_paid=$amount_paid WHERE celestaid='$celestaid'";
        $result=query($sql);
        confirm($result);

        $sql="UPDATE accommodation set amount_paid='$acco_amount' WHERE celestaid='$celestaid'";
        $result1=query($sql);
        confirm($result1);

        $name= $user_data['first_name'];
        $qrcode= $user_data['qrcode'];
        $mssg="<p> Hi  $name, you have successfully paid accommodation price.<br>
            Your celestaid is:$celestaid<br>
            <a href='$qrcode'><img src='$qrcode' alt='Your qr code should be shown here.' style='height:400px;width:400px'/></a>
        </p>";
        $subject="Celesta2k19 Accommodation Payment";
        $headers="From: celesta19iitp@gmail.com";
        send_email($email,$subject,$mssg,$headers);
    }

    function getUserDetails($celestaid){
        $sql="SELECT * FROM users WHERE celestaid='$celestaid'";
        $result=query($sql);
        confirm($result);
        if(row_count($result)==1){
            $row=fetch_array($result);
            return $row;
        }else{
            return false;
        }
    }
?>