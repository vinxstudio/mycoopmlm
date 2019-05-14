<?php

# i dunno if its used or not scripts
# so i'm just gonna change the dbname so that 
# no problem arises

# remove die if script will be used;

die();

ini_set('max_execution_time', 5000);

$servername = "marketingmycoop.cghlvb5xxt2e.us-east-1.rds.amazonaws.com";
$username = "mycoopuser";
$password = "1qaz45678";
$dbname = 'marketingmycoop';
#$dbname = "development_marketingmycoop";

//$servername = "localhost";
//$username = "root";
//$password = "";
//$dbname = "cpmpc_lite_backup";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

#UPDATE ACCOUNTS
$sql = "SELECT *, accounts.id as account_id FROM accounts 
		LEFT JOIN users ON users.id = accounts.user_id
		LEFT JOIN membership_settings ON membership_settings.id = users.member_type_id
		where users.member_type_id > 3 AND users.member_type_id < 7
		ORDER BY accounts.id ASC";

$getaccountresult = $conn->query($sql);

if ($getaccountresult->num_rows > 0) {
    // output data of each row
	while ($accountrow = $getaccountresult->fetch_assoc()) {
		$entry_fee = abs($accountrow['entry_fee']) * 2;
     	
     	#calculate earnings
		$total_earnings = getEarnings($accountrow['account_id'], $conn);

     	#convert CD to regular
		echo "<br>" . $total_earnings . " >= " . $entry_fee;

		if ($total_earnings >= $entry_fee) {
			convertCDToRegular($accountrow['user_id'], $accountrow['account_id'], $accountrow['sponsor_id'], $accountrow['member_type_id'], $conn);
		}

	}
}

function getEarnings($account_id, $conn)
{

	$sql = "SELECT sum(amount) as total_earnings FROM `earnings` WHERE `account_id`= {$account_id} and `source` IN('pairing','direct_referral')";

	$result = $conn->query($sql);
	$earnings = $result->fetch_assoc();

	return $earnings['total_earnings'];

}

function convertCDToRegular($userId, $accountId, $sponsorId, $typeId, $conn)
{
	//ConvertCD to Regular Accounts
	// die("From Package {$typeId} Account ID = ".$accountId);

	if ($typeId == 4) {
		$type = 1;
		$typename = 'Package A';
		$referralIncome = 200;
	} else if ($typeId == 5) {
		$type = 2;
		$typename = 'Package B';
		$referralIncome = 400;
	} else if ($typeId == 6) {
		$type = 3;
		$typename = 'Package C';
		$referralIncome = 800;
	}

	#update user
	$data = "member_type_id = {$type}";
	$where = " id = {$userId}";
	update_table($conn, 'users', $where, $data);

	#update activation code to regular
	$data = "type_id = {$type}, type = '{$typename}'";
	$where = " user_id = {$userId}";
	update_table($conn, 'activation_codes', $where, $data);

	#update accounts code to regular
	$upgraded_on = date('Y-m-d H:i:s');
	$data = "upgraded_on = '{$upgraded_on}', from_package = {$typeId}";
	$where = " user_id = {$userId}";
	update_table($conn, 'accounts', $where, $data);

	#get sponsor account
	$sql = "SELECT * FROM accounts WHERE id = {$sponsorId}";
	$result = $conn->query($sql);
	$sponsor = $result->fetch_assoc();

	#insert earnings direct_referral
	if (!empty($sponsor)) {
		$data = array(
			'account_id' => $sponsor['id'],
			'user_id' => $sponsor['user_id'],
			'source' => 'direct_referral',
			'from_funding' => 'false',
			'amount' => $referralIncome,
			'left_user_id' => $accountId,
			'right_user_id' => 0,
			'earned_date' => $upgraded_on,
			'created_at' => date('Y-m-d H:i:s')
		);

		insert_new($conn, 'earnings', $data);
	}

	echo "<pre>";
	print_r($data);
	// die;
}

function update_table($conn, $table, $where, $data)
{
	if (!empty($data)) {

		// echo "<br>Where = ".$where;

		//$data = implode(",",$data);

		$update_table = "UPDATE {$table} 
							  SET {$data}
							  WHERE " . $where;

		if ($conn->query($update_table) === true) {
			echo "{$table} table updated successfully" . PHP_EOL;
		} else {
			echo "Error: " . $conn->error;
		}
	}
}

function insert_new($conn, $table, $insData = array())
{
	if (!empty($insData)) {

		$data = parse_data($insData);

		$query = "INSERT INTO {$table} (" . $data['key'] . ") VALUES (" . $data['value'] . ")";

		if ($conn->query($query) === true) {
			echo "New pairing record created successfully" . PHP_EOL;
		} else {
			echo "Error: " . $query . "<br>" . $conn->error;
		}

	}
}

function parse_data($insData = array())
{
		// echo "<pre>";
		// print_r($insData);

	$fields = $values = array();

	foreach (array_keys($insData) as $key) {
		$fields[] = "`$key`";
		$values[] = "'" . $insData[$key] . "'";
	}

	$columns = implode(",", $fields);
	$values = implode(",", $values);

	return array('key' => $columns, 'value' => $values);
}
