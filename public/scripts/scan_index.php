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

#UPDATE ACCOUNTS
// $sql = "UPDATE `accounts` SET `unpaired_left_ids`='',`unpaired_right_ids`='',`unpaired_left_cd`='',`unpaired_right_cd`='',`total_left_points`=0,`total_right_points`=0 WHERE 1"; 
// $conn->query($sql);

$sql = "SELECT accounts.*, users.member_type_id FROM accounts 
		Join users on users.id = accounts.user_id
		WHERE accounts.id > 0
		ORDER BY accounts.id ASC";
$getaccountresult = $conn->query($sql);

if ($getaccountresult->num_rows > 0) {
    // output data of each row
	while ($accountrow = $getaccountresult->fetch_assoc()) {
		echo "<br> ----------------- {$accountrow['id']} ----------------------";

		$left_ids = explode(",", $accountrow['unpaired_left_ids']);
		$right_ids = explode(",", $accountrow['unpaired_right_ids']);

		#count left and right skip if left or right is 0
		if (count($left_ids) == 0 || count($right_ids) == 0) continue;

		$raw_paired_left_ids = $accountrow['paired_left_ids'];
		$raw_paired_right_ids = $accountrow['paired_right_ids'];

		foreach ($left_ids as $str_left_id) {

			if (empty($str_left_id)) continue;

			$left_id = preg_replace("/[^0-9,.]/", "", $str_left_id);

			if (checkIfPaired($conn, $accountrow['id'], $left_id, 'left') > 0) {

				#check retention if mem_type_id = 2 and 3
				if ($accountrow['member_type_id'] > 1) {
					if (checkIfHasRetention($conn, $accountrow['id'], $left_id, 'left')) continue;
					$raw_paired_left_ids .= $str_left_id . ",";
				} else {
					$raw_paired_left_ids .= $str_left_id . ",";
				}
			}
		}

		foreach ($right_ids as $str_right_id) {

			if (empty($str_right_id)) continue;

			$right_id = preg_replace("/[^0-9,.]/", "", $str_right_id);

			if (checkIfPaired($conn, $accountrow['id'], $right_id, 'right') > 0) {

				#check retention if mem_type_id = 2 and 3
				if ($accountrow['member_type_id'] > 1) {
					if (checkIfHasRetention($conn, $accountrow['id'], $right_id, 'right')) continue;
					$raw_paired_right_ids .= $str_right_id . ",";
				} else {
					$raw_paired_right_ids .= $str_right_id . ",";
				}
			}
		}

		#Remove left Paired Ids
		$arr_paired_left_ids = explode(",", $raw_paired_left_ids);
		$new_unpaired_left_ids = array_diff($left_ids, $arr_paired_left_ids);
		$unpaired_left_ids = implode(",", $new_unpaired_left_ids);
		

		#Remove right Paired Ids
		$arr_paired_right_ids = explode(",", $raw_paired_right_ids);
		$new_unpaired_right_ids = array_diff($right_ids, $arr_paired_right_ids);
		$unpaired_right_ids = implode(",", $new_unpaired_right_ids);

		#update
		$data = "unpaired_left_ids = '{$unpaired_left_ids}', 
				unpaired_right_ids = '{$unpaired_right_ids}',
				paired_left_ids = '{$raw_paired_left_ids}',
				paired_right_ids = '{$raw_paired_right_ids}'";

		$where = " id = {$accountrow['id']}";

		update_table($conn, 'accounts', $where, $data);

		echo "<br>Raw left unpaired: {$accountrow['unpaired_left_ids']}";
		echo "<br>New left unpaired: {$unpaired_left_ids}";
		echo "<br>New left paired: {$raw_paired_left_ids}";
		echo "<br>";
		echo "<br>Raw right unpaired: {$accountrow['unpaired_right_ids']}";
		echo "<br>New right unpaired: {$unpaired_right_ids}";
		echo "<br>New right paired: {$raw_paired_right_ids}";
		echo "<br> -----------------END {$accountrow['id']} END ----------------------";
	}

} else {
	echo "0 results";
}
$conn->close();

function update_table($conn, $table, $where, $data)
{
	if (!empty($data)) {

		$update_table = "UPDATE {$table} 
							  SET {$data}
							  WHERE " . $where;

		if ($conn->query($update_table) === true) {
			// echo "{$table} table updated successfully".PHP_EOL;
		} else {
			echo "Error: " . $conn->error;
		}
	}
}

function checkIfPaired($conn, $parent, $account_id, $node)
{
	$sql = "SELECT * FROM earnings 
				WHERE account_id={$parent} AND {$node}_user_id={$account_id} AND source IN('pairing','GC')";

	$result = $conn->query($sql);
	return $result->num_rows;
}

function checkIfHasRetention($conn, $parent, $account_id, $node)
{
	$sql = "SELECT * FROM points_pairing 
				WHERE account_id={$parent} AND {$node}_user_id={$account_id} ORDER BY id DESC limit 1";
	// echo "<br>".$sql;
	$result = $conn->query($sql);
	$pp = $result->fetch_assoc();
	if ($result->num_rows > 0 && $pp['remaining_' . $node . '_points'] != 0) {
		return 1;
	} else {
		return 0;
	}
}

function getPackageType($conn, $id)
{

	$acctSql = "SELECT * FROM accounts 
				join activation_codes on activation_codes.user_id = accounts.user_id
				WHERE accounts.id=" . $id;

	$acctResult = $conn->query($acctSql);
	$accounts = $acctResult->fetch_assoc();

	return $accounts['type_id'];
}


?>

