<?php

$con =mysqli_connect('localhost','atm1504','1131211','celesta2k19');

//Count no of rows in the query result
function row_count($result){
	return mysqli_num_rows($result);
}



//Escape harmful codes that might get injected to database
function escape($string){
	global $con;
	return mysqli_real_escape_string($con,$string);
}

//Make query by calling this function and passing the query as the parameter
function query($query){
	global $con;
	return mysqli_query($con, $query);

}

//Function to fetch data
function fetch_array($result){
	global $con;
	return mysqli_fetch_array($result);
}

function debug_query($result){
	if(!result){
		return mysqli_error($con);
	}
}

//To check if query was succesfull or not
function confirm($result){
	global $con;
	if(!$result){
		die("QUERY FAILED". mysqli_error($con)."<br/>");
	}
}

?>