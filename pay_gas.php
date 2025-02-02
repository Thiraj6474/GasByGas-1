<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");
$username= $_SESSION['custUser'];
$user_id= $_SESSION['user_id'];
require_once ('container/dbqueries.php');
$obj = new GasDelivery;

// var_dump($_POST);
if(empty($_POST['request_id'])){
	echo json_encode(["success" => false, "message" => "No request to be paid"]);
	exit();
}
if(empty($_POST['phone_number'])){
	echo json_encode(["success" => false, "message" => "Please Provide phone number"]);
	exit();
}

if(!preg_match("/^07[2,3,8]{1}\d{7}$/", $_POST['phone_number']) ){
    echo json_encode(["success" => false, "message" => "Invalid Phone Number"]);
	exit();
}

//Here Add all required Paremeter to be used
$file = "payment.ini";
if (!$settings = @parse_ini_file( dirname(__FILE__) . '/' .$file, TRUE)){
	echo json_encode(["success" => false, "message" => 'Unable to open '. dirname(__FILE__) . '/' . $file . '.']);
	exit();
	// throw new exception(  );
}

$request = $obj->get_gas_store($_POST['request_id']);
// var_dump($request); die();
if($request){



// var_dump($settings);
	$phone = $_POST['phone_number'];
	$reference = substr($phone, -7).mt_rand(100, 999);
	$data = array(  
		"api_key" => $settings['payment']['api_key'],
		"api_secret" => $settings['payment']['api_secret'],
		"amount" => $settings['payment']['default_price'],
		"phone_number" => "250" . substr($phone, -9),
		"reference" => $reference,
    );

    $url = $settings['payment']['end_point'];    
    $data = http_build_query ($data);
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $data);

    $result = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // $result;
    curl_close($ch);

    // var_dump($result);
    $response = json_decode($result);

    // var_dump($response);
    if($httpcode == 200 && is_object($response)){
    	if(!$response->success){
    		echo json_encode(["success" => false, "message" => $response->message]);
			exit();
    	} else {
    		$obj->delete_old_payment($request['g_id']);
    		//Now make sure to register the payment operation

    		//Save the payment operation if possible
    		$data = $obj->make_full_payments(
    			$settings['payment']['default_price'], 
    			$request['cust_id'], 
    			$request['agent_id'], 
    			$request['g_id'], 
    			$response->reference,
    			$response->message
    		);
    		// var_dump($response);
    		if($data){
    			echo json_encode(["success" => true, "message" => "Please continue by allowing the payment on the phone. If the prompt fails to come out dial *182*7*1#", "reference"=>$response->reference]);
    		}
    	}
    }
} else {
	echo json_encode(["success" => false, "message" => "Invalid Request found"]);
	exit();
}