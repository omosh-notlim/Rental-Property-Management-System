<?php

	session_start();

	error_reporting(0);
	
	include 'db_connection.php';
	include 'status.php';

	if(isset($_GET['HID'])){

		$HID = mysqli_real_escape_string($db, $_GET['HID']);


		$sql = "SELECT * from houseinfo where houseID='$HID'"; 
		$res = mysqli_query($db, $sql);
		$row = mysqli_fetch_array($res);
	}
	$payer = $_SESSION['mail'];
	$respay = mysqli_query($db, "SELECT * from users WHERE email='$payer'");
	$rowpay = mysqli_fetch_array($respay)
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<link rel="stylesheet" type="text/css" href="payment.css">

	<title>Payment processing</title>
	
	<script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"
    ></script>
</head>
<body>
		<div class="pay-div">
			<div class="pay-heading">
				<h1>Rent Payment Processing</h1>
			</div>
			<form method="post" action="./stk_initiate.php">
				<div class="pay-text-area">
					<label for="houseid">House ID:</label><br>
					<input type="text" name="houseid" value="<?php echo $row["houseID"]; ?> " readonly required>
				</div>

				<div class="pay-text-area">
					<label for="tenantemail">Tenant's Email:</label><br>
					<input type="email" name="tenantemail" value="<?php echo $_SESSION['mail']; ?>" readonly required>
				</div>

				<div class="pay-text-area">
                  <label for="phone">Phone Number</label><br>
                  <input type="text" name="phone" value="254<?php echo $_rowpay['mail']; ?>">
                </div>

				<div class="pay-text-area">
					<label for="amount">Amount:</label><br>
					<input type="number" name="amount" value="1" required> <!-- value="<?php //echo $row["rent"]; ?>" -->
				</div>

				<div class="pay-text-area">
					<label for="landlordemail">Landlord's Email:</label><br>
					<input type="email" name="landlordemail" value="<?php echo $row["landlordEmail"]; ?>" readonly required>
				</div>

				<div class="pay-bt">
					<input type="submit" name="submit" value="Confirm transaction">
				</div>				
			</form>
		</div>
</body>
</html>