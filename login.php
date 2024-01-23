<?php
	session_start();
	error_reporting(0);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<link rel="stylesheet" type="text/css" href="login.css">

	<link rel="stylesheet" type="text/css" href="fonts/css/all.css">
	<link rel="stylesheet" href="fontboot/bootstrap-icons.css">
	<title>Login</title>
</head>
<body>

	<div class="center">
		<h1><div class="logo"><a href="index">
				<b><i class="bi bi-house-door"></i>  <span>Manyumba</span>Housing</b></a>
			</div>
		</h1>

		<?php
			$errors = "";
	
			include 'db_connection.php';

			if (isset($_POST['login'])) {
				date_default_timezone_set('Africa/Nairobi');

				//preventing mysqli injection
				$email = mysqli_real_escape_string($db, $_POST['email']);
				$password = mysqli_real_escape_string($db, $_POST['password']);

				$email = stripcslashes($email);
				$password = stripcslashes($password);
				
				

				$query = "SELECT * FROM users WHERE email=? AND password=?";
		
				$stmt = mysqli_stmt_init($db);

				if (!mysqli_stmt_prepare($stmt, $query)) {
					echo "SQL statement failed";
				} else{
					mysqli_stmt_bind_param($stmt, "ss", $email, $password);

					mysqli_stmt_execute($stmt);
					$results = mysqli_stmt_get_result($stmt);

					if (mysqli_num_rows($results) == 1){

						$row = mysqli_fetch_array($results);

						if($row['role']=='admin'){
							$_SESSION['mail'] = $row['email'];
							$email1 = $_SESSION['mail'];
							$timein1 = date("Y-m-d H:i:s");

							$query = "UPDATE users SET lastlogin='$timein1', status='online' WHERE email='$email1'";
							$query_run = mysqli_query($db, $query);

							header("location: dashboard");
							// header( "refresh:5;url=https://manyumbahousing.000webhostapp.com/dashboard" );
						}
						elseif($row['role']=='tenant'){
							$_SESSION['mail'] = $row['email'];
							$email2 = $_SESSION['mail'];
							$timein2 = date("Y-m-d H:i:s");

							$query = "UPDATE users SET lastlogin='$timein2', status='online' WHERE email='$email2'";
							$query_run = mysqli_query($db, $query);

							header("location: home");
				// 			header( "refresh:5;url=https://manyumbahousing.000webhostapp.com/home" );	
						}
						elseif($row['role']=='landlord'){
							$_SESSION['mail'] = $row['email'];
							$email3 = $_SESSION['mail'];
							$timein3 = date("Y-m-d H:i:s");

							$query = "UPDATE users SET lastlogin='$timein3', status='online' WHERE email='$email3'";
							$query_run = mysqli_query($db, $query);

							header("location: landlord");
				// 			header( "refresh:5;url=https://manyumbahousing.000webhostapp.com/landlord" );
						}
					}else{
						$errors = "Wrong credentials!!";
					}

					if ($errors != ""){
						echo "<span style='color:red; font-weight: 800'>$errors</span>";
					}	
				}
			}	
		?>			


		<form action="#" method="post">
			<div class="txt-field">
				<input type="email" name="email" required>
				<span></span>
				<label>Email</label>
			</div>
			<div class="txt-field">
				<input type="password" name="password" required>
				<span></span>
				<label>Password</label>
			</div>
			<div class="pass">
				<a href="forgot">Forgot Password?</a>
			</div>
			<input type="submit" name="login" value="Login">
			<div class="signup-link">
				<a href="registration">Sign up</a>
			</div>
			<div class="signup-link">
				<a href="index">Home</a>
			</div>
		</form>
	</div>
</body>
</html>