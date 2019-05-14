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

	$sql_query = "SELECT users.id, users.group_id, user_details.first_name, user_details.last_name, users.role FROM users LEFT JOIN user_details ON user_details.id = users.user_details_id WHERE users.role = 'member' GROUP BY users.group_id ORDER BY user_details.first_name ASC";
	$sql = $conn->query($sql_query);
	$user_ids = $sql->fetch_all();

	#loop all downlines
	foreach ($user_ids as $user_id_row) {
		$group_id = $user_id_row[1];
		$fullname = $user_id_row[2] . ' ' . $user_id_row[3];
		echo '-------------------------- Start -------------------------------' . PHP_EOL;

		echo "Group ID = " . $group_id . PHP_EOL;

		$userids = getUserIds($group_id, $conn);
        
		#calculate weekly payout
		$last_saturday = date("Y-m-d", strtotime("last saturday"));
		$current_saturday = date("Y-m-d", strtotime("saturday"));
		// $last_saturday = '2018-08-11';
		// $current_saturday = '2018-08-18';

		$date_from = $last_saturday . ' 06:00:01';
		$date_to = $current_saturday . ' 05:59:59';

		$total_DR = calculate_income($userids, 'direct_referral', $date_from, $date_to, $conn);
		$total_MB = calculate_income($userids, 'pairing', $date_from, $date_to, $conn);
		$total_GC = calculate_income($userids, 'GC', $date_from, $date_to, $conn);
		
		
		#check if has amount
		(!empty($total_DR['amount'])) ? $direct_referral = $total_DR['amount'] : $direct_referral = 0;
		(!empty($total_MB['amount'])) ? $matching_bonus = $total_MB['amount'] : $matching_bonus = 0;
		(!empty($total_GC['amount'])) ? $gift_check = $total_GC['amount'] : $gift_check = 0;
		$total_income = $direct_referral + $matching_bonus;
		echo "FROM = " . $date_from . PHP_EOL;
		echo "TO = " . $date_to . PHP_EOL;

		if ($total_income > 0) {
			echo "User ID = " . $total_DR['user_id'] . PHP_EOL;
			echo "Weekly Date = " . $date_from . '-' . $date_to . PHP_EOL;
			echo "Direct Referral = " . $direct_referral . PHP_EOL;
			echo "Matching Bonus = " . $matching_bonus . PHP_EOL;
			echo "Gift Check = " . $gift_check . PHP_EOL;
			echo "Total Income = " . $total_income . PHP_EOL;
			#insert to total income
			overallTotalIncome($group_id, $total_income, $direct_referral, $matching_bonus, $gift_check, $date_from, $date_to, $conn);
		}

		echo '-------------------------- End -------------------------------' . PHP_EOL;
	}
}


# Functions
# Helpers

function getUserIds($group_id, $conn)
{
	$user_ids = array();

	$getIdssql = "SELECT * FROM users WHERE group_id={$group_id}";
	$getIdsresult = $conn->query($getIdssql);

	if ($getIdsresult->num_rows > 0) {
		while ($idsrow = $getIdsresult->fetch_assoc()) {
			$user_ids[] = $idsrow['id'];
		}
	}

	return $user_ids;
}

function calculate_income($user_ids, $source, $date_from, $date_to, $conn)
{
	$sql = $conn->query("SELECT SUM(amount) as amount, user_id FROM earnings WHERE user_id IN (" . implode(',', $user_ids) . ")  AND source = '{$source}' AND created_at >= '{$date_from}' AND created_at <= '{$date_to}'");
	$total_income = $sql->fetch_assoc();

	if (!empty($total_income)) {
		return $total_income;
	} else {
		return 0;
	}
}

function overallTotalIncome($group_id, $total_income, $direct_referral, $matching_bonus, $gift_check, $from, $to, $conn)
{	
	#deduct 10%
	$deduction = $total_income * 0.1;
	$new_income = $total_income - $deduction;
	#check if already inserted
	$is_inserted = chck_weekly_payout($group_id, $from, $to, $conn);

	if (!$is_inserted) {
		$data = array(
			'group_id' => $group_id,
			'direct_referral' => $direct_referral,
			'matching_bonus' => $matching_bonus,
			'gift_check' => $gift_check,
			'gross_income' => $total_income,
			'net_income' => $new_income,
			'status' => 'pending',
			'date_from' => $from,
			'date_to' => $to,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		);

		insert_new($conn, 'weekly_payout', $data);
	}
}

function chck_weekly_payout($group_id, $from, $to, $conn)
{
	$sql = "SELECT * FROM weekly_payout 
					WHERE group_id = {$group_id} AND date_from = '{$from}' AND date_to = '{$to}'";

	$query = $conn->query($sql);

	if ($query->num_rows > 0) {
		return true;
	} else {
		return false;
	}
}

function getWithdrawn($user_ids, $conn)
{
	$sql = $conn->query("SELECT SUM(amount) as amount FROM withdrawals WHERE user_id IN (" . implode(',', $user_ids) . ") AND status IN ('pending, approved')");
	$total_withdrawn = $sql->fetch_assoc();

	if (!empty($total_withdrawn)) {
		return $total_withdrawn['amount'];
	} else {
		return 0;
	}
}

function getSavings()
{

	$sql = $conn->query("SELECT SUM(savings) as amount FROM withdrawals WHERE user_id IN (" . implode(',', $user_ids) . ") AND status IN ('pending, approved')");
	$total_savings = $sql->fetch_assoc();

	if (!empty($total_savings)) {
		return $total_savings['amount'];
	} else {
		return 0;
	}
}

function getSharedCapital()
{

	$sql = $conn->query("SELECT SUM(shared_capital) as amount FROM withdrawals WHERE user_id IN (" . implode(',', $user_ids) . ") AND status IN ('pending, approved')");
	$total_sharedcapital = $sql->fetch_assoc();

	if (!empty($total_sharedcapital)) {
		return $total_sharedcapital['amount'];
	} else {
		return 0;
	}
}

function getMaintenance()
{

	$sql = $conn->query("SELECT SUM(maintenance) as amount FROM withdrawals WHERE user_id IN (" . implode(',', $user_ids) . ") AND status IN ('pending, approved')");
	$total_maintenance = $sql->fetch_assoc();

	if (!empty($total_maintenance)) {
		return $total_maintenance['amount'];
	} else {
		return 0;
	}
}

function getPurchasedCodesTotalAttribute()
{
	$entry = codePurchaseAmount();
	$codes = $this->purchasedCodes->where([
		'paid_by_balance' => 'true'
	]);
	return $entry * $codes->count();
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
