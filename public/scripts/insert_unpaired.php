<?php

# unused scripts

# remove die if script will be used;

die();

ini_set('max_execution_time', 5000);
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

#UPDATE ACCOUNTS
$sql = "UPDATE `accounts` SET `unpaired_left_ids`='',`unpaired_right_ids`='',`unpaired_left_cd`='',`unpaired_right_cd`='',`total_left_points`=0,`total_right_points`=0 WHERE 1";
$conn->query($sql);

$sql = "SELECT * FROM accounts ORDER BY id ASC";
$getaccountresult = $conn->query($sql);

if ($getaccountresult->num_rows > 0) {
    // output data of each row
	while ($accountrow = $getaccountresult->fetch_assoc()) {

		$getleftDownlinessql = "SELECT * FROM downlines WHERE parent_id='" . $accountrow['id'] . "' AND node='left'";
		$getleftDownlinesresult = $conn->query($getleftDownlinessql);
		if ($getleftDownlinesresult->num_rows > 0) {
			echo "foraccount" . $accountrow['id'] . "--";
			$newLeftIds = "";
			$newLeftCDIds = "";
			while ($dowlineleftcountrow = $getleftDownlinesresult->fetch_assoc()) {
				//insert all left downlines
				$thisaccountsql = "SELECT * FROM accounts WHERE id='" . $dowlineleftcountrow['account_id'] . "'";
				$thisaccountresult = $conn->query($thisaccountsql);
				$thisaccountrow = $thisaccountresult->fetch_row();

				$thisUsersql = "SELECT * FROM users WHERE id='" . $thisaccountrow[1] . "'";
				$thisUserresult = $conn->query($thisUsersql);
				$thisUserrow = $thisUserresult->fetch_row();

				if ($thisUserrow[15] > 3) {
					$newLeftCDIds .= $accountrow['unpaired_left_cd'] . "" . $dowlineleftcountrow['account_id'] . ",";

				} else {

					$newLeftIds .= $accountrow['unpaired_left_ids'] . "" . $dowlineleftcountrow['account_id'] . ",";

				}

			}

			echo "Account Id " . $accountrow['id'] . "</br>";
			echo "newLefttIds " . $newLeftIds . "</br>";
			echo "newLeftCDIds " . $newLeftCDIds . "</br>";
			$updateUnpairedLeftIds = "UPDATE accounts 
			                          SET unpaired_left_ids = '" . $newLeftIds . "' , unpaired_left_cd='" . $newLeftCDIds . "'
									  WHERE id = '" . $accountrow['id'] . "'";
			$updateUnpairedLeftIdsresult = $conn->query($updateUnpairedLeftIds);

			echo "</br>";
		}


		$getrightDownlinessql = "SELECT * FROM downlines WHERE parent_id='" . $accountrow['id'] . "' AND node='right'";
		$getrightDownlinesresult = $conn->query($getrightDownlinessql);
		if ($getrightDownlinesresult->num_rows > 0) {
			echo "foraccount" . $accountrow['id'] . "--";
			$newRightIds = "";
			$newRightCDIds = "";
			while ($dowlinerightcountrow = $getrightDownlinesresult->fetch_assoc()) {
				//insert all left downlines
				$thisaccountsql = "SELECT * FROM accounts WHERE id='" . $dowlinerightcountrow['account_id'] . "'";
				$thisaccountresult = $conn->query($thisaccountsql);
				$thisaccountrow = $thisaccountresult->fetch_row();

				$thisUsersql = "SELECT * FROM users WHERE id='" . $thisaccountrow[1] . "'";
				$thisUserresult = $conn->query($thisUsersql);
				$thisUserrow = $thisUserresult->fetch_row();

				if ($thisUserrow[15] > 3) {

					$newRightCDIds .= $accountrow['unpaired_right_cd'] . "" . $dowlinerightcountrow['account_id'] . ",";
				} else {

					$newRightIds .= $accountrow['unpaired_right_ids'] . "" . $dowlinerightcountrow['account_id'] . ",";

				}

			}

			echo "Account Id " . $accountrow['id'] . "</br>";
			echo "newRightIds " . $newRightIds . "</br>";
			echo "newRightCDIds " . $newRightCDIds . "</br>";
			$updateUnpairedRightIds = "UPDATE accounts 
			                          SET unpaired_right_cd = '" . $newRightCDIds . "' , unpaired_right_ids = '" . $newRightIds . "' 
									  WHERE id = '" . $accountrow['id'] . "'";
			$updateUnpairedRightIdsresult = $conn->query($updateUnpairedRightIds);

			echo "</br>";
		}
	}
} else {
	echo "0 results";
}
$conn->close();


?>

