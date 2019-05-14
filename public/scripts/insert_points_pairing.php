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
};

$sql = "TRUNCATE TABLE points_pairing";
$conn->query($sql);
echo "<br> Truncate points paring";

$sql = "SELECT * FROM accounts ORDER BY id ASC";
$getaccountresult = $conn->query($sql);

if ($getaccountresult->num_rows > 0) {

	while ($accountrow = $getaccountresult->fetch_assoc()) {
		if ($accountrow['unpaired_left_ids'] != null && $accountrow['unpaired_right_ids'] != null) {

			$leftids = explode(",", $accountrow['unpaired_left_ids']);
			$rightids = explode(",", $accountrow['unpaired_right_ids']);

			$upline_info = get_member_type($conn, $accountrow['id']);

			$start = true;
			$left_index = 0;
			$right_index = 0;
			$cntr = 0;

			$total_pv_left = array();
			$total_pv_right = array();

			$total_paired_left = array();
			$total_paired_right = array();

			while ($start) {
				$cntr++;

				#get left index
				$left_id = $leftids[$left_index];

				#get right index
				$right_id = $rightids[$right_index];

				#break if left or right id is empty
				if (empty($left_id) || empty($right_id)) {
					// if($cntr == 1){

					// }else{

						// $diff_left_array = array_diff( $leftids, $total_paired_left );
						// $diff_right_array = array_diff($rightids, $total_paired_right );

						// if(empty($diff_left_array)){
						// 	$diff_left_array = '';
						// }else{
						// 	$diff_left_array = implode(',', $diff_left_array);
						// }

						// if(empty($diff_right_array)){
						// 	$diff_right_array = '';
						// }else{
						// 	$diff_right_array = implode(',', $diff_right_array);
						// }

						// echo "<br>Left Ids =". implode(',',$leftids);
						// echo "<br>Paired Left Ids =". implode(',', $total_paired_left);
						// echo "<br> Diff Left Ids = ".$diff_left_array;

						// echo "<br>Right Ids =". implode(',',$rightids);
						// echo "<br>Paired Right Ids =". implode(',', $total_paired_right);
						// echo "<br> Diff Right Ids = ".$diff_right_array;

						#update left and right
						// $data = array(
						// 			'unpaired_left_ids' => $diff_left_array,
						// 			'unpaired_right_ids' => $diff_right_array
						// 			);
						
						// $where = 'id='.$accountrow['id'];
						// update_data( $conn, 'accounts', $where, $diff_left_array,  $diff_right_array);	

					// }


					$start = false;
				} else {

					$earned_left_date = get_created_date($conn, $left_id);
					$earned_right_date = get_created_date($conn, $right_id);

					if ($earned_left_date > $earned_right_date) {
						$earned_date = $earned_left_date;
					} else {
						$earned_date = $earned_right_date;
					}

					if ($upline_info[1] != 300) {
						echo '<br> Upline ! C';
						echo '<br> Upline Points ' . $upline_info[1];
						

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

						echo '<br> Left Points = ' . $left_mem_type[1];
						echo '<br> Right Points = ' . $right_mem_type[1];

						echo '<br> Left MB = ' . $left_mem_type[0];
						echo '<br> Right MB = ' . $right_mem_type[0];

						# get strong leg
						$strong_leg = 'none';



						if ($cntr >= 5 && $cntr % 5 == 0) {
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

					} else #end if upline != 300
					{
						#upline = 300
						echo '<br> Upline - C';
						echo '<br> Upline Points ' . $upline_info[1];

						echo '<br> Left ID = ' . $left_id;
						echo '<br> Right ID = ' . $right_id;

						#check left or right id if stil has remaining points
						$left_retention_points = get_retention_points($conn, $accountrow['id'], $left_id, 'left');
						$right_retention_points = get_retention_points($conn, $accountrow['id'], $right_id, 'right');

						echo '<br> Left Retention Points = ' . $left_retention_points;
						echo '<br> Right Retention Points = ' . $right_retention_points;
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
							echo '<br> Left Points right_mem_type = ' . $right_mem_type[1];

							$left_mb_amount = $left_mem_type[0];
							$right_mb_amount = $right_mem_type[0];
						}

						echo '<br> Left Points = ' . $left_points;
						echo '<br> Right Points = ' . $right_points;

						echo '<br> Left MB = ' . $left_mb_amount;
						echo '<br> Right MB = ' . $right_mb_amount;

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

						echo '<br> Remaining Left Points = ' . $remaining_left_points;
						echo '<br> Remaining Right Points = ' . $remaining_right_points;

						#get min matching bonus
						$mb_amount = min($upline_info[0], $left_mb_amount, $right_mb_amount);

						if ($cntr >= 5 && $cntr % 5 == 0) {
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
	}
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
			echo "New pairing record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}

	}
}

function update_data($conn, $table, $where, $rm_left_ids, $rm_right_ids)
{
	if (!empty($data)) {

		echo "<br>Where = " . $where;
		echo "<br> Diff Left Ids = " . $rm_left_ids;
		echo "<br> Diff Right Ids = " . $rm_right_ids;

		$updateUnpairedIds = "UPDATE accounts 
							  SET unpaired_left_ids = '" . $rm_left_ids . "' , unpaired_right_ids = '" . $rm_right_ids . "'
							  WHERE " . $where;

		if ($conn->query($updateUnpairedIds) === true) {
			echo "{$table} table updated successfully";
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