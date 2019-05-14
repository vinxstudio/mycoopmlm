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
				$thisUserrow = $thisUserresult->fetch_assoc();

				switch ($thisUserrow['member_type_id']) {
					case 6:
						$code = 'CDC';
						break;
					case 5:
						$code = 'CDB';
						break;
					case 4:
						$code = 'CDA';
						break;
					case 3:
						$code = 'PCC';
						break;
					case 2:
						$code = 'PCB';
						break;
					case 1:
						$code = 'PCA';
						break;
				}

				if ($thisUserrow['member_type_id'] > 3) {
					$newLeftCDIds .= $accountrow['unpaired_left_cd'] . "" . $code . $dowlineleftcountrow['account_id'] . ",";

				} else {

					$newLeftIds .= $accountrow['unpaired_left_ids'] . "" . $code . $dowlineleftcountrow['account_id'] . ",";

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
				$thisUserrow = $thisUserresult->fetch_assoc();

				switch ($thisUserrow['member_type_id']) {
					case 6:
						$code = 'CDC';
						break;
					case 5:
						$code = 'CDB';
						break;
					case 4:
						$code = 'CDA';
						break;
					case 3:
						$code = 'PCC';
						break;
					case 2:
						$code = 'PCB';
						break;
					case 1:
						$code = 'PCA';
						break;
				}

				if ($thisUserrow['member_type_id'] > 3) {

					$newRightCDIds .= $accountrow['unpaired_right_cd'] . "" . $code . $dowlinerightcountrow['account_id'] . ",";
				} else {

					$newRightIds .= $accountrow['unpaired_right_ids'] . "" . $code . $dowlinerightcountrow['account_id'] . ",";

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

