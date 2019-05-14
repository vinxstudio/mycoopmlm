<?php

# i dunno if its used or not scripts
# so i'm just gonna change the dbname so that 
# no problem arises
# remove die if script will be used;

die();

ini_set('max_execution_time', 300000);
//$servername = "localhost";
//$username = "root";
//$password = "";
//$dbname = "cpmpc_lite_backup";

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

// $i = $_GET['user_id'];


$sql_query = "SELECT *  FROM accounts WHERE id >= 4187";
$bases = $conn->query($sql_query);

#loop all downlines
while ($base = $bases->fetch_assoc()) {
	$base = (object)$base;
	// $sql = "SELECT * FROM accounts WHERE user_id ={$i}";
	// $result = $conn->query($sql);

	// $base = $result->fetch_object();
	echo "<br>" . $base->id;
	if (empty($base)) continue;

	$upline_id = $base->upline_id;

	$currentLevel = 1;

	$node = $base->node;

	$downlines = [];

	while ($upline_id > 0) {
		$data = [
			'parent_id' => $upline_id,
			'account_id' => $base->id,
			'level' => $currentLevel,
			'node' => $node
		];

		$checkDonline = checkDownlines($conn, $data);

		if (empty($checkDonline)) {
			$downline = [
				'parent_id' => $upline_id,
				'account_id' => $base->id,
				'level' => $currentLevel,
				'node' => $node,
				'code_id' => $base->code_id,
				'created_at' => date('Y-m-d h:i:s')
			];

			$downlines[$base->id] = $downline;

			insert_new($conn, 'downlines', $downline);
		}

		$currentLevel++;

		$upline_accounts = getUpline($conn, $upline_id);

		$node = $upline_accounts->node;
		$upline_id = $upline_accounts->upline_id;

	}

	echo "<pre>";
	print_r($downlines);

}

function getUpline($conn, $account_id)
{
	$sql = "SELECT * FROM accounts WHERE id ={$account_id}";
	$result = $conn->query($sql);

	return $result->fetch_object();
}

function checkDownlines($conn, $data)
{
	$sql = "SELECT * FROM downlines WHERE 
				parent_id ={$data['parent_id']}  
				AND account_id = {$data['account_id']}
				AND level={$data['level']}  
				AND node='{$data['node']}  '";

	$result = $conn->query($sql);
	return $result->num_rows;
}


function insert_new($conn, $table, $insData = array())
{
	if (!empty($insData)) {

		$data = parse_data($insData);

		$query = "INSERT INTO {$table} (" . $data['key'] . ") VALUES (" . $data['value'] . ")";

		if ($conn->query($query) === true) {
			echo "Downline created successfully";
		} else {
			echo "Error: " . $query . "<br>" . $conn->error;
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
