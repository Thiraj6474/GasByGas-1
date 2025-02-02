<?php
include ('connection.php');

class GasDelivery {

	// public $con;
	// public function __construct(){
	// 	$obj = new DatabaseConn;
	// 	// $obj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// 	$this->con= $obj->connection();
	// }


	public $con;
	public function __construct(){
    $obj = new DatabaseConn;
    $obj->connect(); 
    $this->con = $obj->conn; 
}



	// Reg Admin...
	public function register_station_manager($uname, $email, $phone, $pass) {
		$sql = "INSERT INTO station_manager (username, email, password, phone_number) 
        VALUES ('$uname', '$email', '$pass', '$phone')";
		$query= $this->con->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count;
	}


	// Customer
	public function register_customer_self($names, $uname, $phone, $address, $pin) {
		$sql = "INSERT INTO customers (cust_names, username, phone_number,address, pin_number) 
        VALUES ('$names', '$uname', '$phone', '$address', '$pin')";
		$query= $this->con->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count;
	}

	// Login
	public function manager_login() {
		$sql = "SELECT * FROM station_manager WHERE email = '".$_POST['email']."' AND password = '".$_POST['password']."'";
		$stmt=$this->con->prepare($sql);
		$stmt->execute();
		return $stmt;
	}


	// Agent Login
	public function agent_login() {
		$sql= "SELECT * FROM station_agent WHERE username='".$_POST['username']."' AND password='".$_POST['password']."' ";
		$stmt=$this->con->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	// Customer
	public function customer_login() {
		$sql= "SELECT * FROM customers WHERE phone_number='".$_POST['phone_number']."' AND pin_number='".$_POST['pin_number']."' ";
		$stmt=$this->con->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public function agent_logout() {
		session_destroy();
		return header("Location:stationlogin.php?agent");
	}

	public function customer_logout() {
		session_destroy();
		return header("Location:stationlogin.php?cust");
	}

	public function manager_logout() {
		session_destroy();
		return header("Location:stationlogin.php?manager");
	}





	// Customer...


	public function register_agent($names, $uname, $phone, $address, $pass) {
		$sql = "INSERT INTO station_agent (agent_names, username, phone_number, address, password) 
        VALUES ('$names', '$uname', '$phone', '$address', '$pass')";
		$query= $this->con->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count;
	}


	public function view_agents() {
		$query= $this->con->prepare("SELECT * FROM station_agent ");
		$query->execute();
		return $query;
	}

	public function read_one_agent($id) {
		$query= $this->con->prepare("SELECT * FROM station_agent WHERE agent_id='$id' ");
		$query->execute();
		return $query;
	}

	public function delete_agent($id) {
		$query= $this->con->prepare("DELETE FROM station_agent WHERE agent_id='".$id."' ");
		$query->execute();
		return $query;	
	}

	public function disable_agent($id) {
		$sql = "UPDATE station_agent SET status='0' WHERE agent_id='".$id."' ";
		$query= $this->con->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count;
	}

	public function enable_agent($id) {
		$sql = "UPDATE station_agent SET status='1' WHERE agent_id='".$id."' ";
		$query= $this->con->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count;
	}

	public function check_for_disabled_agent($id) {
		$sql= "SELECT COUNT(*) FROM station_agent WHERE agent_id='$id' ";
		$stmt=$this->con->query($sql)->fetchColumn();
		return $stmt;		
	}







	// Customer
	public function register_customer($names, $uname, $phone, $address) {
		$sql = "INSERT INTO customers (cust_names, username, phone_number, address, pin_number) 
        VALUES ('$names', '$uname', '$phone', '$address', '".rand(1000, 9999)."')";
		$query= $this->con->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count;
	}

	public function update_customer($names, $uname, $phone, $address, $id) {
		$sql = "UPDATE customers 
        SET cust_names = '$names', username = '$uname', phone_number = '$phone', address = '$address' 
        WHERE cust_id = '$id'";
		$query= $this->con->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count;
	}

	public function view_customers() {
		$query= $this->con->prepare("SELECT * FROM customers ORDER BY cust_id DESC ");
		$query->execute();
		return $query;
	}

	public function view_cust_details($id) {
		$query= $this->con->prepare("SELECT * FROM customers WHERE cust_id ='$id' ");
		$query->execute();
		return $query;
	}


	public function view_customer_pendingrq($id) {
		$query= $this->con->prepare("SELECT a.*,
											b.reference,
											b.status AS transaction_status,
											b.payment_id AS payment_id
											FROM gas_store AS a 
											LEFT JOIN payments AS b
											ON a.g_id = b.gas_store_id
											WHERE a.status='Unpaid' AND a.cust_id=?
											");
		$query->execute([$id]);
		return $query;
	}


	public function view_customer_paidreq($id) {
		$query= $this->con->prepare("SELECT * FROM gas_store WHERE status='Paid' AND cust_id='$id' ");
		$query->execute();
		return $query;
	}

	public function read_one_customer($id) {
		$query= $this->con->prepare("SELECT * FROM customers WHERE cust_id='$id' ");
		$query->execute();
		return $query;
	}

	public function delete_customer($id) {
		$query= $this->con->prepare("DELETE FROM customers WHERE cust_id='$id' ");
		 $query->execute();
		return $query;		
	}

	public function submit_gas($quantity, $comment, $cid, $aid) {
		$sql = "INSERT INTO gas_store (gas_quantity, comment, cust_id, agent_id, status, date_submitted) 
        VALUES ('$quantity', '$comment', '$cid', '$aid', 'Unpaid', GETDATE())";
		$query= $this->con->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count;
	}

	public function get_gas_store($id){
		$query= $this->con->prepare("SELECT * FROM gas_store WHERE g_id=? ");
		$query->execute([$id]);
		return $query->fetch(PDO::FETCH_ASSOC);
	}

	public function delete_old_payment($gas_store_id){
		try{
			$query = $this->con->prepare("DELETE FROM payments WHERE gas_store_id = ?");
			$query->execute([$gas_store_id]);
		} catch(\Exception $e){
			// var_dump($params);
			throw new Exception($e->getMessage(), 1);
			
		}
		return true;
	}

	public function view_gas() {
		$query= $this->con->prepare("SELECT * FROM gas_store ");
		$query->execute();
		return $query;
	}

	public function view_gas_by_agent($id) {
		$query= $this->con->prepare("SELECT * FROM gas_store WHERE agent_id='$id' ");
		$query->execute();
		return $query;
	}

	public function count_gas_in_storeby_agent($id) {
		$stmt=$this->con->query("SELECT COUNT(*) FROM gas_store WHERE agent_id='$id'")->fetchColumn();
		return $stmt;
	}


	public function get_gas_quantity_by_agent($id) {
		$query= $this->con->prepare("SELECT SUM(gas_quantity) AS total FROM gas_store WHERE agent_id='$id' ");
		$query->execute();
		return $query;
	}



	// Overview
	public function count_customers() {
		$stmt=$this->con->query("SELECT COUNT(*) FROM customers ")->fetchColumn();
		return $stmt;		
	}

	public function count_agents_nocond() {
		$stmt=$this->con->query("SELECT COUNT(*) FROM station_agent ")->fetchColumn();
		return $stmt;		
	}

	public function count_agents($id) {
		$stmt=$this->con->query("SELECT COUNT(*) FROM station_agent WHERE agent_id='$id' ")->fetchColumn();
		return $stmt;		
	}


	public function count_submittedgas_nocond() {
		$stmt=$this->con->query("SELECT COUNT(*) FROM gas_store ")->fetchColumn();
		return $stmt;		
	}

	public function count_paidgas_nocond() {
		$stmt=$this->con->query("SELECT COUNT(*) FROM gas_store WHERE status='Paid' ")->fetchColumn();
		return $stmt;		
	}


	public function count_submitted_gas($id) {
		$stmt=$this->con->query("SELECT COUNT(*) FROM gas_store WHERE agent_id='$id' ")->fetchColumn();
		return $stmt;		
	}














	// Finals **************************************************

	public function gas_submission_send_sms($agentPhone, $agentNames, $agentComment, $gasqty, $recipUname, $recipPhone) {

        $data = array(    
            "sender"=>'KIGALIGAS',
            "recipients"=>$recipPhone,
            "message"=>"Muraho neza gas yanyu y'ibiro ".$gasqty." yabitswe na ".$agentNames." (".$agentComment.") Murakoze! ",   
        );

        $url = "https://www.intouchsms.co.rw/api/sendsms/.json";    
        $data = http_build_query ($data);
        $username="benii"; 
        $password="Ben@1234";
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password);  
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // $result;
        curl_close($ch);
        // return $successmsg = "Message yoherejwe";
	}



	public function count_customer_pendingrq($id) {
		$stmt=$this->con->query("SELECT COUNT(*) FROM gas_store WHERE status='Unpaid' AND cust_id='$id'")->fetchColumn();
		return $stmt;
	}

	public function count_customer_paidrq($id) {
		$stmt=$this->con->query("SELECT COUNT(*) FROM gas_store WHERE status='Paid' AND cust_id='$id'")->fetchColumn();
		return $stmt;
	}

	public function customer_keeping_payment($id, $cid) {
		$sql = "UPDATE gas_store SET status='Paid' WHERE g_id='".$id."' AND cust_id='".$cid."' ";
		$query= $this->con->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count;
	}


	public function update_customer_balance($balance2charge, $cid, $recipPhone) {

		$data = array(    
            "sender"=>'KIGALIGAS',
            "recipients"=>$recipPhone,
            "message"=>"Mwishyuye neza kuri KIGALIGAS 2000 rwf,  Musigaranye (".$balance2charge." rwf), Murakoze!"   
        );

        $url = "https://www.intouchsms.co.rw/api/sendsms/.json";    
        $data = http_build_query ($data);
        $username="benii"; 
        $password="Ben@1234";
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password);  
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // $result;
        curl_close($ch);
        // return $successmsg = "Message yoherejwe";


		$sql = "UPDATE customers SET balance='".$balance2charge."' WHERE cust_id='".$cid."' ";
		$query= $this->con->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count;
	}


	public function make_full_payments($amount, $cust, $agent_id, $gas_id=NULL, $reference=null, $status="PENDING") {

		
		$sql = "INSERT INTO payments SET cust_id = ?, gas_store_id = ?, amount = ?, agent_id = ?, payment_date = ?, reference = ?, status = ?";
		$query= $this->con->prepare($sql);
		$query->execute([
			$cust,
			$gas_id,
			$amount,
			$agent_id,
			(new DateTime())->format('Y-m-d H:i:s'),
			$reference,
			$status
		]);
		$count= $query->rowCount();
		return $count;		
	} 

	public function get_payment($id){
		$query= $this->con->prepare("SELECT * FROM payments WHERE payment_id=? ");
		$query->execute([$id]);
		return $query->fetch(PDO::FETCH_ASSOC);
	}

	public function update_payment($id, $status){
		try{
			$query = $this->con->prepare("UPDATE payments SET status = ? WHERE payment_id = ?");
			$query->execute([$status, $id]);
		} catch(\Exception $e){
			// var_dump($params);
			throw new Exception($e->getMessage(), 1);
			
		}
		return true;
	}

	public function update_gas_store($id, $status="Paid"){
		try{
			$query = $this->con->prepare("UPDATE gas_store SET status = ? WHERE g_id = ?");
			$query->execute([$status, $id]);
		} catch(\Exception $e){
			// var_dump($params);
			throw new Exception($e->getMessage(), 1);
			
		}
		return true;
	}

	public function view_customer_payments($id) {
		$query= $this->con->prepare("SELECT * FROM payments WHERE agent_id='$id' ");
		$query->execute();
		return $query;
	}

	public function get_payment_total_byagent($id) {
		$query= $this->con->prepare("SELECT SUM(amount) AS amountTotal FROM payments WHERE agent_id='$id' ");
		$query->execute();
		return $query;
	}
	// ***********************************************************

}
?>