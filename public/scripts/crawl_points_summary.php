<?php

# i dunno if its used or not scripts
# so i'm just gonna change the dbname so that 
# no problem arises


# remove die if script will be used;

die();

ini_set('max_execution_time', 50000);
ini_set('memory_limit', '1024M');
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
		$left_points_value = crawl_points_summary($accounts, 'left', $conn);

		#crawl right downlines
		$right_points_value = crawl_points_summary($accounts, 'right', $conn);


		process_points_summary($account_id, $left_points_value, $right_points_value, $conn);

		crawl_points_details($accounts, $conn);
		// #calculate points paring
		// calculate_pairing($accounts, $left_downlines['ids'], $right_downlines['ids'], $conn);
		echo '-------------------------- End -------------------------------' . PHP_EOL;
	}
}

function process_points_summary($this_accountId, $lpv, $rpv, $conn)
{
	$is_contained = chk_points_summary($this_accountId, $conn);

	if (!$is_contained) {
		$data = array(
			'account_id' => $this_accountId,
			'left_points_value' => $lpv,
			'right_points_value' => $rpv,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		);

		insert_new($conn, 'points_summary', $data);
	} else {
		$updated_at = date('Y-m-d H:i:s');
		$data = "left_points_value = {$lpv}, right_points_value = {$rpv}, updated_at = '{$updated_at}'";
		$where = " account_id = {$this_accountId}";
		update_table($conn, 'points_summary', $where, $data);
	}
}

function chk_points_summary($this_accountId, $conn)
{
	$sql = "SELECT * FROM points_summary WHERE account_id = {$this_accountId}";

	$query = $conn->query($sql);

	if ($query->num_rows > 0) {
		return true;
	} else {
		return false;
	}
}

function crawl_points_summary($this_account, $node, $conn)
{
	$total_points = 0;
	$cd_ids = array();

	$this_PV = get_member_type($conn, $this_account['id']);

	$getDownlinessql = "SELECT * FROM downlines WHERE parent_id={$this_account['id']} AND node='{$node}'";
	$getDownlinesresult = $conn->query($getDownlinessql);

	if ($getDownlinesresult->num_rows > 0) {

		while ($dowlinecountrow = $getDownlinesresult->fetch_assoc()) {
			//insert all left downlines
			$thisaccountsql = "SELECT * FROM accounts WHERE id='" . $dowlinecountrow['account_id'] . "'";
			$thisaccountresult = $conn->query($thisaccountsql);
			$thisaccountrow = $thisaccountresult->fetch_row();

			$thisUsersql = "SELECT member_type_id FROM users WHERE id='" . $thisaccountrow[1] . "'";
			$thisUserresult = $conn->query($thisUsersql);
			$thisUserrow = $thisUserresult->fetch_row();

			if ($thisUserrow[0] > 3) {
				$cd_ids[] = $dowlinecountrow['account_id'];
			} else {
				#get points value
				$is_upgraded = chk_upgraded_account($dowlinecountrow['account_id'], $conn);
				if ($is_upgraded) {
					$cd_ids[] = $dowlinecountrow['account_id'];
				} else {
					$PV = get_member_type($conn, $dowlinecountrow['account_id']);
					// $new_pv = min($this_PV[0], $PV[0]);
					$total_points = $total_points + $PV[0];
				}

			}
		}

	}
	return $total_points;
}

// function crawl_points_details($this_account, $conn)
// {
// 	$ids = array();
// 	$cd_ids = array();

//     $left_pvs = array();
//     $right_pvs = array();

//     $start = true;
// 	$left_index = 0;
// 	$right_index = 0;

// 	$total_left_points = 0;
// 	$total_right_points = 0;
//     $total_points = 0;
    
//     $new_left_points = 0;
//     $new_right_points = 0;
//     $flushout_points = 0;
//     $paired_account = '';
//     $points_retention = 0;
//     $flushout_reason = '';

// 	$this_PV = get_member_type($conn, $this_account['id']);

// 	$getDownlinessql = "SELECT * FROM downlines WHERE parent_id={$this_account['id']} ORDER BY created_at";
// 	$getDownlinesresult = $conn->query($getDownlinessql);

// 	if ($getDownlinesresult->num_rows > 0) {

// 		while($dowlinecountrow = $getDownlinesresult->fetch_assoc()) {
// 			//insert all left downlines
// 			$thisaccountsql = "SELECT * FROM accounts WHERE id='".$dowlinecountrow['account_id']."'";
// 			$thisaccountresult = $conn->query($thisaccountsql);
// 			$thisaccountrow = $thisaccountresult->fetch_row();
			
// 			$thisUsersql = "SELECT * FROM users WHERE id='".$thisaccountrow[1]."'";
// 			$thisUserresult = $conn->query($thisUsersql);
//             $thisUserrow = $thisUserresult->fetch_row();
			
// 			if($thisUserrow[16] > 3) {
// 				$cd_ids[] = $dowlinecountrow['account_id'];
// 			} else {
				
// 				#get points value
// 				$is_upgraded = chk_upgraded_account($dowlinecountrow['account_id'], $conn);
// 				if($is_upgraded)
// 				{
// 					$cd_ids[] = $dowlinecountrow['account_id'];
// 				}
// 				else
// 				{
// 					// get points value
// 					$PV = get_member_type($conn, $dowlinecountrow['account_id']);
// 					$node = $dowlinecountrow['node'];
	
// 					$new_pv = min($this_PV[0], $PV[0]);
	
// 					#check flushout
// 					if($this_PV[0] < $PV[0])
// 					{
// 						$flushout_points = $PV[0] - $this_PV[0];
// 						$flushout_reason = 'Head Entry is '.$this_PV[0];
// 					}
					
// 					#check node
// 					if($node == 'left')
// 					{
// 						$new_left_points = $new_pv;
// 					}
// 					else
// 					{
// 						$new_right_points = $new_pv;
// 					}
					
// 					#get points value
// 					$points_details = getPointsDetails($this_account['id'], $conn);
// 					$p_retention = getRetentionPointsDetails($this_account['id'], $dowlinecountrow['account_id'], $node, $conn);
	
// 					if($p_retention)
// 					{
// 						$points_retention = $p_retention;
// 					}
// 					else
// 					{
// 						$points_retention = 0;
// 					}
					
// 					if(!empty($points_details))
// 					{   
						
// 						if($points_details['left_points_value'] > 0)
// 						{
// 							if($node == 'right')
// 							{   
// 								$new_left_points = abs($points_details['left_points_value'] - $new_right_points);
// 								$new_right_points = 0;
// 							}
// 							else
// 							{
// 								$new_left_points = $points_details['left_points_value'] + $new_left_points;
// 							}
						   
// 						}
// 						else if($points_details['right_points_value'] > 0)
// 						{   
// 							if($node == 'left')
// 							{
// 								$new_right_points = abs($points_details['right_points_value'] - $new_left_points);
// 								$new_left_points = 0;
// 							}
// 							else
// 							{
// 								$new_right_points = $points_details['right_points_value'] + $new_right_points;
// 							}
	
// 						}
	
// 					}
	
					
	
// 					$paired_ids = getPairedAccount($this_account['id'], $dowlinecountrow['account_id'], $node, $conn);
					
	
// 					if(!empty($paired_ids)){
// 						for($i = 0; $i < count($paired_ids); $i++)
// 						{
// 							$paired_account = $paired_account.','.$paired_ids[$i];
							
// 						}
					  
// 					}   
					
	
// 					$is_already_inserted = chk_points_details($this_account['id'], $dowlinecountrow['account_id'], $conn);
	
// 					if(!$is_already_inserted)
// 					{
// 						$data = array(
// 							'parent_account_id' => $this_account['id'],
// 							'downline_account_id' => $dowlinecountrow['account_id'],
// 							'node' => $node,
// 							'left_points_value' =>  $new_left_points,
// 							'right_points_value' => $new_right_points,
// 							'flushout_points' => $flushout_points,
// 							'retention_points' => $points_retention,
// 							'paired_account' => '',
// 							'reason_for_flushout' => $flushout_reason,
// 							'created_at' => $dowlinecountrow['created_at'],
// 							);
// 							insert_new( $conn, 'points_details', $data );    
// 							$paired_account = '';
							
// 					}
// 				}
				
				
// 			}
// 		}

// 	}

// 	return true;
// }

// function getPairedAccount($this_accountId, $member_accountId, $node, $conn){
//     $paired_ids = array();
// 	$sql = $conn->query("SELECT * FROM earnings_pairing WHERE account_id={$this_accountId} AND {$node}_account_id={$member_accountId} ORDER BY id ");
	
// 	if(!empty($sql->num_rows > 0)){

//         if($node == 'left')
//         {   
//             while($paired = $sql->fetch_assoc())
//             {
//                 $paired_ids[] = $paired["right_account_id"];
//             }
//         }
//         else
//         {
//             while($paired = $sql->fetch_assoc())
//             {
//                 $paired_ids[] = $paired["left_account_id"];
//             }
//         }
        
//         return $paired_ids;
        
// 	}else{
// 		return $paired_ids;
// 	}
// }

function getPointsDetails($this_accountId, $conn)
{
	$sql = $conn->query("SELECT * FROM points_details WHERE parent_account_id={$this_accountId} ORDER BY id Desc limit 1");
	$points_details = $sql->fetch_assoc();
	if (!empty($points_details)) {
		return $points_details;
	} else {
		return 0;
	}
}

function chk_points_details($this_accountId, $downlineId, $conn)
{
	$sql = "SELECT * FROM points_details WHERE parent_account_id = {$this_accountId} AND downline_account_id = {$downlineId}";

	$query = $conn->query($sql);

	if ($query->num_rows > 0) {
		return true;
	} else {
		return false;
	}
}

function chk_upgraded_account($account_id, $conn)
{
	$sql = "SELECT * FROM upgraded_account WHERE account_id = {$account_id}";

	$query = $conn->query($sql);

	if ($query->num_rows > 0) {
		return true;
	} else {
		return false;
	}
}

function getRetentionPointsDetails($this_accountId, $member_accountId, $node, $conn)
{
	$sql = $conn->query("SELECT * FROM points_pairing WHERE account_id={$this_accountId} AND {$node}_user_id={$member_accountId} ORDER BY id Asc limit 1");
	$points_retention = $sql->fetch_assoc();

	if (!empty($points_retention) && $points_retention["remaining_{$node}_points"] > 0) {
		return $points_retention["remaining_{$node}_points"];
	} else {
		return 0;
	}
}

function get_member_type($conn, $acc_id)
{

	$acctSql = "SELECT user_id FROM accounts WHERE id='" . $acc_id . "'";
	$acctResult = $conn->query($acctSql);
	$user_id = $acctResult->fetch_row();

	$usersql = "SELECT member_type_id FROM users WHERE id='" . $user_id[0] . "'";
	$userResult = $conn->query($usersql);
	$uplinerow = $userResult->fetch_row();

	$pairingSql = "SELECT points_value FROM membership_settings WHERE id='" . $uplinerow[0] . "'";
	$pairingResult = $conn->query($pairingSql);
	$pairingrow = $pairingResult->fetch_row();

	return $pairingrow;
}


function insert_new($conn, $table, $insData = array())
{
	if (!empty($insData)) {

		$data = parse_data($insData);

		$query = "INSERT INTO {$table} (" . $data['key'] . ") VALUES (" . $data['value'] . ")";

		if ($conn->query($query) === true) {
			echo "New points check created successfully" . PHP_EOL;
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
