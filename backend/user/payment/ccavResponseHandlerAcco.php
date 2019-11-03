<?php include('Crypto.php')?>
<?php

	$workingKey='59AE7AF1F238451CEA2E2287BB113A94';		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];						//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	echo "<center>";

	for($i = 0; $i < $dataSize; $i++)
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==3){
			$order_status=urldecode($information[1]);
		}
		if($information[0]=="merchant_param1"){
			$celestaid=urldecode($information[1]);
		}
		if($information[0]=="merchant_param4"){
			$access_token=urldecode($information[1]);
		}
		if($information[0]=="merchant_param2"){
			$acco_amount=urldecode($information[1]);
		}
		if($information[0]=="billing_tel"){
			$phone=urldecode($information[1]);
		}
		if($information[0]=="billing_name"){
			$name=urldecode($information[1]);
		}

	}

	$base_url = "https://celesta.org.in/backend/user/functions/verifyPaymentAcco.php?celestaid=$celestaid&acco_amount=$acco_amount&access_token=$access_token";

	if($order_status==="Success")
	{
		// echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
		$url=$base_url."&order_status=$order_status&atm=love_u_atm";

	}
	else if($order_status==="Aborted")
	{
		$url=$base_url."&order_status=$order_status&atm=atm_abort_ho_gaya_payment";
		// echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";

	}
	else if($order_status==="Failure")
	{
		$url=$base_url."&order_status=$order_status&atm=atm_fail_ho_gaya_payment";
		// echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
	}
	else
	{
		$url=$base_url."&order_status=$order_status&atm=atm_illegal_access_hai_ye";

	}

	echo "<br><br>";

	// $sql="INSERT into celesta SET(celestaid, ev_id, amount, order_status,phone, name) VALUES('$celestaid','$ev_id',$ev_amount,'$order_status','$phone','$name') ";
	// $con =mysqli_connect('localhost','atm1504','11312113','celesta2k19');
	
	// $result=mysqli_query($con, $sql);
?>

<script type="text/javascript">
	location.replace("<?php echo $url?>")
</script>
	<?php
	echo "<table cellspacing=4 cellpadding=4>";
	for($i = 0; $i < $dataSize; $i++)
	{
		$information=explode('=',$decryptValues[$i]);
	    	echo '<tr><td>'.$information[0].'</td><td>'.urldecode($information[1]).'</td></tr>';
	}

	echo "</table><br>";
	echo "</center>";
?>
