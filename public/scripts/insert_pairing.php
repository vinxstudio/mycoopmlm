<?php

# unused scripts
# remove die if script will be used;

die();

ini_set('max_execution_time', 30000);
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
function removeItemString($str, $item)
{
	$parts = explode(',', $str);
	foreach (array_keys($parts, $item) as $key) {
		unset($parts[$key]);
	}
/*
while(($i = array_search($item, $parts)) !== false) {
  unset($parts[$i]);
}
	 */
	return implode(',', $parts);
}

$sql = "SELECT * FROM accounts ORDER BY id ASC";
$getaccountresult = $conn->query($sql);

if ($getaccountresult->num_rows > 0) {
    // output data of each row
	while ($accountrow = $getaccountresult->fetch_assoc()) {
		$i = 0;
		$j = 0;
		$total_left_points = 0;
		$total_right_points = 0;
		$counter = 0;
		if ($accountrow['unpaired_left_ids'] != null && $accountrow['unpaired_right_ids'] != null) {
			$leftid = explode(",", $accountrow['unpaired_left_ids']);
			$rightid = explode(",", $accountrow['unpaired_right_ids']);

			while ($leftid[$i] != null && $rightid[$i] != null) {
				$checkPairingSql = "SELECT * FROM earnings WHERE source='pairing' AND account_id='" . $accountrow['id'] . "' AND left_user_id='" . $leftid[$i] . "' AND right_user_id='" . $rightid[$i] . "'";
				$checkPairingresult = $conn->query($checkPairingSql);
				if ($checkPairingresult->num_rows > 0) {
					echo "paired";

				} else {
					//insert pairing here
					//(firstname, lastname, email)

					$counter++;
					$useruplineSql = "SELECT member_type_id FROM users WHERE id='" . $accountrow['user_id'] . "'";
					$useruplineResult = $conn->query($useruplineSql);
					$uplinerow = $useruplineResult->fetch_row();

					$pairinguplineSql = "SELECT pairing_income,points_value FROM membership_settings WHERE id='" . $uplinerow[0] . "'";
					$pairinguplineResult = $conn->query($pairinguplineSql);
					$pairinguplinerow = $pairinguplineResult->fetch_row();

					$leftAcctSql = "SELECT user_id FROM accounts WHERE id='" . $leftid[$i] . "'";
					$leftAcctResult = $conn->query($leftAcctSql);
					$leftrow = $leftAcctResult->fetch_row();

					$leftDownlineSql = "SELECT member_type_id FROM users WHERE id='" . $leftrow[0] . "'";
					$leftDownlineResult = $conn->query($leftDownlineSql);
					$leftDownrow = $leftDownlineResult->fetch_row();

					$leftpairingsql = "SELECT pairing_income, points_value FROM membership_settings WHERE id='" . $leftDownrow[0] . "'";
					$leftpairingResult = $conn->query($leftpairingsql);
					$leftpairingrow = $leftpairingResult->fetch_row();

					$rightAcctSql = "SELECT user_id FROM accounts WHERE id='" . $rightid[$i] . "'";
					$rightAcctResult = $conn->query($rightAcctSql);
					$rightrow = $rightAcctResult->fetch_row();

					$rightDownlineSql = "SELECT member_type_id FROM users WHERE id='" . $rightrow[0] . "'";
					$rightDownlineResult = $conn->query($rightDownlineSql);
					$rightDownrow = $rightDownlineResult->fetch_row();

					$rightpairingsql = "SELECT pairing_income, points_value FROM membership_settings WHERE id='" . $rightDownrow[0] . "'";
					$rightpairingResult = $conn->query($rightpairingsql);
					$rightpairingrow = $rightpairingResult->fetch_row();
					


					/*
					if($pairinguplinerow[0] > 0) {
						$amount = min($pairinguplinerow[0],$leftpairingrow[0],$rightpairingrow[0]);
					} else {
						$amount = min($leftpairingrow[0],$rightpairingrow[0]);
						if ($amount <= 0) {
							$amount = max($leftpairingrow[0],$rightpairingrow[0]);
							$
						}
						
						
					}

					if upline.points = 300 .... { MB amount = minPair (upline, left, right);  
					 getRemainingPoints = minRemainingPoints(left, right);
					 pointsValueLeft = pointsLeft - minPoints(upline, minRemainingPoints); 
					 pointsValueRigh = pointsRight - minPoints(upline, minRemainingPoints);
					  }
					 */	

					/* Calculate points value */
					/*$remaining_right_points = 0;
					$remaining_left_points = 0;
					$point_generated = 0;
					$strong_leg = '';
				
					#get min upline left points
					$minLeftPoint = min($pairinguplinerow[1], $leftpairingrow[1]);

					#get min upline right points
					$minRightPoint = min($pairinguplinerow[1], $rightpairingrow[1]);

					#get diff between left and right
					if($minLeftPoint > $minRightPoint){
						$remaining_left_points = $minLeftPoint - $minRightPoint;
						$strong_leg = 'left';

					}else if($minLeftPoint < $minRightPoint){
						$remaining_right_points = $minRightPoint - $minLeftPoint;
						$strong_leg = 'right';

					}else{
						$strong_leg = 'none';
					}

					#get points generated 
					$points_generated = min($pairinguplinerow[1], $leftpairingrow[1], $rightpairingrow[1]);

					$amount = ($points_generated / 100) * 500;
					 */
					$total_left_points = $total_left_points + $leftpairingrow[1];
					$total_right_points = $total_right_points + $rightpairingrow[1];

					// $amount = min($pairinguplinerow[0],$leftpairingrow[0],$rightpairingrow[0]);
					// if($uplinerow[0] > 3 ) { 
					// 	if ($rightDownrow[0] > 3 && $leftDownrow[0] > 3) {
					// 		$amount = 0;
					// 	} else {
					// 		$amount = min($leftpairingrow[0],$rightpairingrow[0]);
					// 	}
					// } else {
					// 	$amount = min($pairinguplinerow[0],$leftpairingrow[0],$rightpairingrow[0]);
					// }
					
					
					/*else if ($rightDownrow[0] > 3 && $leftDownrow[0] > 3) {
						$amount = 0;
					} else if ($rightDownrow[0] > 3 || $leftDownrow[0] > 3) {
						$amount = $amount;
					}
					 */

					if (($counter >= 5) && ($counter % 5 == 0)) {
							//remove the first paired ids	
						echo $insertPairingSql = "INSERT INTO earnings (account_id,user_id,source,from_funding,amount,left_user_id,right_user_id,created_at)  
										  VALUES ('" . $accountrow['id'] . "','" . $accountrow['user_id'] . "','GC','false','1','" . $leftid[$i] . "','" . $rightid[$i] . "','" . date('Y-m-d H:i:s') . "')";

						if ($conn->query($insertPairingSql) === true) {
							echo "New GC Added successfully";
						} else {
							echo "Error: " . $sql . "<br>" . $conn->error;
						}

					} else {
						
							// insert to points pairing
							/*echo $insertPairingPVSql = "INSERT INTO points_pairing (account_id, user_id, left_user_id, right_user_id, remaining_left_points, remaining_right_points, points_generated, strong_leg,mb_amount,created_at) 
								VALUES (
									'".$accountrow['id']."',
									'".$accountrow['user_id']."',
									'".$leftid[$i]."',
									'".$rightid[$i]."',
									'".$remaining_left_points."',
									'".$remaining_right_points."',
									'".$points_generated."',
									'".$strong_leg."',
									'".$amount."',
									'".date('Y-m-d H:i:s')."')";

								if ($conn->query($insertPairingPVSql) === TRUE) {
									echo "New Points pairing record created successfully";
								} else {
									echo "Error: " . $insertPairingPVSql . "<br>" . $conn->error;
								}*/

						/*echo $insertPairingSql = "INSERT INTO earnings (account_id,user_id,source,from_funding,amount,left_user_id,right_user_id,created_at)  
										  VALUES ('".$accountrow['id']."','".$accountrow['user_id']."','pairing','false','".$amount."','".$leftid[$i]."','".$rightid[$i]."','".date('Y-m-d H:i:s')."')";*/

					}
					echo "</br>";
					//echo $insertPairingresult = $conn->query($insertPairingSql);

					//if ( $conn->query($insertPairingSql) === TRUE ) {
					// echo "New pairing record created successfully";
					$leftoutput = removeItemString($accountrow['unpaired_left_ids'], $leftid[$i]);
					$rightoutput = removeItemString($accountrow['unpaired_right_ids'], $rightid[$i]);
					$updateUnpairedIds = "UPDATE accounts 
										  SET unpaired_left_ids = '" . $leftoutput . "' , unpaired_right_ids = '" . $rightoutput . "'
										  WHERE id = '" . $accountrow['id'] . "'";
					$updateUnpairedIdsresult = $conn->query($updateUnpairedIds);

					if ($updateUnpairedIdsresult === true) {
						echo "New record Updated successfully";
					} else {
						echo "Error: " . $updateUnpairedIdsresult . "<br>" . $conn->error;
					}
						
						/*if($pairinguplinerow[1] > 0) {
							$amountPointsLeft = min($pairinguplinerow[1],$leftpairingrow[1]);
							$amountPointsRight = min($pairinguplinerow[1],$rightpairingrow[1]);
						} else {
							$amountPointsLeft = $leftpairingrow[1];
							$amountPointsRight = $rightpairingrow[1];
						}
						//if($amountPoints > 0) {
							//$amountPoints = 0 - $amountPoints;
							$amountPointsLeft = 0 - $amountPointsLeft;
							$amountPointsRight = 0 - $amountPointsRight;
						//}*/
						/*
						if ($getUplinePVRow[0] > 0) {
							$amount = min($getUplinePVRow[0],$memberrowPV[0]); 
						} else {
							$amount = $memberrowPV[0];
					 */
						
						/*
						$amountPointsLeft =  0 - $leftpairingrow[1];
						$amountPointsRight = 0 - $rightpairingrow[1];
					 */
						/*echo $insertLeftSql = "INSERT INTO earnings (account_id,user_id,source,from_funding,amount,left_user_id,right_user_id,created_at)  
										  VALUES ('".$accountrow['id']."','".$accountrow['user_id']."','left_pv','false','".$amountPointsLeft."','".$leftid[$i]."','".$rightid[$i]."','".date('Y-m-d H:i:s')."')";
						//remove the first paired ids	
						echo "</br>";
						//echo $insertPairingresult = $conn->query($insertPairingSql);
						if ($conn->query($insertLeftSql) === TRUE) {
							echo "New Left PV record created successfully";
						} else {
							echo "Error: " . $sql . "<br>" . $conn->error;
						}
						echo $insertRightSql = "INSERT INTO earnings (account_id,user_id,source,from_funding,amount,left_user_id,right_user_id,created_at)  
										  VALUES ('".$accountrow['id']."','".$accountrow['user_id']."','right_pv','false','".$amountPointsRight."','".$leftid[$i]."','".$rightid[$i]."','".date('Y-m-d H:i:s')."')";
						//remove the first paired ids	
						echo "</br>";
						//echo $insertPairingresult = $conn->query($insertPairingSql);
						if ($conn->query($insertRightSql) === TRUE) {
							echo "New Right PV record created successfully";
						} else {
							echo "Error: " . $sql . "<br>" . $conn->error;
						}
					 */
					// } else {
					// 	echo "Error: " . $sql . "<br>" . $conn->error;
					// }
					
					/*
					$arrayleft = array($leftid);
					$removedleft = array_shift($arrayleft);
					var_dump($removedleft);
					echo $leftoutput = implode(',', $removedleft);
					
					$arrayright = array($rightid);
					$removedright= array_shift($arrayright);
					var_dump($removedright);
					echo $rightoutput = implode(',', $removedright);
					 */
				}
				$i++;
			}

			$totalpoints = min($total_left_points, $total_right_points);
			$amount = ($totalpoints / 100) * 500;
			echo $insertPairingSql = "INSERT INTO earnings (account_id,user_id,source,from_funding,amount,left_user_id,right_user_id,created_at)  
										  VALUES ('" . $accountrow['id'] . "','" . $accountrow['user_id'] . "','pairing','false','" . $amount . "','0','0','" . date('Y-m-d H:i:s') . "')";

			if ($conn->query($insertPairingSql) === true) {
				echo "New pairing record created successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}

			echo $insertLeftSql = "INSERT INTO earnings (account_id,user_id,source,from_funding,amount,left_user_id,right_user_id,created_at)  
										  VALUES ('" . $accountrow['id'] . "','" . $accountrow['user_id'] . "','left_pv','false','" . $total_left_points . "','0','0','" . date('Y-m-d H:i:s') . "')";
						//remove the first paired ids	
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

		}
		$counter++;
	}
} else {
	echo "0 results";
}
$conn->close();


?>

