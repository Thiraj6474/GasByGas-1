<?php

session_start();
header("Content-Type: application/json; charset=UTF-8");
$username= $_SESSION['custUser'];
$user_id= $_SESSION['user_id'];
require_once ('container/dbqueries.php');
$obj = new GasDelivery;
//Here create the operation to check for the transaction
$payment = $obj->get_payment($_POST['payment_id']);

if($payment){
	//Here Make sure to send the verification request

	$file = "payment.ini";
	if (!$settings = @parse_ini_file( dirname(__FILE__) . '/' .$file, TRUE)){
		echo json_encode(["success" => false, "message" => 'Unable to open '. dirname(__FILE__) . '/' . $file . '.']);
		exit();
		// throw new exception(  );
	}

	$data = [];


	$url = $settings['payment']['end_point_check']."/".$payment['reference'];    
    $data = http_build_query ($data);
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $data);

    // $result = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // $result;
    curl_close($ch);

    // var_dump($result);
    $response = json_decode($result);

    // var_dump($response);
    if($httpcode == 200 && is_object($response)){
    	//Now Update the Payment for later reference
    	// $sql = "UPDATE payments SET status = ? WHERE payment_id = ?";
    	$obj->update_payment($_POST['payment_id'], $response->data->status);

    	if($response->data->status == "SUCCESS"){
    		//Here Make sure to update the 
    		$obj->update_gas_store($payment['gas_store_id']); //Here the status id PAID
    	}
    	echo json_encode(["success" => true, "message" => "Paid Found", "status" => $response->data->status]);
		exit();
    } else {
    	echo json_encode(["success" => false, "message" => "Error found"]);
		exit();
    }

} else {
	echo json_encode(["success" => false, "message" => "Not Found"]);
	exit();
}


