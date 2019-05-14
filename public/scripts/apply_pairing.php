<?php

# un used scripts
# remove die if script will be used
die();

ini_set('max_execution_time', 1000);
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

//--getall accounts--//
//$accounts = Accounts::whereIn('id', $base->uplineIDs)->get();

//--getallPairIDs--//
/*
$earnings = Earnings::where('source', $this->earningsPairingKey)->get();

        $ids = [];

        foreach ($earnings as $row){
            $ids[$row->account_id][] = $row->left_user_id;
            $Ids[$row->account_id][] = $row->right_user_id;
        }

        return $ids;
 */




$getaccountsql = "SELECT * FROM accounts ORDER BY id DESC";
$getaccountresult = $conn->query($getaccountsql);

if ($getaccountresult->num_rows > 0) {
    // output data of each row
	echo "<table border='1'>";
	echo "<tr>";
	echo "<th>Account ID</th>";
	echo "<th>Account Code</th>";
	echo "<th>Username</th>";
	echo "<th>Fullname</th>";
	echo "<th>Package Type</th>";
	echo "<th>Number of Downlines</th>";
	echo "<th>Number of Direct Referral</th>";
	echo "<th>Total Amount of Direct Referral</th>";
	echo "<th>Number of Left (PV points)</th>";
	echo "<th>Number of Right (PV points)</th>";
	echo "<th>Number of Pairs (Matching Bonus)</th>";
	echo "<th>Total Amount (Matching Bonus)</th>";
	echo "<th>Total Amount (MB + DR)</th>";
	echo "<tr>";

	while ($accountrow = $getaccountresult->fetch_assoc()) {
        //echo "id: " . $row["id"]. " - ID: " . $row["user_id"]. " " . $row["sponsor_id"]. "<br>";


		$getactcodesql = "SELECT * FROM activation_codes WHERE user_id='" . $accountrow['user_id'] . "' ";
		$getactcoderesult = $conn->query($getactcodesql);
		$coderow = $getactcoderesult->fetch_row();

		$getusersql = "SELECT * FROM users WHERE id='" . $accountrow['user_id'] . "' ";
		$getuserresult = $conn->query($getusersql);
		$userrow = $getuserresult->fetch_row();

		$getuserdetailssql = "SELECT * FROM user_details WHERE id='" . $userrow[3] . "' ";
		$getuserdetailsresult = $conn->query($getuserdetailssql);
		$userdetailsrow = $getuserdetailsresult->fetch_row();
			
			//SELECT COUNT(ProductID) AS NumberOfProducts FROM Products; 
		$getDownlinessql = "SELECT COUNT(account_id) FROM downlines WHERE parent_id='" . $accountrow['id'] . "' ";
		$getDownlinesresult = $conn->query($getDownlinessql);
		$dowlinecountrow = $getDownlinesresult->fetch_row();

		$getLeftsql = "SELECT COUNT(account_id) FROM downlines WHERE parent_id='" . $accountrow['id'] . "' AND node='left'";
		$getLeftresult = $conn->query($getLeftsql);
		$leftcountrow = $getLeftresult->fetch_row();

		$getRightsql = "SELECT COUNT(account_id) FROM downlines WHERE parent_id='" . $accountrow['id'] . "' AND node='right'";
		$getRightresult = $conn->query($getRightsql);
		$rightcountrow = $getRightresult->fetch_row();

		$getPairsNumsql = "SELECT COUNT(account_id) FROM earnings WHERE account_id='" . $accountrow['id'] . "' AND source='pairing'";
		$getPairsNumresult = $conn->query($getPairsNumsql);
		$pairsnumcountrow = $getPairsNumresult->fetch_row();

		$getPairsSumsql = "SELECT SUM(amount) FROM earnings WHERE account_id='" . $accountrow['id'] . "' AND source='pairing'";
		$getPairsSumresult = $conn->query($getPairsSumsql);
		$pairsSumrow = $getPairsSumresult->fetch_row();

		$getDirectNumsql = "SELECT COUNT(account_id) FROM earnings WHERE account_id='" . $accountrow['id'] . "' AND source='direct_referral'";
		$getDirectNumresult = $conn->query($getDirectNumsql);
		$directnumcountrow = $getDirectNumresult->fetch_row();

		$getDirectSumsql = "SELECT SUM(amount) FROM earnings WHERE account_id='" . $accountrow['id'] . "' AND source='direct_referral'";
		$getDirectSumresult = $conn->query($getDirectSumsql);
		$directSumrow = $getDirectSumresult->fetch_row();
			//$userdetailsrow = $getDownlinesresult->fetch_row();
		$TotalAmount = $directSumrow[0] + $pairsSumrow[0];
			
		// get pairings
		echo "<tr>";
		echo "<td>" . $accountrow['id'] . "</td>";
		echo "<td>" . $coderow[3] . "</td>";
		echo "<td>" . $userrow[1] . "</td>";
		echo "<td>" . $userdetailsrow[2] . " " . $userdetailsrow[4] . "</td>";
		echo "<td>" . $coderow[5] . "</td>";
		echo "<td>" . $dowlinecountrow[0] . "</td>";
		echo "<td>" . $directnumcountrow[0] . "</td>";
		echo "<td>" . $directSumrow[0];
		if ($directnumcountrow[0] > 0) {
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>Account ID</th>";
			echo "<th>Username</th>";
			echo "<th>Fullname</th>";
			echo "<th>Package Type</th>";
			echo "<th>Referral Amount </th>";
			echo "<tr>";
			$getMemberssql = "SELECT * FROM accounts WHERE sponsor_id='" . $accountrow['id'] . "'";
			$getMembersresult = $conn->query($getMemberssql);
			while ($memberscountrow = $getMembersresult->fetch_assoc()) {
				$getactcodesql = "SELECT * FROM activation_codes WHERE id='" . $memberscountrow['code_id'] . "' ";
				$getactcoderesult = $conn->query($getactcodesql);
				$coderow = $getactcoderesult->fetch_row();

				$getactsql = "SELECT * FROM accounts WHERE id='" . $memberscountrow['id'] . "' ";
				$getactresult = $conn->query($getactsql);
				$actrow = $getactresult->fetch_row();

				$getusersql = "SELECT * FROM users WHERE id='" . $actrow[1] . "' ";
				$getuserresult = $conn->query($getusersql);
				$userrow = $getuserresult->fetch_row();

				$getuserdetailssql = "SELECT * FROM user_details WHERE id='" . $userrow[3] . "' ";
				$getuserdetailsresult = $conn->query($getuserdetailssql);
				$userdetailsrow = $getuserdetailsresult->fetch_row();

				$getReferralsql = "SELECT referral_income FROM membership_settings WHERE id='" . $userrow[15] . "'";
						//right_user_id='".$actrow[1]."' AND 
				$getReferralresult = $conn->query($getReferralsql);
				$getReferralrow = $getReferralresult->fetch_row();
				echo "<tr>";
				echo "<td>" . $coderow[3] . "</td>";
				echo "<td>" . $userrow[1] . "</td>";
				echo "<td>" . $userdetailsrow[2] . " " . $userdetailsrow[4] . "</td>";
				echo "<td>" . $coderow[5] . "</td>";
				echo "<td>" . $getReferralrow[0] . "</thd";

				echo "</tr>";
			}

			echo "</table>";
		}
		echo "</td>";
		$getLeftamountssql = "SELECT SUM(amount) FROM earnings WHERE source='left_pv' AND user_id='" . $accountrow['user_id'] . "'";
					//right_user_id='".$actrow[1]."' AND 
		$getLeftamountresult = $conn->query($getLeftamountssql);
		$Leftamountrow = $getLeftamountresult->fetch_row();
		echo "<td>Total Left Nodes: " . $leftcountrow[0] . "; Points left on LPV : " . $Leftamountrow[0];
		 //list all the left here  
		if ($leftcountrow[0] > 0) {
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>Account ID</th>";
			echo "<th>Username</th>";
			echo "<th>Fullname</th>";
			echo "<th>Package Type</th>";
			echo "<th>LPV Points</th>";

			echo "<tr>";
			$getleftDownlinessql = "SELECT * FROM downlines WHERE parent_id='" . $accountrow['id'] . "' AND node='left'";
			$getleftDownlinesresult = $conn->query($getleftDownlinessql);
			while ($dowlineleftcountrow = $getleftDownlinesresult->fetch_assoc()) {
					/*
					$getactsql = "SELECT * FROM accounts WHERE user_id='".$dowlineleftcountrow['user_id']."' ";
					$getactresult = $conn->query($getactsql);
					$actrow = $getactresult->fetch_row();
				 */

				$getactcodesql = "SELECT * FROM activation_codes WHERE id='" . $dowlineleftcountrow['code_id'] . "' ";
				$getactcoderesult = $conn->query($getactcodesql);
				$coderow = $getactcoderesult->fetch_row();

				$getactsql = "SELECT * FROM accounts WHERE id='" . $dowlineleftcountrow['account_id'] . "' ";
				$getactresult = $conn->query($getactsql);
				$actrow = $getactresult->fetch_row();

				$getusersql = "SELECT * FROM users WHERE id='" . $actrow[1] . "' ";
				$getuserresult = $conn->query($getusersql);
				$userrow = $getuserresult->fetch_row();

				$getuserdetailssql = "SELECT * FROM user_details WHERE id='" . $userrow[3] . "' ";
				$getuserdetailsresult = $conn->query($getuserdetailssql);
				$userdetailsrow = $getuserdetailsresult->fetch_row();

				$getPointsValuesql = "SELECT points_value FROM membership_settings WHERE id='" . $userrow[15] . "'";
					//right_user_id='".$actrow[1]."' AND 
				$getPointsValueresult = $conn->query($getPointsValuesql);
				$getPointsrow = $getPointsValueresult->fetch_row();

				echo "<tr>";
				echo "<td>" . $coderow[3] . "</td>";
				echo "<td>" . $userrow[1] . "</td>";
				echo "<td>" . $userdetailsrow[2] . " " . $userdetailsrow[4] . "</td>";
				echo "<td>" . $coderow[5] . "</td>";
				echo "<th>" . $getPointsrow[0] . "</th>";

				echo "<tr>";
			}

			echo "</table>";

		}

		echo "</td>";
		$getRightamountssql = "SELECT SUM(amount) FROM earnings WHERE source='right_pv' AND user_id='" . $accountrow['user_id'] . "'";
					//right_user_id='".$actrow[1]."' AND 
		$getRightamountresult = $conn->query($getRightamountssql);
		$Rightamountrow = $getRightamountresult->fetch_row();
		echo "<td>Total Right Nodes: " . $rightcountrow[0] . "; Points left on RPV : " . $Rightamountrow[0];
                 //list all right here		
		if ($rightcountrow[0] > 0) {
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>Account ID</th>";
			echo "<th>Username</th>";
			echo "<th>Fullname</th>";
			echo "<th>Package Type</th>";
			echo "<th>RPV Points</th>";

			echo "<tr>";
			$getleftDownlinessql = "SELECT * FROM downlines WHERE parent_id='" . $accountrow['id'] . "' AND node='right'";
			$getleftDownlinesresult = $conn->query($getleftDownlinessql);
			while ($dowlineleftcountrow = $getleftDownlinesresult->fetch_assoc()) {
					/*
					$getactsql = "SELECT * FROM accounts WHERE user_id='".$dowlineleftcountrow['user_id']."' ";
					$getactresult = $conn->query($getactsql);
					$actrow = $getactresult->fetch_row();
				 */

				$getactcodesql = "SELECT * FROM activation_codes WHERE id='" . $dowlineleftcountrow['code_id'] . "' ";
				$getactcoderesult = $conn->query($getactcodesql);
				$coderow = $getactcoderesult->fetch_row();

				$getactsql = "SELECT * FROM accounts WHERE id='" . $dowlineleftcountrow['account_id'] . "' ";
				$getactresult = $conn->query($getactsql);
				$actrow = $getactresult->fetch_row();

				$getusersql = "SELECT * FROM users WHERE id='" . $actrow[1] . "' ";
				$getuserresult = $conn->query($getusersql);
				$userrow = $getuserresult->fetch_row();

				$getuserdetailssql = "SELECT * FROM user_details WHERE id='" . $userrow[3] . "' ";
				$getuserdetailsresult = $conn->query($getuserdetailssql);
				$userdetailsrow = $getuserdetailsresult->fetch_row();

				$getPointsValuesql = "SELECT points_value FROM membership_settings WHERE id='" . $userrow[15] . "'";
					//right_user_id='".$actrow[1]."' AND 
				$getPointsValueresult = $conn->query($getPointsValuesql);
				$getPointsrow = $getPointsValueresult->fetch_row();

				echo "<tr>";
				echo "<td>" . $coderow[3] . "</td>";
				echo "<td>" . $userrow[1] . "</td>";
				echo "<td>" . $userdetailsrow[2] . " " . $userdetailsrow[4] . "</td>";
				echo "<td>" . $coderow[5] . "</td>";
				echo "<td>" . $getPointsrow[0] . "</td>";

				echo "<tr>";
			}

			echo "</table>";

		}
		echo "</td>";
		echo "<td>" . $pairsnumcountrow[0];
		if ($pairsnumcountrow[0] > 0) {
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>Paired Left</th>";
			echo "<th>Paired Right</th>";
			echo "<th>MB Amount</th>";

			echo "<tr>";
			$getEarningssql = "SELECT * FROM earnings WHERE account_id='" . $accountrow['id'] . "' AND source='pairing'";
			$getEarningsresult = $conn->query($getEarningssql);
			if ($getEarningsresult->num_rows > 0) {
				while ($EarningsCountRow = $getEarningsresult->fetch_assoc()) {
						
						/*$getPairingamountssql = "SELECT SUM(amount) FROM earnings WHERE source='pairing' AND user_id='".$EarningsCountRow['user_id']."'";
						$getpairingresult = $conn->query($getPairingamountssql);
						$pairingrow = $getpairingresult->fetch_row();
					 */

					$getactLeftsql = "SELECT * FROM accounts WHERE id='" . $EarningsCountRow['left_user_id'] . "' ";
					$getactLeftresult = $conn->query($getactLeftsql);
					$actLeftrow = $getactLeftresult->fetch_row();


					$getactLeftcodesql = "SELECT * FROM activation_codes WHERE id='" . $actLeftrow[2] . "' ";
					$getactLeftcoderesult = $conn->query($getactLeftcodesql);
					$codeLeftrow = $getactLeftcoderesult->fetch_row();


					$getuserLeftsql = "SELECT * FROM users WHERE id='" . $actLeftrow[1] . "' ";
					$getuserLeftresult = $conn->query($getuserLeftsql);
					$userLeftrow = $getuserLeftresult->fetch_row();

					$getuserLeftdetailssql = "SELECT * FROM user_details WHERE id='" . $userLeftrow[3] . "' ";
					$getuserLeftdetailsresult = $conn->query($getuserLeftdetailssql);
					$userLeftdetailsrow = $getuserLeftdetailsresult->fetch_row();
						
						//for right
					$getactRightsql = "SELECT * FROM accounts WHERE id='" . $EarningsCountRow['right_user_id'] . "' ";
					$getactRightresult = $conn->query($getactRightsql);
					$actRightrow = $getactRightresult->fetch_row();


					$getactRightcodesql = "SELECT * FROM activation_codes WHERE id='" . $actRightrow[2] . "' ";
					$getactRightcoderesult = $conn->query($getactRightcodesql);
					$codeRightrow = $getactRightcoderesult->fetch_row();


					$getuserRightsql = "SELECT * FROM users WHERE id='" . $actRightrow[1] . "' ";
					$getuserRightresult = $conn->query($getuserRightsql);
					$userRightrow = $getuserRightresult->fetch_row();

					$getuserRightdetailssql = "SELECT * FROM user_details WHERE id='" . $userRightrow[3] . "' ";
					$getuserRightdetailsresult = $conn->query($getuserRightdetailssql);
					$userRightdetailsrow = $getuserRightdetailsresult->fetch_row();



					echo "<tr>";
					echo "<td>" . $codeLeftrow[3] . " : " . $userLeftrow[1] . " - " . $userLeftdetailsrow[2] . " " . $userLeftdetailsrow[4] . " ; " . $codeLeftrow[5] . "</td>";

					echo "<td>" . $codeRightrow[3] . " : " . $userRightrow[1] . " - " . $userRightdetailsrow[2] . " " . $userRightdetailsrow[4] . " ; " . $codeRightrow[5] . "</td>";

					echo "<td>" . $EarningsCountRow['amount'] . "</td>";

					echo "<tr>";
				}
			}

			echo "</table>";

		}

		echo "</td>";
		echo "<td>" . $pairsSumrow[0] . "</td>";
		echo "<td>" . $TotalAmount . "</td>";

		echo "<tr>";
		
		/*
		 $earnings = Earnings::where('source', $this->earningsPairingKey)->get();

        $ids = [];

        foreach ($earnings as $row){
            $ids[$row->account_id][] = $row->left_user_id;
            $Ids[$row->account_id][] = $row->right_user_id;
        }
		 */

        //return $ids;
		/*
		while ($upline_id > 0){

            $query = Downlines::where([
                'parent_id'=>$upline_id,
                'account_id'=>$base->id,
                'level'=>$currentLevel,
                'node'=>$node
            ])->get();

            if ($query->isEmpty()) {
                $downlines[] = [
                    'parent_id' => $upline_id,
                    'account_id' => $base->id,
                    'level' => $currentLevel,
                    'node' => $node,
                    'code_id'=>$base->code_id,
                    'created_at' => date('Y-m-d h:i:s')
                ];
            }

            $currentLevel++;
            $node = $userList[$upline_id]->node;
            $upline_id = $userList[$upline_id]->upline_id;

        }
		 */


	}
	echo "</table>";
} else {
	echo "0 results";
}
$conn->close();


?>