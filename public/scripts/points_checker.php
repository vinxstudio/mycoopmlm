<?php

# i dunno if its used or not scripts
# so i'm just gonna change the dbname so that 
# no problem arises

# remove die if script will be used;

die();

ini_set('max_execution_time', 7000);
ini_set('memory_limit', '256M');
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

	$sql_query = "SELECT id  FROM accounts WHERE 1";
	$sql = $conn->query($sql_query);
	$account_ids = $sql->fetch_all();

	#loop all downlines
	foreach ($account_ids as $account_id_row) {
		$account_id = $account_id_row[0];
		echo '-------------------------- Start -------------------------------' . PHP_EOL;

		echo "Account ID = " . $account_id . PHP_EOL;

		$sql_query = "SELECT * FROM accounts WHERE id=" . $account_id;
		echo $sql_query . PHP_EOL;
		$sql = $conn->query($sql_query);
		$accounts = $sql->fetch_assoc();
		// print_r($accounts);

		#crawl left downlines
		$left_downlines = crawl_downlines($accounts, 'left', $conn);

		#crawl right downlines
		$right_downlines = crawl_downlines($accounts, 'right', $conn);
		
		// echo "Left Downlines ".PHP_EOL;
		// print_r($left_downlines);

		// echo "Right Downlines ".PHP_EOL;
		// print_r($right_downlines);

		#check if points Value already exist in earnings..  
		// $Earning_LPV = getPointsValue($accounts['id'], "left_pv", $conn);
        // $Earning_RPV = getPointsValue($accounts['id'], "right_pv", $conn);
        
        // $points_checker = getPointsChecker($accounts['id'], $conn);

		if ($left_downlines['total_points'] > $right_downlines['total_points']) {
			$LPV_amount = $left_downlines['total_points'] - $right_downlines['total_points'];
			$RPV_amount = 0;
			$strong_leg = 'left';

		} else if ($right_downlines['total_points'] > $left_downlines['total_points']) {
			$RPV_amount = $right_downlines['total_points'] - $left_downlines['total_points'];
			$LPV_amount = 0;
			$strong_leg = 'right';

		} else {
			$LPV_amount = 0;
			$RPV_amount = 0;
			$strong_leg = 'none';
		}
		
		// if($Earning_LPV) process_points_value($accounts, $Earning_LPV['id'], 'left' ,$LPV_amount, $conn );
		// if($Earning_RPV) process_points_value($accounts, $Earning_RPV['id'], 'right' ,$RPV_amount, $conn );

		process_points_value($accounts, $LPV_amount, $RPV_amount, $strong_leg, $conn);
		#calculate points paring
		// calculate_pairing($accounts, $left_downlines['ids'], $right_downlines['ids'], $conn);
		echo '-------------------------- End -------------------------------' . PHP_EOL;
	}
}


# Functions
# Helpers
function crawl_downlines($this_account, $node, $conn)
{
	$ids = array();
	$cd_ids = array();

	$total_left_points = 0;
	$total_right_points = 0;
	$total_points = 0;

	$this_PV = get_member_type($conn, $this_account['id']);

	$getDownlinessql = "SELECT * FROM downlines WHERE parent_id={$this_account['id']} AND node='{$node}' ORDER BY created_at";
	// echo $getDownlinessql.PHP_EOL;
	$getDownlinesresult = $conn->query($getDownlinessql);

	if ($getDownlinesresult->num_rows > 0) {

		while ($dowlinecountrow = $getDownlinesresult->fetch_assoc()) {
			//insert all left downlines
			$thisaccountsql = "SELECT * FROM accounts WHERE id='" . $dowlinecountrow['account_id'] . "'";
			$thisaccountresult = $conn->query($thisaccountsql);
			$thisaccountrow = $thisaccountresult->fetch_row();

			$thisUsersql = "SELECT * FROM users WHERE id='" . $thisaccountrow[1] . "'";
			$thisUserresult = $conn->query($thisUsersql);
			$thisUserrow = $thisUserresult->fetch_row();

			if ($thisUserrow[16] > 3) {
				$cd_ids[] = $dowlinecountrow['account_id'];
			} else {
				$points_pairing = points_pairing($this_account['id'], $dowlinecountrow['account_id'], $node, $conn);
				if (!$points_pairing) {

					$is_upgraded = chk_upgraded_account($dowlinecountrow['account_id'], $conn);
					if ($is_upgraded) {
						$cd_ids[] = $dowlinecountrow['account_id'];
					} else {
						$ids[] = $dowlinecountrow['account_id'];

						// get points value
						$PV = get_member_type($conn, $dowlinecountrow['account_id']);

						#check if points is already in retendtion
						$retention_points = getRetentionPoints($this_account['id'], $dowlinecountrow['account_id'], $node, $conn);
						if ($retention_points) {
							$retention_PV = $retention_points;
						} else {
							$retention_PV = $PV[1];
						}
						$total_points = $total_points + min($this_PV[1], $retention_PV);
					}
				}
			}
		}

	}

	$data = array(
		'ids' => $ids,
		'total_points' => $total_points
	);

	return $data;
}

function process_points_value($this_account, $LPV_amount, $RPV_amount, $strong_leg, $conn)
{
	
	// echo "<br>total Points = ". $total_points;
	$is_exist = chk_points_checker($this_account['id'], $conn);
	if ($is_exist) {
		#update
		// $data = "left_points_value = {$LPV_amount}, right_points_value = {$RPV_amount}, strong_leg = {$strong_leg}, updated_at = '{$updated_at}'";
		// $where = " id = {$PC_id}";
		// update_table( $conn, 'points_checker', $where, $data);
		$updated_at = date('Y-m-d H:i:s');
		$where = " account_id = {$this_account['id']}";
		$table = 'points_checker';
		$update_points_value = "UPDATE {$table}
							  SET left_points_value = '" . $LPV_amount . "' , right_points_value = '" . $RPV_amount . "', strong_leg = '" . $strong_leg . "', updated_at = '" . $updated_at . "'
							  WHERE " . $where;

		if ($conn->query($update_points_value) === true) {
			echo "{$table} table updated successfully" . PHP_EOL;
		} else {
			echo "Error: " . $conn->error;
		}

	} else {
		#insert PV
		$data = array(
			'account_id' => $this_account['id'],
			'left_points_value' => $LPV_amount,
			'right_points_value' => $RPV_amount,
			'strong_leg' => $strong_leg,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		);

		insert_new($conn, 'points_checker', $data);
	}
}

function chk_points_checker($this_accountId, $conn)
{
	$sql = "SELECT * FROM points_checker WHERE account_id = {$this_accountId}";

	$query = $conn->query($sql);

	if ($query->num_rows > 0) {
		return true;
	} else {
		return false;
	}
}

function getPointsChecker($this_accountId, $conn)
{
	$sql = $conn->query("SELECT * FROM points_checker WHERE account_id={$this_accountId}");
	if ($sql->num_rows > 0) {
		$PV = $sql->fetch_assoc();
	} else {
		$PV = false;
	}

	return $PV;
}

function chk_upgraded_account($this_accountId, $conn)
{
	$sql = "SELECT * FROM upgraded_account WHERE account_id = {$this_accountId}";

	$query = $conn->query($sql);

	if ($query->num_rows > 0) {
		return true;
	} else {
		return false;
	}
}
/*function crawl_downlines($this_account, $node, $conn){
	$ids = array();
	$cd_ids = array();

	$total_left_points = 0;
	$total_right_points = 0;
	$total_points = 0;

	$this_PV = get_member_type($conn, $this_account['id']);

	$getDownlinessql = "SELECT * FROM downlines WHERE parent_id={$this_account['id']} AND node='{$node}'";
	echo $getDownlinessql.PHP_EOL;
	$getDownlinesresult = $conn->query($getDownlinessql);

	if ($getDownlinesresult->num_rows > 0) {

		while($dowlinecountrow = $getDownlinesresult->fetch_assoc()) {
			//insert all left downlines
			$thisaccountsql = "SELECT * FROM accounts WHERE id='".$dowlinecountrow['account_id']."'";
			$thisaccountresult = $conn->query($thisaccountsql);
			$thisaccountrow = $thisaccountresult->fetch_row();
			
			$thisUsersql = "SELECT * FROM users WHERE id='".$thisaccountrow[1]."'";
			$thisUserresult = $conn->query($thisUsersql);
			$thisUserrow = $thisUserresult->fetch_row();
			
			if($thisUserrow[16] > 3) {
				$cd_ids[] = $dowlinecountrow['account_id'];
			} else {
				$points_pairing = points_pairing($this_account['id'], $dowlinecountrow['account_id'], $node, $conn);

				$chkearnings = chkearnings($this_account['id'], $dowlinecountrow['account_id'], $node, $conn);

				$retention_points = getRetentionPoints($this_account['id'], $dowlinecountrow['account_id'], $node, $conn);

				if($thisUserrow[16] == 3){

					if(!$points_pairing ){

						$ids[] = $dowlinecountrow['account_id'];

						// get points value
						$PV = get_member_type($conn, $dowlinecountrow['account_id']);

						#check if points is already in retendtion
						
						if($retention_points){
							$retention_PV = $retention_points;
						}else{
							$retention_PV = $PV[1];
						}
						$total_points = $total_points + min($this_PV[1], $retention_PV);
					}
				}else{
					if(empty($chkearnings)){
						$ids[] = $dowlinecountrow['account_id'];
						$retention_PV = $PV[1];
						$total_points = $total_points + min($this_PV[1], $retention_PV);
					}
					
				}

			}
		}

	}

	$data = array(
			'ids' => $ids,
			'total_points' => $total_points
			);

	return $data;
}*/

// function process_points_value($this_account, $PV_id, $node ,$PV_amount, $conn ){
	
// 	// echo "<br>total Points = ". $total_points;
// 	if(!empty($PV_id) && $PV_id){
// 		#update
// 		$data = "amount = {$PV_amount}";
// 		$where = " id = {$PV_id}";
// 		update_table( $conn, 'earnings', $where, $data);

// 	}else{
// 		#insert PV
// 		$data = array(
// 					'account_id' => $this_account['id'],
// 					'user_id' => $this_account['user_id'],
// 					'source' => $node.'_pv',
// 					'from_funding' => 'false',
// 					'amount' => $PV_amount,
// 					'left_user_id' => 0,
// 					'right_user_id' => 0,
// 					'created_at' => date('Y-m-d H:i:s')
// 					);

// 		insert_new( $conn, 'earnings', $data );
// 	}
// }

function getRetentionPoints($this_accountId, $member_accountId, $node, $conn)
{
	$sql = $conn->query("SELECT * FROM points_pairing WHERE account_id={$this_accountId} AND {$node}_user_id={$member_accountId} ORDER BY id Desc limit 1");
	$points_pairing = $sql->fetch_assoc();

	if (!empty($points_pairing) && $points_pairing["remaining_{$node}_points"] > 0) {
		return $points_pairing["remaining_{$node}_points"];
	} else {
		return 0;
	}
}

function getPointsValue($this_accountId, $source, $conn)
{
	$sql = $conn->query("SELECT * FROM earnings WHERE account_id={$this_accountId} AND source='{$source}'");
	if ($sql->num_rows > 0) {
		$PV = $sql->fetch_assoc();
	} else {
		$PV = false;
	}

	return $PV;
}
function chkearnings($this_accountID, $member_accountId, $node, $conn)
{
	$sql = "SELECT * FROM earnings 
				WHERE account_id={$this_accountID}
				AND {$node}_user_id ={$member_accountId}";

	$result = $conn->query($sql);
	return $result->num_rows;
}

function points_pairing($this_accountID, $member_accountId, $node, $conn)
{
	$sql = $conn->query("SELECT * FROM points_pairing WHERE account_id={$this_accountID} AND {$node}_user_id={$member_accountId} ORDER BY id Desc limit 1");
	$points_pairing = $sql->fetch_assoc();

	if (!empty($points_pairing) && $points_pairing["remaining_{$node}_points"] == 0) {
		return true;
	} else {
		return false;
	}
}


function calculate_pairing($accountrow, $left_ids, $right_ids, $conn)
{
	$start = true;
	$left_index = 0;
	$right_index = 0;

	$total_pv_left = array();
	$total_pv_right = array();

	$total_paired_left = array();
	$total_paired_right = array();

	#upline Info
	$upline_info = get_member_type($conn, $accountrow['id']);

	while ($start) {

		#get left index
		$left_id = (!empty($left_ids[$left_index])) ? $left_ids[$left_index] : null;

		#get right index
		$right_id = (!empty($right_ids[$right_index])) ? $right_ids[$right_index] : null;

		#break if left or right id is empty
		if (empty($left_id) || empty($right_id)) {
			$start = false;
		} else {
			$earned_left_date = get_created_date($conn, $left_id);
			$earned_right_date = get_created_date($conn, $right_id);

			if ($earned_left_date > $earned_right_date) {
				$earned_date = $earned_left_date;
				if ($earned_date < '2018-06-07 00:00:00') {
					$earned_date = '2018-06-07 11:57:05';
				}
			} else {
				$earned_date = $earned_right_date;
				if ($earned_date < '2018-06-07 00:00:00') {
					$earned_date = '2018-06-07 11:57:05';
				}
			}

			$sql_earnings = $conn->query("SELECT * FROM earnings WHERE account_id={$accountrow['id']} AND source IN('GC','pairing')");
			$countAllEarnings = $sql_earnings->num_rows;

			$cntr = $countAllEarnings + 1;

			if ($upline_info[1] != 300) {
				echo '<br> Upline ! C' . PHP_EOL;
				echo '<br> Upline Points ' . $upline_info[1] . PHP_EOL;
				

				#break if left or right id is empty
				if (empty($left_id) || empty($right_id)) {
					$start = false;
					continue;
				} 

				#get member type for left and right id
				$left_mem_type = get_member_type($conn, $left_id);
				$right_mem_type = get_member_type($conn, $right_id);

				#get min points value 
				$remaining_left_points = min($upline_info[1], $left_mem_type[1]);
				$remaining_right_points = min($upline_info[1], $right_mem_type[1]);

				$points_generated = min($remaining_left_points, $remaining_right_points);

				#get min points value 
				$points_generated = min($upline_info[1], $left_mem_type[1], $right_mem_type[1]);

				#get min matching bonus
				$mb_amount = min($upline_info[0], $left_mem_type[0], $right_mem_type[0]);

				#get remaining points left and right
				$remaining_left_points = 0;
				$remaining_right_points = 0;

				echo '<br> Left Points = ' . $left_mem_type[1] . PHP_EOL;
				echo '<br> Right Points = ' . $right_mem_type[1] . PHP_EOL;

				echo '<br> Left MB = ' . $left_mem_type[0] . PHP_EOL;
				echo '<br> Right MB = ' . $right_mem_type[0] . PHP_EOL;

				# get strong leg
				$strong_leg = 'none';



				if ($cntr >= 5 && $cntr % 5 == 0) {
					#insert to points pairing
					$data_pp = array(
						'account_id' => $accountrow['id'],
						'user_id' => $accountrow['user_id'],
						'left_user_id' => $left_id,
						'right_user_id' => $right_id,
						'remaining_left_points' => $remaining_left_points,
						'remaining_right_points' => $remaining_right_points,
						'points_generated' => $points_generated,
						'strong_leg' => $strong_leg,
						'mb_amount' => 0,
						'created_at' => date('Y-m-d H:i:s')
					);
					insert_new($conn, 'points_pairing', $data_pp);

					#insert GC points
					$data = array(
						'account_id' => $accountrow['id'],
						'user_id' => $accountrow['user_id'],
						'source' => 'GC',
						'from_funding' => 'false',
						'amount' => 1,
						'left_user_id' => $left_id,
						'right_user_id' => $right_id,
						'earned_date' => $earned_date,
						'created_at' => date('Y-m-d H:i:s')
					);

					insert_new($conn, 'earnings', $data);

				} else {
					#insert to points pairing
					$data_pp = array(
						'account_id' => $accountrow['id'],
						'user_id' => $accountrow['user_id'],
						'left_user_id' => $left_id,
						'right_user_id' => $right_id,
						'remaining_left_points' => $remaining_left_points,
						'remaining_right_points' => $remaining_right_points,
						'points_generated' => $points_generated,
						'strong_leg' => $strong_leg,
						'mb_amount' => $mb_amount,
						'created_at' => date('Y-m-d H:i:s')
					);

					insert_new($conn, 'points_pairing', $data_pp);

					#insert into earnings
					$data = array(
						'account_id' => $accountrow['id'],
						'user_id' => $accountrow['user_id'],
						'source' => 'pairing',
						'from_funding' => 'false',
						'amount' => $mb_amount,
						'left_user_id' => $left_id,
						'right_user_id' => $right_id,
						'earned_date' => $earned_date,
						'created_at' => date('Y-m-d H:i:s')
					);

					insert_new($conn, 'earnings', $data);
				}

				$total_paired_left[] = $left_id;
				$total_paired_right[] = $right_id;

				$left_index++;
				$right_index++;

			} else {
				#end if upline != 300
				#upline = 300
				echo '<br> Upline - C' . PHP_EOL;
				echo '<br> Upline Points ' . $upline_info[1] . PHP_EOL;

				echo '<br> Left ID = ' . $left_id . PHP_EOL;
				echo '<br> Right ID = ' . $right_id . PHP_EOL;

				#check left or right id if stil has remaining points
				$left_retention_points = get_retention_points($conn, $accountrow['id'], $left_id, 'left');
				$right_retention_points = get_retention_points($conn, $accountrow['id'], $right_id, 'right');

				echo '<br> Left Retention Points = ' . $left_retention_points . PHP_EOL;
				echo '<br> Right Retention Points = ' . $right_retention_points . PHP_EOL;
				#calculate if left or right acount has retention points
				if ($left_retention_points > 0 || $right_retention_points > 0) {

					if ($left_retention_points > 0) {

						$right_mem_type = get_member_type($conn, $right_id);

						$left_points = $left_retention_points;
						$right_points = $right_mem_type[1];

						$left_mb_amount = ($left_points / 100) * 500;
						$right_mb_amount = $right_mem_type[0];

					} else {

						$left_mem_type = get_member_type($conn, $left_id);

						$left_points = $left_mem_type[1];
						$right_points = $right_retention_points;

						$left_mb_amount = $left_mem_type[0];
						$right_mb_amount = ($right_points / 100) * 500;
					}
				} else {
					#get member type for left and right id
					$left_mem_type = get_member_type($conn, $left_id);
					$right_mem_type = get_member_type($conn, $right_id);

					$left_points = $left_mem_type[1];
					$right_points = $right_mem_type[1];
					echo '<br> Left Points right_mem_type = ' . $right_mem_type[1] . PHP_EOL;

					$left_mb_amount = $left_mem_type[0];
					$right_mb_amount = $right_mem_type[0];
				}

				echo '<br> Left Points = ' . $left_points . PHP_EOL;
				echo '<br> Right Points = ' . $right_points . PHP_EOL;

				echo '<br> Left MB = ' . $left_mb_amount . PHP_EOL;
				echo '<br> Right MB = ' . $right_mb_amount . PHP_EOL;

				#get remaining points left and right
				$remaining_left_points = min($upline_info[1], $left_points);
				$remaining_right_points = min($upline_info[1], $right_points);

				#get min points value 
				$points_generated = min($remaining_left_points, $remaining_right_points);

				if ($remaining_left_points > $remaining_right_points) {

					$remaining_left_points = $remaining_left_points - $remaining_right_points;
					$remaining_right_points = 0;
					
					#increment right index if left index has retention points
					$right_index++;
					$total_paired_right[] = $right_id;
					# get strong leg
					$strong_leg = 'left';


				} else if ($remaining_right_points > $remaining_left_points) {

					$remaining_right_points = $remaining_right_points - $remaining_left_points;
					$remaining_left_points = 0;

					#increment left index if right index has retention points
					$left_index++;
					$total_paired_left[] = $left_id;
					# get strong leg
					$strong_leg = 'right';

				} else {
					$remaining_left_points = 0;
					$remaining_right_points = 0;

					#increment both left and right index for they don't have any retention points
					$left_index++;
					$right_index++;

					$total_paired_left[] = $left_id;
					$total_paired_right[] = $right_id;

					# get strong leg
					$strong_leg = 'none';
				}

				echo '<br> Remaining Left Points = ' . $remaining_left_points . PHP_EOL;
				echo '<br> Remaining Right Points = ' . $remaining_right_points . PHP_EOL;

				#get min matching bonus
				$mb_amount = min($upline_info[0], $left_mb_amount, $right_mb_amount);

				if ($cntr >= 5 && $cntr % 5 == 0) {
					#insert to points pairing
					$data_pp = array(
						'account_id' => $accountrow['id'],
						'user_id' => $accountrow['user_id'],
						'left_user_id' => $left_id,
						'right_user_id' => $right_id,
						'remaining_left_points' => $remaining_left_points,
						'remaining_right_points' => $remaining_right_points,
						'points_generated' => $points_generated,
						'strong_leg' => $strong_leg,
						'mb_amount' => 0,
						'created_at' => date('Y-m-d H:i:s')
					);
					insert_new($conn, 'points_pairing', $data_pp);
					
					#insert GC points
					$data = array(
						'account_id' => $accountrow['id'],
						'user_id' => $accountrow['user_id'],
						'source' => 'GC',
						'from_funding' => 'false',
						'amount' => 1,
						'left_user_id' => $left_id,
						'right_user_id' => $right_id,
						'earned_date' => $earned_date,
						'created_at' => date('Y-m-d H:i:s')
					);

					insert_new($conn, 'earnings', $data);

				} else {
					#insert to points pairing
					$data_pp = array(
						'account_id' => $accountrow['id'],
						'user_id' => $accountrow['user_id'],
						'left_user_id' => $left_id,
						'right_user_id' => $right_id,
						'remaining_left_points' => $remaining_left_points,
						'remaining_right_points' => $remaining_right_points,
						'points_generated' => $points_generated,
						'strong_leg' => $strong_leg,
						'mb_amount' => $mb_amount,
						'created_at' => date('Y-m-d H:i:s')
					);

					insert_new($conn, 'points_pairing', $data_pp);

					#insert into earnings
					$data = array(
						'account_id' => $accountrow['id'],
						'user_id' => $accountrow['user_id'],
						'source' => 'pairing',
						'from_funding' => 'false',
						'amount' => $mb_amount,
						'left_user_id' => $left_id,
						'right_user_id' => $right_id,
						'earned_date' => $earned_date,
						'created_at' => date('Y-m-d H:i:s')
					);

					insert_new($conn, 'earnings', $data);
				}
			}
		}

	} #end while
}

function get_created_date($conn, $id)
{

	$acctSql = "SELECT created_at FROM accounts WHERE id='" . $id . "'";
	$acctResult = $conn->query($acctSql);
	$accounts = $acctResult->fetch_row();

	return $accounts[0];
}

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

function get_retention_points($conn, $u_acc_id, $donwline_acc_id, $strong_leg)
{

	$sql = "SELECT remaining_{$strong_leg}_points FROM points_pairing WHERE account_id='" . $u_acc_id . "' AND {$strong_leg}_user_id = {$donwline_acc_id} ORDER BY id DESC limit 1";

	$query = $conn->query($sql);

	if ($query->num_rows > 0) {
		$result = $query->fetch_row();
		return $result[0];
	} else {
		return 0;
	}
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
