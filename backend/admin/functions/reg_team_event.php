<?php
include('./init.php');

if($_SERVER['REQUEST_METHOD']=="GET"){
    
    $errors=array();
    $response=array();
    
    // Execute 
    $eventid=clean($_GET["eventid"]);
    $celestaid=clean($_GET["celestaid"]);
    $access_token=clean($_GET["access_token"]);
    $member1=clean($_GET["member1"]);
    $member2=clean($_GET["member2"]);
    $member3=clean($_GET["member3"]);
    $member4=clean($_GET["member4"]);
    $team_name=clean($_GET['team_name']);
    $members=array($celestaid, $member1, $member2,$member3,$member4);

    if(verifyCaptain($celestaid,$access_token)){

        if(!isTeamEventExist($eventid)){
            $errors[]="Event doesn't exist.";
            $response['status']=404;
        }else{

            $sql10 = "SELECT ev_registrations, ev_name FROM events WHERE ev_id='$eventid'";
            $result10=query($sql10);
            $row10=fetch_array($result10);
            $ev_name=$row10['ev_name'];
            $regis=json_decode($row10['ev_registrations']);
            foreach($members as $memb){
                if(!validCelestaId($memb)){
                    $errors[]="$memb celesta id is incorrect. Please entry correct details and try again.";
                    $response['status']=404;
                }
                if(idAlreadyRegistered($memb,$regis)){
                    $errors[]="$memb have Already registered for this event.";
                    $response['status']=302;
                }
            }
        }

        if(!empty($errors)){

            $response['message']=$errors;
            // echo json_encode($response);
        }else{



            /** Fetch details of all the members */
            $mem_emails=array();
            $mem_name=array();
            $mem_phone=array();
            foreach($members as $mem){
                $sql="SELECT first_name, last_name, phone, email from users WHERE celestaid='$mem'";
                $result=query($sql);
                $row=fetch_array($result);
                $name=$row['first_name']." ".$row['last_name'];
                $email=$row['email'];
                $phone=$row['phone'];
                
                array_push($mem_emails,$email);
                array_push($mem_name,$name);
                array_push($mem_phone,$phone);
            }

            /**  Things to be implemented
             * 1. Enter the data into the ev_registrations column of events table.
             * 2. Update the event registration in the user table corresponding to that user
             * 3. Update the data in the present users table events_registered column
             */

            // Updating the data into the events table.
            $reg=array();
            $reg["cap_celestaid"]=$members[0];
            $reg["cap_name"]=$mem_name[0];
            $reg["cap_phone"]=$mem_phone[0];

            $reg['mem1_celestaid']=$members[1];
            $reg['mem1_name']=$mem_name[1];
            $reg['mem1_email']=$mem_emails[1];
            $reg['mem1_phone']=$mem_phone[1];

            $reg['mem2_celestaid']=$members[2];
            $reg['mem2_name']=$mem_name[2];
            $reg['mem2_email']=$mem_emails[2];
            $reg['mem2_phone']=$mem_phone[2];

            $reg['mem3_celestaid']=$members[3];
            $reg['mem3_name']=$mem_name[3];
            $reg['mem3_email']=$mem_emails[3];
            $reg['mem3_phone']=$mem_phone[3];

            $reg['mem4_celestaid']=$members[4];
            $reg['mem4_name']=$mem_name[4];
            $reg['mem4_email']=$mem_emails[4];
            $reg['mem4_phone']=$mem_phone[4];

            $reg['amount']=0;
            $reg["time"]=date('Y-m-d H:i:s');
            $regis[]=$reg;
            $regis=json_encode($regis);
            $sql2="UPDATE events SET ev_registrations='$regis' WHERE ev_id='$eventid'";
            $result2=query($sql2);

            // Updating the data into the user table.
            foreach($members as $mem){
                $sql = "SELECT events_registered from users WHERE celestaid='$mem'";
                $ev_registered=json_decode($row["events_registered"]);
                $add_event=array();
                $add_event["cap_name"]=$mem_name[0];
                $add_event["team_name"]=$team_name;
                $add_event["ev_name"]=$ev_name;
                $add_event["ev_id"]=$eventid;
                $add_event["amount"]=0;
                $ev_registered[]=$add_event;
                $ev_registered=json_encode($ev_registered);
                $sql3="UPDATE users SET events_registered='$ev_registered' WHERE celestaid='$mem'";
                $result3=query($sql3);
            }
            

            // Update the data in the present users table events_registered columnr
            foreach($members as $mem){
                $sql4="SELECT * FROM present_users WHERE celestaid='$mem'";
                $result4=query($sql4);
                if(row_count($result4)==1){
                    
                    $row=fetch_array($result4);
                    $ev_registered=json_decode($row["events_registered"]);
                    $add_event=array();
                    $add_event["cap_name"]=$mem_name[0];
                    $add_event["team_name"]=$team_name;
                    $add_event["ev_name"]=$ev_name;
                    $add_event["ev_id"]=$eventid;
                    $add_event["amount"]=0;
                    $ev_registered[]=$add_event;
                    $ev_registered=json_encode($ev_registered);


                    $sql5="UPDATE present_users SET events_registered='$ev_registered' WHERE celestaid='$celestaid'";
                    $result5=query($sql5);
                }

            }

            $subject="Celesta2k19 Events Registration";

            $header="From: noreply@yourwebsite.com";
            $count=0;
            foreach($members as $mem){
                $msg="<p>
                Hi $mem_name[$count], you have successfully registered for $ev_name. Team captain is $mem_name[0] <br/>
                    Your Celesta Id is: $mem <br/>
                    Thank you for registering the events. Keep visiting the website to stay updated.
                ";
                $email=$mem_emails[$count];
                $count+=1;
                send_email($email,$subject,$msg,$header);
            }


            $response['status']=202;
            $errors[]="Successfully registered your team.";
        }

    }else{
        $response['status']=401;
        $errors[]="Captain Unauthorized.";
    }
    $response['message']=$errors;
    echo json_encode($response);
}

function validCelestaId($celestaid){
    $sql="SELECT id FROM users WHERE celestaid='$celestaid' and active=1";
    $result=query($sql);
    if(row_count($result)==1){
        return true;
    }else{
        return false;
    }
}

function verifyCaptain($celestaid,$access_token){
    $sql="SELECT id FROM users WHERE celestaid='$celestaid' AND access_token='$access_token'";
    $result=query($sql);
    if(row_count($result)==1){
        return true;
    }else{
        return false;
    }
}

function isTeamEventExist($eventid){
    $sql="SELECT id from events where ev_id='$eventid' AND is_team_event=1";
    $result=query($sql);
    if(row_count($result)==1){
        return true;
    }else{
        return false;
    }
}

function idAlreadyRegistered($celestaid,$regis){
    foreach($regis as $reg){
        $value=array();
        $value[]=$reg ->cap_celestaid;
        $value[]=$reg ->mem1_celestaid;
        $value[]=$reg ->mem2_celestaid;
        $value[]=$reg ->mem3_celestaid;
        $value[]=$reg ->mem4_celestaid;
        foreach($value as $id){
            if($id==$celestaid){
                return true;
                break;
            }
        }
    }
    return false;
}