<?php
    include("./init.php");
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        if(isset($_GET["atm"]) && isset($_GET["access_token"]) && isset($_GET["celestaid"]) && isset($_GET["order_status"])){
            $response=array();
            $message = array();

            $celestaid=$_GET["celestaid"];
            $access_token=clean($_GET["access_token"]);
            $atm=clean($_GET["atm"]);
            $ev_amount=clean($_GET["ev_amount"]);
            $ev_id=clean($_GET["ev_id"]);
            $order_status=clean($_GET["order_status"]);

            $user_data=getUserDetails($celestaid);
            $ev_data=getEventsDetails($ev_id);

            if($user_data==false || $user_data["access_token"]!=$access_token){
                $response['status']=401;
                $message[]="Unauthorized access.";
            }else{
                if($ev_data==false){
                    $response['status']=204;
                    $message[]="Event not found.";
                }else{
                    if($order_status=="Success" && $atm="love_u_atm"){
                        if($ev_data["is_team_event"]==0){
                            updateSingleEvent($celestaid,$user_data,$ev_data,$ev_id,$ev_amount);
                            $message[]="Payment Successfully Updated in the user data catalogue.";
                            $response["status"]=200;
                        }else{
                            updateTeamEvent($celestaid,$ev_data,$ev_id,$ev_amount);
                            $message[]="Payment Successfully Updated in the user data catalogue.";
                            $response["status"]=200;
                        }

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
            }
            $response['message']=$message;
            $message=implode(' ', $message);
            $status=$response['status'];
            redirect("./../profile.php?status=$status&msg=$message");
            // echo json_encode($response);
        }
    }

/******************************************** Update Details of Multiple User Team ***********************************/
    function updateTeamEvent($celestaid,$ev_data,$ev_id,$paid_amount){
        $ev_registrations=json_decode($ev_data["ev_registrations"]);

        $subject="Celesta Event Registrations Payment";
        $header="From: celesta19@gmail.com";
        $ev_name=$ev_data['ev_name'];

        $regis=array();
        foreach($ev_registrations as $reg){
            $time=$reg->time;
			$amount=$reg->amount;
			$cap_name=$reg->cap_name;
			$cap_phone=$reg->cap_phone;
			$cap_celestaid=$reg->cap_celestaid;
			$team_name=$reg->team_name;
			$cap_email=$reg->cap_email;

			$mem1_name=$reg->mem1_name;
			$mem1_email=$reg->mem1_email;
			$mem1_phone=$reg->mem1_phone;
			$mem1_celestaid=$reg->mem1_celestaid;

			$mem2_name=$reg->mem2_name;
			$mem2_email=$reg->mem2_email;
			$mem2_phone=$reg->mem2_phone;
			$mem2_celestaid=$reg->mem2_celestaid;

			$mem3_name=$reg->mem3_name;
			$mem3_email=$reg->mem3_email;
			$mem3_phone=$reg->mem3_phone;
			$mem3_celestaid=$reg->mem3_celestaid;

			$mem4_name=$reg->mem4_name;
			$mem4_email=$reg->mem4_email;
			$mem4_phone=$reg->mem4_phone;
			$mem4_celestaid=$reg->mem4_celestaid;

			$mem5_name=$reg->mem5_name;
			$mem5_email=$reg->mem5_email;
			$mem5_phone=$reg->mem5_phone;
			$mem5_celestaid=$reg->mem5_celestaid;

            $mem_celestaid=array();
            $mem_email=array();

            // Updating datas
            $updt=array();
			$updt['cap_name']=$cap_name;
			$updt['time']=$time;
			$updt['amount']=$amount;
			$updt['cap_celestaid']=$cap_celestaid;
			$updt['team_name']=$team_name;
			$updt['cap_phone']=$cap_phone;
			$updt['cap_email']=$cap_email;

            $mem_celestaid[]=$cap_celestaid;
            $mem_email[]=$cap_email;

			if(!empty($mem1_celestaid)){
				$updt['mem1_name']=$mem1_name;
				$updt['mem1_email']=$mem1_email;
				$updt['mem1_celestaid']=$mem1_celestaid;
				$updt['mem1_phone']=$mem1_phone;
                $mem_celestaid[]=$mem1_celestaid;
                $mem_email[]=$mem1_email;
			}

			if(!empty($mem2_celestaid)){
				$updt['mem2_name']=$mem2_name;
				$updt['mem2_email']=$mem2_email;
				$updt['mem2_celestaid']=$mem2_celestaid;
				$updt['mem2_phone']=$mem2_phone;
                $mem_celestaid[]=$mem2_celestaid;
                $mem_email[]=$mem2_email;
			}

			if(!empty($mem3_celestaid)){
				$updt['mem3_name']=$mem3_name;
				$updt['mem3_email']=$mem3_email;
				$updt['mem3_celestaid']=$mem3_celestaid;
				$updt['mem3_phone']=$mem3_phone;
                $mem_celestaid[]=$mem3_celestaid;
                $mem_email[]=$mem3_email;
			}

			if(!empty($mem4_celestaid)){
				$updt['mem4_name']=$mem4_name;
				$updt['mem4_email']=$mem4_email;
				$updt['mem4_celestaid']=$mem4_celestaid;
				$updt['mem4_phone']=$mem4_phone;
                $mem_celestaid[]=$mem4_celestaid;
                $mem_email[]=$mem4_email;
			}

			if(!empty($mem5_celestaid)){
				$updt['mem5_name']=$mem5_name;
				$updt['mem5_email']=$mem5_email;
				$updt['mem5_celestaid']=$mem5_celestaid;
				$updt['mem5_phone']=$mem5_phone;
                $mem_celestaid[]=$mem5_celestaid;
                $mem_email[]=$mem5_email;
            }

            if(in_array($celestaid,$mem_celestaid)){
                $updt['amount']=$paid_amount;
				foreach($mem_celestaid as $clst){
                    $user_data=getUserDetails($clst);
                    updateUser($clst,$paid_amount,$ev_id,$user_data);
                    $msg="<p>
                        Your Celesta Id is ".$clst.". You have successfully paid for <b> $ev_id - $ev_name </b>.
                        <br>
                        Amount paid is: $paid_amount<br>
                        Paid By: $celestaid<br>
                        </p>
                    ";
                    send_email($user_data['email'],$subject,$msg,$header);
				}
            }
            $regis[]=$updt;
        }
        $regis=json_encode($regis);
        $sql="UPDATE events set ev_registrations='$regis' WHERE ev_id='$ev_id'";
        $result=query($sql);
        confirm($result);
    }

/******************************************** Update Details of Single user team ************************************/

    // Function to update single member events
    function updateSingleEvent($celestaid,$user_data,$ev_data,$ev_id,$paid_amount){
        updateUser($celestaid,$paid_amount,$ev_id,$user_data,$ev_data['ev_name']);

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
            $reg["time"]=$time;

            if($get_celestaid==$celestaid){
                $reg['amount']=$paid_amount;
            }else{
                $reg['amount']=$amount;
            }
            $regis[]=$reg;
        }
        $regis=json_encode($regis);

        $sql="UPDATE events SET ev_registrations='$regis' WHERE ev_id='$ev_id'";
        $result=query($sql);
        confirm($result);
    }

    /******************************************** End of Update Details of Single user team ************************************/

    /********************************************** Utility Functions *********************************************************/
    function updateUser($celestaid,$paid_amount,$ev_id,$user_data){
        $events_registered=json_decode($user_data["events_registered"]);
        $email=$user_data["email"];
        $events_charge=$user_data["events_charge"];
        $amount_paid=$user_data["amount_paid"];
        $events_charge+=$paid_amount;
        $amount_paid+=$paid_amount;

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
            
            if(!empty($team_name)){
                $add_event["team_name"]=$team_name;
                $add_event["cap_name"]=$cap_name;
            }

            if($evs_id==$ev_id){
                $add_event["amount"]=$paid_amount;
            }else{
                $add_event["amount"]=$amount;
            }
            $events[]=$add_event;
        }
        $events=json_encode($events);
        $sql="UPDATE  users set events_registered='$events', events_charge=$events_charge, amount_paid=$amount_paid WHERE celestaid='$celestaid'";
        $result=query($sql);

        confirm($result);
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
?>