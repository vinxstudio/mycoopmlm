<?php

# unused scripts

# remove die if script will be used;

die();

ini_set('max_execution_time', 30000);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cpmpc_lite_backup";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM accounts ORDER BY id ASC";

$getaccountresult = $conn->query($sql);

if ($getaccountresult->num_rows > 0) {

	while ($accountrow = $getaccountresult->fetch_assoc()) {
		$total_left_points = 0;
		$total_right_points = 0;


		$leftids = explode(",", $accountrow['unpaired_left_ids']);
		$rightids = explode(",", $accountrow['unpaired_right_ids']);
		$upline_info = get_member_type($conn, $accountrow['id']);
			// loop all left id

		foreach ($leftids as $leftid) {
				# code...
				// $user_id = get_user_id( $conn, $leftid );
			$left_points = get_member_type($conn, $leftid);
			$total_left_points = $total_left_points + min($upline_info[1], $left_points[1]);
		}

		foreach ($rightids as $rightid) {
				// $user_id = get_user_id( $conn, $rightid );
			$right_points = get_member_type($conn, $rightid);
			$total_right_points = $total_right_points + min($upline_info[1], $right_points[1]);
		}

		echo "<br>--------------------------------------------------";
		echo "<br>Accoiunt id  " . $accountrow['user_id'];
		echo "<br>Left Points " . $total_left_points;
		echo "<br>Right Points " . $total_right_points;


		if ($total_left_points > $total_right_points) {
			$total_left_points = $total_left_points - $total_right_points;
			$total_right_points = 0;
		} else {
			$total_right_points = $total_right_points - $total_left_points;
			$total_left_points = 0;
		}

		echo "<br>Final Left Points " . $total_left_points;
		echo "<br>Final Right Points " . $total_right_points;
		echo "<br>--------------------------------------------------";

		echo $insertLeftSql = "INSERT INTO earnings (account_id,user_id,source,from_funding,amount,left_user_id,right_user_id,created_at)  
										  VALUES ('" . $accountrow['id'] . "','" . $accountrow['user_id'] . "','left_pv','false','" . $total_left_points . "','0','0','" . date('Y-m-d H:i:s') . "')";

		echo "</br>";
			//echo $insertPairingresult = $conn->query($insertPairingSql);
		if ($conn->query($insertLeftSql) === true) {
			echo "New Left PV record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}

		echo $insertRightSql = "INSERT INTO earnings (account_id,user_id,source,from_funding,amount,left_user_id,right_user_id,created_at)  
										  VALUES ('" . $accountrow['id'] . "','" . $accountrow['user_id'] . "','right_pv','false','" . $total_right_points . "','0','0','" . date('Y-m-d H:i:s') . "')";
						//remove the first paired ids	
		echo "</br>";
			//echo $insertPairingresult = $conn->query($insertPairingSql);
		if ($conn->query($insertRightSql) === true) {
			echo "New Right PV record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$updateUnpairedIds = "UPDATE accounts 
								  SET total_left_points = '" . $total_left_points . "' , total_right_points = '" . $total_right_points . "'
								  WHERE id = '" . $accountrow['id'] . "'";

		$updateUnpairedIdsresult = $conn->query($updateUnpairedIds);

		if ($updateUnpairedIdsresult === true) {
			echo "New record Updated successfully";
		} else {
			echo "Error: " . $updateUnpairedIdsresult . "<br>" . $conn->error;
		}

	}
}

// function get_user_id( $conn, $id){
// 	$acctSql = "SELECT user_id FROM accounts WHERE id='".$id."'";
// 	$acctResult = $conn->query($acctSql);
// 	$accounts = $acctResult->fetch_row();

// 	return $accounts[0];
// }

function get_member_type($conn, $acc_id)
{

	$acctSql = "SELECT user_id FROM accounts WHERE id='" . $acc_id . "'";
	$acctResult = $conn->query($acctSql);
	$user_id = $acctResult->fetch_row();

	$usersql = "SELECT member_type_id FROM users WHERE id='" . $user_id[0] . "'";
	$userResult = $conn->query($usersql);
	$uplinerow = $userResult->fetch_row();

	$pairingSql = "SELECT pairing_income,points_value FROM membership_settings WHERE id='" . $uplinerow[0] . "'";
	$pairingResult = $conn->query($pairingSql);
	$pairingrow = $pairingResult->fetch_row();

	return $pairingrow;
}