<?php

# i dunno if its used or not scripts
# so i'm just gonna change the dbname so that 
# no problem arises

# remove die if script will be used;

die();

ini_set('max_execution_time', 5000);

$servername = "marketingmycoop.cghlvb5xxt2e.us-east-1.rds.amazonaws.com";
$username = "mycoopuser";
$password = "1qaz45678";
$dbname = 'marketingmycoop';
#$dbname = "development_marketingmycoop";

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "cpmpc_lite_backup";

echo "<pre>";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

#get all members
$sql = "SELECT * FROM accounts 
					LEFT JOIN users ON accounts.user_id=users.id
					WHERE users.role = 'member'
					ORDER BY accounts.id ASC";
$result = $conn->query($sql);

while ($account = $result->fetch_object()) {
	// print_r($account);
	echo "</br>ACCOUNT ID = " . $account->id . " USERNAME = " . $account->username . "</br>";
	get_my_earnings($account->id, $conn);
}

#get members pairing and GC and check per cut of
function get_my_earnings($account_id, $conn)
{
	$sql = "SELECT account_id, earned_date FROM earnings 
					WHERE account_id = {$account_id} AND source IN('pairing', 'GC') 
					GROUP BY CAST(earned_date AS DATE)
					ORDER BY earned_date ASC";

	$result = $conn->query($sql);

	while ($earning = $result->fetch_object()) {
		get_earnings($earning->account_id, $earning->earned_date, $conn);

		#check cut off date
	}
}


function get_earnings($account_id, $earned_date, $conn)
{
	$c_date = explode(' ', $earned_date);
	$currentDate = $c_date[0];
	$currentTime = $c_date[1];
	
	// $tomorrow=strtotime("tomorrow");
	// $tomorrowDate = date("Y-m-d", $tomorrow);
	$tomorrowDate = date('Y-m-d', strtotime($earned_date . ' +1 day'));
	
	// $yesterday = new \DateTime('yesterday');
	// $yesterdayDate = $yesterday->format('Y-m-d');
	$yesterdayDate = date('Y-m-d', strtotime($earned_date . ' -1 day'));


	$first_start_time = '06:00:00';
	$first_cut_off_time = '18:00:00';
	$second_start_time = '18:00:01';
	$second_cut_off_time = '05:59:59';

	if ((strtotime($currentTime) > strtotime($first_cut_off_time)) || (strtotime($currentTime) < strtotime($first_start_time))) {
		if (strtotime($currentTime) > strtotime($first_cut_off_time)) {
			$from = $currentDate . ' ' . $second_start_time;
			$to = $tomorrowDate . ' ' . $second_cut_off_time;
		} else {
			$from = $yesterdayDate . ' ' . $second_start_time;
			$to = $currentDate . ' ' . $second_cut_off_time;
		}
	} else {
		$from = $currentDate . ' ' . $first_start_time;
		$to = $currentDate . ' ' . $first_cut_off_time;
	}

	$sql = "SELECT * FROM earnings 
					WHERE account_id = {$account_id} AND source IN('pairing', 'GC') 
					AND earned_date BETWEEN '{$from}' AND '{$to}'
					ORDER BY earned_date ASC";
	$result = $conn->query($sql);
	$i = 1;

	if ($result->num_rows > 0) {
		echo '</br>---------------------------------------------------</br>';
		while ($earning = $result->fetch_object()) {

			echo $i . ".) {$earned_date} = {$from} - {$to} </br>";
			print_r($earning);

			#insert to flushout
			if ($i > 7) {
				#insert to flushout
				#check if already in flush out
				$is_already_flushout = chk_flushout($earning->id, $conn);
				if (!$is_already_flushout) {
					$data = array(
						'id' => $earning->id,
						'account_id' => $earning->account_id,
						'user_id' => $earning->user_id,
						'source' => $earning->source,
						'from_funding' => $earning->from_funding,
						'amount' => $earning->amount,
						'left_user_id' => $earning->left_user_id,
						'right_user_id' => $earning->right_user_id,
						'earned_date' => $earning->earned_date,
						'created_at' => $earning->created_at
					);

					insert_new($conn, 'flushout', $data);	

					#update earnings flushout source
					$data = "source = 'flushout'";
					$where = " id = {$earning->id} AND earned_date >= '2018-06-23' ";
					update_table($conn, 'earnings', $where, $data);
				}
			}

			$i++;
			#check cut off date
		}
		echo '</br>---------------------------------------------------</br>';
	}
}

function chk_flushout($id, $conn)
{
	$sql = "SELECT * FROM flushout 
					WHERE id = {$id}";

	$query = $conn->query($sql);

	if ($query->num_rows > 0) {
		return true;
	} else {
		return false;
	}
}

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

function insert_new($conn, $table, $insData = array())
{
	if (!empty($insData)) {

		$data = parse_data($insData);

		$query = "INSERT INTO {$table} (" . $data['key'] . ") VALUES (" . $data['value'] . ")";

		if ($conn->query($query) === true) {
			// echo "New pairing record created successfully".PHP_EOL;
		} else {
			// echo "Error: " . $query . "<br>" . $conn->error;
		}

	}
}

function parse_data($insData = array())
{
		// echo "<pre>";
		// print_r($insData);

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
