<?php

# unused scripts
# remove die if script will be used;

die();

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

$sql = "SELECT id, user_id, upline_id, sponsor_id, node, created_at FROM accounts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	while ($row = $result->fetch_assoc()) {
		$sql2 = "SELECT type_id FROM activation_codes WHERE user_id=" . $row['user_id'];
		echo $sql2;
		$result2 = $conn->query($sql2);
		$memberrow = $result2->fetch_row();

		$getMemberDR = "SELECT referral_income, points_value FROM membership_settings WHERE id  = '" . $memberrow[0] . "'";
		$getMemberDRresult2 = $conn->query($getMemberDR);
		$memberrowDR = $getMemberDRresult2->fetch_row();

		$sponsorAccountselectsql = "SELECT id, user_id FROM accounts WHERE id=" . $row['sponsor_id'];
		$sponsorAccountresult = $conn->query($sponsorAccountselectsql);
		$sponsorAccountrow = $sponsorAccountresult->fetch_row();

		$sponsorUser = "SELECT type_id FROM activation_codes WHERE user_id='" . $sponsorAccountrow[1] . "'";
		echo $sponsorUser;
		$sponsorUserresult = $conn->query($sponsorUser);
		$sponsorrow = $sponsorUserresult->fetch_row();

		$getSponsorDR = "SELECT referral_income, points_value FROM membership_settings WHERE id = '" . $sponsorrow[0] . "'";
		$getSponsorDRresult2 = $conn->query($getSponsorDR);
		$sponsorrowDR = $getSponsorDRresult2->fetch_row();

		if ($memberrow[0] > 3) {
			$amount = 0;
		} else {
			$amount = min($sponsorrowDR[0], $memberrowDR[0]);
		}
		
		
		//insert to direct referral to the account of upline
		$sql4 = "INSERT INTO earnings (account_id, user_id, source,amount, left_user_id, earned_date, created_at)
					VALUES (" . $sponsorAccountrow[0] . ", " . $sponsorAccountrow[1] . ", 'direct_referral'," . $amount . "," . $row['id'] . ", '" . $row['created_at'] . "','" . date('Y-m-d H:i:s') . "')";

		echo "</br>" . $sql4;
		if ($conn->query($sql4) === true) {
			echo "New record created successfully";

		} else {
			echo "Error: " . $sql4 . "<br>" . $conn->error;
		}
	}
} else {
	echo "0 results";
}
$conn->close();


?>