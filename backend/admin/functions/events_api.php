<?php
/*******************Useful Functions*****************/
include('./init.php');

// Cleans the string from unwanted html symbols

$sql="SELECT id, ev_id, ev_category, ev_name, ev_description, ev_organiser, ev_club, ev_org_phone, ev_poster_url, ev_rule_book_url, ev_date, ev_start_time, ev_end_time, ev_venue, ev_amount,is_team_event FROM events";
$result=query($sql);

$events=array();
$event=[];
while ($row = $result->fetch_assoc()) {
    $events[]=$row;
}

print_r(json_encode($events));