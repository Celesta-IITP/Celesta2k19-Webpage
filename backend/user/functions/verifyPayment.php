<?php
    include("./functions.php");
    // echo "1";
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        // echo"2";
        if(isset($_GET["atm"]) && isset($_GET["access_token"]) && isset($_GET["celestaid"])){
            // echo "3";
            $response=array();
            $message = array();

            $celestaid=clean($_GET["celestaid"]);
            $access_token=clean($_GET["access_token"]);
            $atm=clean($_GET["atm"]);
            $ev_amount=clean($_GET["ev_amount"]);
            $ev_id=clean($_GET["ev_id"]);
            $order_status=clean($_GET["order_status"]);

            $user_data=getUserDetails($celestaid,$access_token);
            $ev_data=getEventsDetails($ev_id);

            if($user_data==false){
                $response['status']=401;
                $message[]="Unauthorized access";
            }else{
                if($ev_data==false){
                    $response['status']=204;
                    $message[]="Event not found";
                }else{
                    if($ev_data["is_team_event"]==0){
                        updateSingleEvent($celestaid,$user_data,$ev_data,$ev_id,$ev_amount);
                    }else{
                        updateTeamEvent();
                    }
                }
            }
        }
    }

/******************************************** Update Details of Single user team ************************************/

    // Function to update single member events
    function updateSingleEvent($celestaid,$user_data,$ev_data,$ev_id,$paid_amount){
        updateUser($celestaid,$paid_amount,$ev_id,$user_data);

        updateSingleEventTable($celestaid,$paid_amount,$ev_id,$ev_data);

        $qrcode=$user_data['qrcode'];
        $subject="Celesta Events Payment";
        $ev_name=$ev_data['ev_name'];
        $email=$user_data["email"];
        $msg="<p>
            Your Celesta Id is ".$celestaid.".<br>
            You have successfully paid for $ev_name.<br>
            Amount paid is: Rs. $paid_amount<br>
            You qr code is <img src='$qrcode'/> <a href='$qrcode'>click here</a><br/>
            </p>
        ";
        $header="From: celesta19@gmail.com";
        send_email($email,$subject,$msg,$header);

    }

    function updateSingleEventTable($celestaid,$paid_amount,$ev_id,$ev_data){
        $ev_registrations=json_decode($ev_data["ev_registrations"]);
        $regis=array();

        foreach($ev_registrations as $regs){
            $get_celestaid=$regs->celestaid;
            $amount=$regs->amount;
            $name=$regs->name;
            $phone=$regs->phone;
            $time=$regs->time;

            $reg=array();
            $reg["celestaid"]=$get_celestaid;
            $reg["name"]=$name;
            $reg["phone"]=$phone;
            $reg['amount']=$amount;
            $reg["time"]=$time;

            if($get_celestaid==$celestaid){
                $reg['amount']=$paid_amount;
            }
            $regis[]=$reg;
        }
        $regis=json_encode($regis);

        $sql="UPDATE events SET ev_registrations='$ev_registrations' WHERE ev_id='$ev_id'";
        $result=query($sql);
        confirm($result);
    }

    function updateUser($celestaid,$paid_amount,$ev_id,$user_data){
        $events_registered=json_decode($user_data["events_registered"]);
        $email=$user_data["email"];
        $events=array();
        foreach($events_registered as $event){
			$evs_id=$event->ev_id;
			$amount=$event ->amount;
			$ev_name=$event ->ev_name;
			$team_name=$event ->team_name;
			$cap_name=$event ->cap_name;

            $add_event=array();
            $add_event["ev_id"]=$evs_id;
            $add_event["ev_name"]=$ev_name;
            $add_event["amount"]=$amount;

            if(!empty($team_name)){
                $add_event["team_name"]=$team_name;
                $add_event["cap_name"]=$cap_name;
            }

            if($evs_id==$ev_id){
                $add_event["amount"]=$paid_amount;
            }
            $events[]=$add_event;
        }
        $events=json_encode($events);
        $sql="UPDATE  users set events_registered='$events' WHERE celestaid='$celestaid'";
        $result=query($sql);
        confirm($result);
    }

    /******************************************** End of Update Details of Single user team ************************************/

    function getUserDetails($celestaid, $access_token){
        $sql="SELECT * FROM users WHERE celestaid='$celestaid' and access_token='$access_token'";
        $result=query($sql);
        if(row_count($result)==1){
            $row=fetch_array($result);
            return $row;
        }else{
            return false;
        }
    }

    function getEventsDetails($ev_id){
        $sql="SELECT id, ev_registrations, ev_amount, is_team_event, ev_name FROM events WHERE ev_id='$ev_id'";
        $result=query($sql);
        if(row_count($result)==1){
            $row=fetch_array($result);
            return $row;
        }else{
            return false;
        }
    }