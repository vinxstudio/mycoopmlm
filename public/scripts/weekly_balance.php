<?php

# i dunno if its used or not scripts
# so i'm just gonna change the dbname so that 
# no problem arises

# remove die if script will be used;

die();

ini_set('max_execution_time', 50000);
ini_set('memory_limit', '1024M');
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "cpmpc_lite2";

$servername = "marketingmycoop.cghlvb5xxt2e.us-east-1.rds.amazonaws.com";
$username = "mycoopuser";
$password = "1qaz45678";
$dbname = 'marketingmycoop';
#$dbname = "development_marketingmycoop";

date_default_timezone_set("Asia/Manila");
// $logs = "/var/www/html/mycoop/cron/logs.log";
// error_log(date('Y-m-d H:i:s').": Running Background Process. Batch - ".$argv[1].PHP_EOL,3, $logs);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
echo "<pre>";
#get account using account id
// $str_account_ids = (!empty($argv))? $argv[1]: null;

// echo $str_account_ids.PHP_EOL;
$str_account_ids = true;
if (!empty($str_account_ids)) {

	// $account_ids = explode(",",$str_account_ids);

	$sql_query = "SELECT users.group_id, users.id FROM users LEFT JOIN user_details ON user_details.id = users.user_details_id WHERE users.role = 'member' GROUP BY users.group_id ORDER BY user_details.first_name ASC";
	$sql = $conn->query($sql_query);
	$weekly_payout = $sql->fetch_all();

	foreach ($weekly_payout as $weekly) {
		$group_id = $weekly[0];
		$user_id = $weekly[1];

		proccessRemainingBalance($group_id, $conn);
		// echo '-------------------------- Start -------------------------------'.PHP_EOL;

		// #update remaining balance
		// $data = "remaining_balance = 0";
		// $where = " user_id = {$user_id}";
		// update_table( $conn, 'weekly_payout', $where, $data);

		// echo "Group ID = ".$group_id.PHP_EOL;
		// echo "User ID = ".$user_id.PHP_EOL;
		// echo "Available Balance = ".$available_balance.PHP_EOL;
		// echo "Net Income = ".$net_income.PHP_EOL;
		// echo "Remaining Balance = ".$remaining_balance.PHP_EOL;

		// // echo "Balance = ".$balance.PHP_EOL;

		// // process_available_balance($group_id, $balance, $conn);

		// echo '-------------------------- End -------------------------------'.PHP_EOL;
	}
}


# Functions
# Helpers

function proccessRemainingBalance($group_id, $conn)
{
	$available_balance = getAvailableBalance($group_id, $conn);
	$accumulated_balance = 0;
	$remaining_amount = 0;
	$r_balance = 0.00;
	$f_balance = 0;
	$remaining_balance = $available_balance;

	$sql_query = "SELECT * FROM weekly_payout WHERE group_id = {$group_id} ORDER BY created_at ASC";
	$sql = $conn->query($sql_query);
	$weekly_payout = $sql->fetch_all();
	$num_payout = count($weekly_payout);
	if ($num_payout > 0) {
		$r_balance = $available_balance / $num_payout;
		// $r_balance = round($r_balance);
	}
	echo '-------------------------- Start -------------------------------' . PHP_EOL;
	echo "Group ID = " . $group_id . PHP_EOL;
	echo "Each Balance = " . $r_balance . PHP_EOL;

	foreach ($weekly_payout as $weekly) {
		$group_id = $weekly[1];
		$user_id = $weekly[2];
		$net_income = $weekly[7];

		echo "User ID = " . $user_id . PHP_EOL;
		#update
		$data = "remaining_balance = {$r_balance}";
		$where = " user_id = {$user_id}";
		update_table($conn, 'weekly_payout', $where, $data);
	}
	echo '-------------------------- End -------------------------------' . PHP_EOL;
}

function getWithdrawals($user_id, $conn)
{
	$sql = $conn->query("SELECT * FROM withdrawals WHERE status = 'pending' AND user_id = {$user_id} AND created_at >= '2018-08-11 00:00:01'");

	$total = 0;
	if ($sql->num_rows > 0) {
		while ($total_withdrawn = $sql->fetch_assoc()) {
			$total += $total_withdrawn['amount'];
		}
	}
	return $total;
}

function getNetIncome($group_id, $user_id, $conn)
{
	$sql = $conn->query("SELECT * FROM weekly_payout WHERE user_id = {$user_id}");
	$total_income = $sql->fetch_assoc();

	if (!empty($total_income)) {
		return $total_income['net_income'];
	} else {
		return 0;
	}
}

function getAvailableBalance($group_id, $conn)
{

	$getIdssql = "SELECT * FROM available_balance WHERE group_id={$group_id} AND source='available_balance'";
	$getResult = $conn->query($getIdssql);
	$balance = $getResult->fetch_assoc();

	if (!empty($balance)) {
		return $balance['available_balance'];
	} else {
		return 0;
	}
}

function getUserIds($group_id, $conn)
{
	$user_ids = array();

	$getIdssql = "SELECT * FROM weekly_payout WHERE group_id={$group_id}";
	$getIdsresult = $conn->query($getIdssql);

	if ($getIdsresult->num_rows > 0) {
		while ($idsrow = $getIdsresult->fetch_assoc()) {
			$user_ids[] = $idsrow['id'];
		}
	}

	return $user_ids;
}


function process_available_balance($group_id, $balance, $conn)
{
	// #deduct 10%
	// $deduction = $total_income * 0.1;
	// $new_income = $total_income - $deduction;
	#check if already inserted
	$is_inserted = chck_available_balance($group_id, $conn);

	if (!$is_inserted) {
		$data = array(
			'group_id' => $group_id,
			'available_balance' => $balance,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		);

		insert_new($conn, 'available_balance', $data);
	} else {
		#update
		$data = "available_balance = {$balance}";
		$where = " group_id = {$group_id}";
		update_table($conn, 'available_balance', $where, $data);
	}
}

function chck_available_balance($group_id, $conn)
{
	$sql = "SELECT * FROM available_balance 
					WHERE group_id = {$group_id}";

	$query = $conn->query($sql);

	if ($query->num_rows > 0) {
		return true;
	} else {
		return false;
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

function update_data($conn, $table, $where, $rm_left_ids, $rm_right_ids)
{
	if (!empty($data)) {

		echo "<br>Where = " . $where;
		echo "<br> Diff Left Ids = " . $rm_left_ids;
		echo "<br> Diff Right Ids = " . $rm_right_ids . PHP_EOL;

		$updateUnpairedIds = "UPDATE accounts 
							  SET unpaired_left_ids = '" . $rm_left_ids . "' , unpaired_right_ids = '" . $rm_right_ids . "'
							  WHERE " . $where;

		if ($conn->query($updateUnpairedIds) === true) {
			echo "{$table} table updated successfully" . PHP_EOL;
		} else {
			echo "Error: " . $conn->error;
		}
	}
}

function parse_data($insData = array())
{
	echo "<pre>";
	print_r($insData);

	$fields = $values = array();

	foreach (array_keys($insData) as $key) {
		$fields[] = "`$key`";
		$values[] = "'" . $insData[$key] . "'";
	}

	$columns = implode(",", $fields);
	$values = implode(",", $values);

	return array('key' => $columns, 'value' => $values);
}

 