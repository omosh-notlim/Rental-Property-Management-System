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
	<title>Forgot password</title>
</head>
<body>

	<div class="center">
		<h1><div class="logo"><a href="index">
				<b><i class="fa fa-home" aria-hidden="true"></i> <span>Manyumba</span>Housing</b></a>
			</div>
		</h1>


		<form action="https://formsubmit.co/1322c2ab0f184f986942250311898847" method="POST">
			<div class="txt-field">
				<input type="email" name="email" id="email" required>
				<span></span>
				<label>Email</label>
			</div>
			<input type="submit" name="send" value="Send">
			<div class="signup-link">
				<a href="login">Go back...</a>
			</div>
		</form>
	</div>
</body>
</html>