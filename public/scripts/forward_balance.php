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

	$sql_query = "SELECT * FROM available_balance";
	$sql = $conn->query($sql_query);
	$user_ids = $sql->fetch_all();

	#loop all downlines
	foreach ($user_ids as $user_id_row) {
		$group_id = $user_id_row[1];
		$available_balance = $user_id_row[2];
		echo '-------------------------- Start -------------------------------' . PHP_EOL;

		echo "Group ID = " . $group_id . PHP_EOL;
		echo "Balance = " . $available_balance . PHP_EOL;

        #insert to available balance
		process_encashment_summary($group_id, $available_balance, $conn);
		echo '-------------------------- End -------------------------------' . PHP_EOL;
	}
}


# Functions
# Helpers

function process_encashment_summary($group_id, $balance, $conn)
{	
	// #deduct 10%
	// $deduction = $total_income * 0.1;
	// $new_income = $total_income - $deduction;
	#check if already inserted
	$is_inserted = chck_encashment_summary($group_id, $conn);

	if (!$is_inserted) {
		$data = array(
			'group_id' => $group_id,
			'user_id' => $group_id,
			'particular' => 'Forwarded Balance',
			'gross_income' => 0,
			'admin_fee' => 0,
			'cd_account_fee' => 0,
			'net_income' => 0,
			'amount_withdrawn' => 0,
			'adjustment' => 0,
			'balance' => $balance,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		);

		insert_new($conn, 'encashment_summary', $data);
	} else {
        #update
		$data = "balance = {$balance}";
		$where = " group_id = {$group_id}";
		update_table($conn, 'encashment_summary', $where, $data);
	}
}

function chck_encashment_summary($group_id, $conn)
{
	$sql = "SELECT * FROM encashment_summary 
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

?>
