<?php

	session_start();

	error_reporting(0);
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<link rel="stylesheet" type="text/css" href="payment.css">

	<title>Success msg</title>
    <link href="" rel="stylesheet" />
    <!-- CSS only -->
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"
    ></script>

</head>
<body>
		<div class="pay-div">
			<div class="pay-heading">
				<h1>Success</h1>
			</div>
			<form method="post" action="./stk_initiate.php">
				<div class="pay-text-area">
					<p>Transaction successfull.<br><a href="home">Click here to go back...</a></p>
				</div>

				<div class="pay-bt">
					<input type="submit" name="submit" value="Confirm transaction">
				</div>				
			</form>
		</div>
</body>
</html>