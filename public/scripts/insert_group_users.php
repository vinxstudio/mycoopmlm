<?php

# i dunno if its used or not scripts
# so i'm just gonna change the dbname so that 
# no problem arises
# remove die if script will be used;

die();

ini_set('max_execution_time', 300000);

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

$sql_query = "SELECT users.id, users.username, user_details.first_name, user_details.last_name  
					FROM users 
					Left Join user_details on users.user_details_id = user_details.id WHERE users.group_id = 0";
$sql = $conn->query($sql_query);
$users = $sql->fetch_all();

foreach ($users as $user) {

	$username = explode("-", $user[1]);
		// echo "<pre>";
		// print_r($username);
		// die;
		#search username_id;
	$user_sql = 'SELECT * FROM users 
					Join user_details on users.user_details_id = user_details.id
					WHERE username = "' . trim($username[0]) . '"
					AND first_name = "' . trim($user[2]) . '"
					AND last_name = "' . trim($user[3]) . '"';

		// echo $user_sql;
	$result = $conn->query($user_sql);
	$new_users_id = $result->fetch_assoc();

	if (empty($new_users_id['group_id'])) {
			#check like
			#search username_id;
		$user_sql = 'SELECT * FROM users 
						Join user_details on users.user_details_id = user_details.id
						WHERE username like "%' . trim($username[0]) . '%"
						AND first_name = "' . trim($user[2]) . '"
						AND last_name = "' . trim($user[3]) . '"
						';

						// echo $user_sql;
		$result = $conn->query($user_sql);
		$new_users_id = $result->fetch_assoc();

		if (empty($new_users_id['id'])) {
			$master_id = $user[0];
		} else {
			$master_id = $new_users_id['id'];
		}
	} else {
		$master_id = $new_users_id['group_id'];
	}

	echo '<br>' . $user[2] . '-' . $user[3] . '=' . $user[0] . ':' . $user[1] . ' => ' . $username[0] . " ID => " . $master_id;

	$update_table = "UPDATE users
							  SET group_id = {$master_id} 
							  WHERE id={$user[0]}";

	if ($conn->query($update_table) === true) {
		echo "<br>users table updated successfully" . PHP_EOL;
	} else {
		echo "<br>Error: " . $conn->error;
	}

}
			
