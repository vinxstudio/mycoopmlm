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

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT earnings.* FROM earnings 
		Join accounts on accounts.id = earnings.left_user_id
		Join users on users.id = accounts.user_id
		AND earnings.source IN('pairing','GC')
		/*AND users.member_type_id > 3*/
		AND earnings.created_at >= '2018-05-17 00:00:00'
		ORDER BY earnings.id DESC";
$result = $conn->query($sql);

echo "<pre> Left ";
while ($data = $result->fetch_assoc()) {

	$data['updated_at'] = date('Y-m-d H:i:s');

	if (checkIfPaired($conn, $data['id']) == 0) continue;

	echo "Left";
	print_r($data);

	insert_new($conn, 'earnings_cds', $data);

	$rm_sql = "DELETE FROM `earnings` WHERE id={$data['id']} Limit 1";
	$conn->query($rm_sql);

}

$sql = "SELECT earnings.* FROM earnings 
		Join accounts on accounts.id = earnings.right_user_id
		Join users on users.id = accounts.user_id
		AND earnings.source IN('pairing','GC')
		/*AND users.member_type_id > 3*/
		AND earnings.created_at >= '2018-05-17 00:00:00'
		ORDER BY earnings.id DESC";
$result = $conn->query($sql);

echo "<pre> Right ";
while ($data = $result->fetch_assoc()) {

	$data['updated_at'] = date('Y-m-d H:i:s');

	if (checkIfPaired($conn, $data['id']) == 0) continue;

	echo "Right";
	print_r($data);

	insert_new($conn, 'earnings_cds', $data);

	$rm_sql = "DELETE FROM `earnings` WHERE id={$data['id']} Limit 1";
	$conn->query($rm_sql);
}

// ----------------------------------------------------------------------------------
echo "<br> remove points value";

$sql = "SELECT points_pairing.* FROM points_pairing 
		Join accounts on accounts.id = points_pairing.left_user_id
		Join users on users.id = accounts.user_id
		/*AND users.member_type_id > 3*/
		AND points_pairing.created_at >= '2018-05-17 00:00:00'
		ORDER BY points_pairing.id DESC";
$result = $conn->query($sql);

echo "<pre> Left ";
while ($data = $result->fetch_assoc()) {

	$data['updated_at'] = date('Y-m-d H:i:s');

	if (checkIfPairedPP($conn, $data['id']) == 0) continue;

	echo "Left";
	print_r($data);

	insert_new($conn, 'points_pairing_cds', $data);

	$rm_sql = "DELETE FROM `points_pairing` WHERE id={$data['id']} Limit 1";
	$conn->query($rm_sql);

}


$sql = "SELECT points_pairing.* FROM points_pairing 
		Join accounts on accounts.id = points_pairing.right_user_id
		Join users on users.id = accounts.user_id
		/*AND users.member_type_id > 3*/
		AND points_pairing.created_at >= '2018-05-17 00:00:00'
		ORDER BY points_pairing.id DESC";
$result = $conn->query($sql);

echo "<pre> Right ";
while ($data = $result->fetch_assoc()) {

	$data['updated_at'] = date('Y-m-d H:i:s');

	if (checkIfPairedPP($conn, $data['id']) == 0) continue;

	echo "Right";
	print_r($data);

	insert_new($conn, 'points_pairing_cds', $data);

	$rm_sql = "DELETE FROM `points_pairing` WHERE id={$data['id']} Limit 1";
	$conn->query($rm_sql);
}
// ---------------------------- remove multiple functions --------------------------------------

// $sql = "SELECT accounts.*, users.member_type_id FROM accounts 
// 		Join users on users.id = accounts.user_id
// 		ORDER BY accounts.id ASC";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     // output data of each row
//     while($accountrow = $result->fetch_assoc()) {

//     	#scan accounts earnings
//     }
// }


// ----------------------------------- functions -----------------------------------------------
function getEarnings($conn, $account_id)
{
	$sql = "SELECT * FROM earnings
				WHERE account_id = {$account_id}";

	$result = $conn->query($sql);
	return $result->num_rows;
}
function checkIfPaired($conn, $earnings_id)
{
	$sql = "SELECT * FROM earnings 
				WHERE id={$earnings_id}";

	$result = $conn->query($sql);
	return $result->num_rows;
}

function checkIfPairedPP($conn, $id)
{
	$sql = "SELECT * FROM points_pairing 
				WHERE id={$id}";

	$result = $conn->query($sql);
	return $result->num_rows;
}

function insert_new($conn, $table, $insData = array())
{
	if (!empty($insData)) {

		$data = parse_data($insData);

		$query = "INSERT INTO {$table} (" . $data['key'] . ") VALUES (" . $data['value'] . ")";

		if ($conn->query($query) === true) {
			return "New pairing record created successfully" . PHP_EOL;
		} else {
			return "Error: " . $query . "<br>" . $conn->error;
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

