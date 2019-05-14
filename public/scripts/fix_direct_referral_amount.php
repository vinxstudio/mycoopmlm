<?php

# unused scripts

# remove die if script will be used;

die();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cpmpc_lite_backup_3_16";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM earnings Where source = 'direct_referral'";
$result = $conn->query($sql);

echo "<pre>";
if ($result->num_rows > 0) {

	while ($row = $result->fetch_assoc()) {

    	#get sponsor info
		$sponsor_info = get_member_type($conn, $row['account_id']);

		$member_info = get_member_type($conn, $row['left_user_id']);

		if ($member_info['member_type_id'] > 3) {
			$amount = 0;
		} else {
			$amount = min($sponsor_info['referral_income'], $member_info['referral_income']);
		}

    	#insert into earnings
		$data = array(
			'id' => $row['id'],
			'account_id' => $row['account_id'],
			'sponsor_type_id' => $sponsor_info['member_type_id'],
			'member_type_id' => $member_info['member_type_id'],
			'source' => 'direct_referral',
			'amount_earning' => $row['amount'],
			'amount' => $amount,
			'left_user_id' => $row['left_user_id'],
			'earned_date' => $row['created_at'],
		);

		if ($amount > 0 && $row['amount'] == 0) {
			print_r($data);
			update_earnings($conn, $amount, $row['id']);
		}
	}
}

function update_earnings($conn, $amount, $id)
{
	$sql = "UPDATE earnings SET amount=" . $amount . " WHERE id=" . $id;
	$result = $conn->query($sql);
	return $result;
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

?>