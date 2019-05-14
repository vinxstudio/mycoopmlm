<?php

# unused scripts

# remove die if script will be used;

die();

ini_set('max_execution_time', 1000);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cpmpc_lite";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

/*
 $earnings = new Earnings;
                    
$earnings->account_id = $sponsor->id;
                    
$earnings->user_id = $sponsor->user_id;
                    
$earnings->source = $this->earningsDirectReferralKey;
                    $earnings->amount = $referralIncome;
                    
$earnings->save();
 */
function runPV($userid, $uplineId, $node)
{
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "cpmpc_lite";

		// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql4 = "SELECT member_type_id FROM users WHERE id=" . $userid;
	echo $sql4;
	$result4 = $conn->query($sql4);
	$memberrow = $result4->fetch_row();

	$getMemberPV = "SELECT points_value FROM membership_settings WHERE id  = '" . $memberrow[0] . "'";
	$getMemberPVresult2 = $conn->query($getMemberPV);
	$memberrowPV = $getMemberPVresult2->fetch_row();

	$uplineAccountselectsql = "SELECT id, user_id,node,upline_id FROM accounts WHERE id=" . $uplineId;
	$uplineAccountresult = $conn->query($uplineAccountselectsql);
	$uplineAccountrow = $uplineAccountresult->fetch_row();

	$uplineUser = "SELECT member_type_id FROM users WHERE id='" . $uplineAccountrow[1] . "'";
	echo $uplineUser;
	$uplineUserresult = $conn->query($uplineUser);
	$uplinerow = $uplineUserresult->fetch_row();

	$getUplinePV = "SELECT points_value FROM membership_settings WHERE id = '" . $uplinerow[0] . "'";
	$getUplinePVResult = $conn->query($getUplinePV);
	$getUplinePVRow = $getUplinePVResult->fetch_row();


	if ($memberrow[0] > 3) {
		$amount = 0;
	} else {
		$amount = min($getUplinePVRow[0], $memberrowPV[0]);
	}

	if ($node == 'right') {
		$node = 'right_pv';
	} else {
		$node = 'left_pv';
	}
		//insert to points value to the account of upline
	$sql4 = "INSERT INTO earnings (account_id, user_id, source,amount)
					VALUES (" . $uplineAccountrow[0] . ", " . $uplineAccountrow[1] . ", '" . $node . "'," . $amount . ")";
	echo $sql4;
	if ($conn->query($sql4) === true) {
		echo "New record created successfully";
		if ($uplineAccountrow[3] != null) {
			$sql = "SELECT id, user_id,upline_id,sponsor_id,node FROM accounts WHERE id='" . $uplineAccountrow[0] . "'";
			$result = $conn->query($sql);
				//while($row = $result->fetch_row()){
					//if($row[1] != NULL) {
			$row = $result->fetch_row();
			runPV($userid, $row[2], $row[4]);
					//}
				//}
		}
	} else {
		echo "Error: " . $sql4 . "<br>" . $conn->error;
	}

}

$sql = "SELECT id, user_id, upline_id, sponsor_id, node FROM accounts ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	while ($row = $result->fetch_assoc()) {
        //echo "id: " . $row["id"]. " - ID: " . $row["user_id"]. " " . $row["sponsor_id"]. "<br>";
		runPV($row['user_id'], $row['upline_id'], $row['node']);

	}
} else {
	echo "0 results";
}
$conn->close();


/*
//insert PV to uplines
			function UpdatePV($uplineId) {
				$uplineAccountselectsql = "SELECT id, user_id,node FROM accounts WHERE id=".$row['upline_id'];
				$uplineAccountresult = $conn->query($uplineAccountselectsql);
				$uplineAccountrow = $uplineAccountresult->fetch_row();
				
				if ($row['node'] == 'left') {
						$pvnode = 'left_pv';
				} else {
						$pvnode = 'right_pv';
				}
				
				// $pvamount = min($sponsorrowDR[1],$memberrowDR[1]);
				// $pvamount = $memberrowDR[1];
				echo $insertPVSql = "INSERT INTO earnings (account_id,user_id,source,from_funding,amount,created_at)  
										  VALUES ('".$sponsorrow[0]."','".$sponsorrow[1]."','".$pvnode."','false','".$pvamount."','".date('Y-m-d H:i:s')."')";
						//remove the first paired ids	
						echo "</br>";
						//echo $insertPairingresult = $conn->query($insertPairingSql);
						if ($conn->query($insertPVSql) === TRUE) {
							echo "New ".$pvnode." record created successfully";
						} else {
							echo "Error: " . $sql . "<br>" . $conn->error;
						}
			}
 */
?>
