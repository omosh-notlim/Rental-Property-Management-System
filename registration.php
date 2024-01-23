<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<link rel="stylesheet" type="text/css" href="login.css">

	<link rel="stylesheet" type="text/css" href="fonts/css/all.css">
	<link rel="stylesheet" href="fontboot/bootstrap-icons.css">
	<title>Registration</title>
</head>
<body>

	<div class="center-2">
		<h1><div class="logo"><a href="index">
				<b><i class="fa fa-home" aria-hidden="true"></i> <span>Manyumba</span>Housing</b></a>
			</div>
		</h1>

		<?php
			error_reporting(0);
			$errors = "";
			$errors2 = "";
			$errors3 = "";

			include 'db_connection.php';

			if(isset($_POST['register'])){
				$name = mysqli_real_escape_string($db, $_POST['name']);
				$email = mysqli_real_escape_string($db, $_POST['email']);
				$phone = mysqli_real_escape_string($db, $_POST['phone']);
				$role = 'tenant';
				$password = mysqli_real_escape_string($db, $_POST['password']);
				$conpassword = mysqli_real_escape_string($db, $_POST['conpassword']);
				$houseID = 'null';


				
				if($password !== $conpassword) {
					$errors = "Password mismatch!!";
				}


				//checking is credentials already exist
				$user_check_query = "SELECT * FROM users WHERE email=? LIMIT 1";

				//create statement
				$stmt = mysqli_stmt_init($db);

				//Prepare statement
				if (!mysqli_stmt_prepare($stmt, $user_check_query)) {
					echo "SQL statement failed";
				} else{
					// binding parameters
					mysqli_stmt_bind_param($stmt, "s", $email);
					// running parameters inside the database
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);

					$user = mysqli_fetch_assoc($result);

					if ($user) {//if user exists
						if ($user['email'] === $email) {
							$errors2 = "Sorry, user already exists!!";
						}
					}

					if ($errors != ""){
						echo "<span style='color:red; font-weight: 800'>$errors</span><br>";
					}
					if ($errors2 != ""){
						echo "<span style='color:red; font-weight: 800'>$errors2</span>";
					}
				}
							

				//create user if he/she doesn't exist
				if ($errors == "" AND $errors2 == "") {
					$query = "INSERT INTO users (name, email, phone, role, password, conpassword, houseID) VALUES (?, ?, ?, ?, ?, ?, ?)";
					
					$stmt2 = mysqli_stmt_init($db);
					if (!mysqli_stmt_prepare($stmt2, $query)) {
						echo '<script type="text/javascript">
							alert("Upload failed");
						</script>';
					} else{
						mysqli_stmt_bind_param($stmt2, "ssissss", $name, $email, $phone, $role, $password, $conpassword, $houseID);
						mysqli_stmt_execute($stmt2);
					}

					header('location: login');
				}
			}
		?>


		<form action="" method="post" enctype="multipart/form-data">
			<div class="container">
				<div class="txt-field col-2">
					<input type="text" name="name" required>
					<span></span>
					<label>Name</label>
				</div>
				<div class="txt-field col-2">
					<input type="email" name="email" required>
					<span></span>
					<label>Email</label>
				</div>
				<div class="txt-field col-2">
					<input type="number" name="phone" required>
					<span></span>
					<label>Phone number</label>
				</div>
				<div class="txt-field col-2">
					<input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" required>
					<span></span>
					<label>Password</label>
				</div>
				<div class="txt-field col-2">
					<input type="password" name="conpassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" required>
					<span></span>
					<label>Confirm password</label>
				</div>
				<input type="submit" name="register" value="Register">
				<div class="signup-link">
					<a href="login">Already registered?</a>
				</div>
			</div>
		</form>
	</div>

</body>
</html>