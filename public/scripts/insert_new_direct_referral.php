<?php

# i dunno if its used or not scripts
# so i'm just gonna change the dbname so that 
# no problem arises
# remove die if script will be used;

die();

ini_set('max_execution_time', 5000);
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "cpmpc_lite_backup";

$servername = "marketingmycoop.cghlvb5xxt2e.us-east-1.rds.amazonaws.com";
$username = "mycoopuser";
$password = "1qaz45678";
$dbname = 'marketingmycoop';
#$dbname = "development_marketingmycoop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, user_id, upline_id, sponsor_id, node, created_at FROM accounts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

	while ($row = $result->fetch_assoc()) {

    	#check if already paired
		if (check_if_already_paired($conn, $row['id'], $row['sponsor_id']) > 0) continue;

    	#get sponsor info
		$sponsor_info = get_member_type($conn, $row['sponsor_id']);

		$member_info = get_member_type($conn, $row['id']);

		if ($member_info['member_type_id'] > 3) {
			$amount = 0;
		} else {
			$amount = min($sponsor_info['referral_income'], $member_info['referral_income']);
		}

    	// if($sponsor_info['user_id'] == 0 || empty($sponsor_info['user_id'])) continue;
    	
    	#insert into earnings
		$data = array(
			'account_id' => $row['sponsor_id'],
			'user_id' => $sponsor_info['user_id'],
			'source' => 'direct_referral',
			'amount' => $amount,
			'left_user_id' => $row['id'],
			'earned_date' => $row['created_at'],
			'created_at' => date('Y-m-d H:i:s')
		);

		echo "<pre>";
		print_r($data);

		insert_new($conn, 'earnings', $data);

	}
}

function check_if_already_paired($conn, $member_id, $sponsor_id)
{
	$acctSql = "SELECT * FROM earnings 
				WHERE account_id={$sponsor_id} AND left_user_id={$member_id} AND source='direct_referral'";

	$acctResult = $conn->query($acctSql);

	return $acctResult->num_rows;
}

function get_member_type($conn, $acc_id)
{
	$acctSql = "SELECT user_id FROM accounts WHERE id='" . $acc_id . "'";
	$acctResult = $conn->query($acctSql);
	$user_id = $acctResult->fetch_row();

	$usersql = "SELECT member_type_id FROM users WHERE id='" . $user_id[0] . "'";
	$userResult = $conn->query($usersql);
	$uplinerow = $userResult->fetch_row();

	$pairingSql = "SELECT referral_income, pairing_income,points_value FROM membership_settings WHERE id='" . $uplinerow[0] . "'";
	$pairingResult = $conn->query($pairingSql);
	$membership_settings = $pairingResult->fetch_row();

	$data = array(
		'user_id' => $user_id[0],
		'member_type_id' => $uplinerow[0],
		'referral_income' => $membership_settings[0],
	);

	return $data;
}


function insert_new($conn, $table, $insData = array())
{
	if (!empty($insData)) {

		$data = parse_data($insData);

		$query = "INSERT INTO {$table} (" . $data['key'] . ") VALUES (" . $data['value'] . ")";

		if ($conn->query($query) === true) {
			echo "New pairing record created successfully";
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

?>