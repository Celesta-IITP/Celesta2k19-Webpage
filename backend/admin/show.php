<?php
include('functions/init.php');
$ev_id=clean($_GET["ev_id"]);

$sql= "SELECT ev_registrations FROM events where ev_id='$ev_id'";
// $sql= "SELECT ev_registrations FROM events where ev_id='ATM7680'";
$result=query($sql);
confirm($result);
$row=fetch_array($result);

print_r($row['ev_registrations']);
