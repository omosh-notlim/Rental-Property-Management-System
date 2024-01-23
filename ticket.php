<?php
	include 'db_connection.php';


	if(isset($_POST['sendticket'])){
		date_default_timezone_set('Africa/Nairobi');
		
		$name = mysqli_real_escape_string($db, $_POST['name']);
		$useremail = mysqli_real_escape_string($db, $_POST['useremail']);
		$concern = mysqli_real_escape_string($db, $_POST['concern']);
		$currentdate = date("Y-m-d H:i");
		$handler = 'admin1@gmail.com';
		$status = 'open';

		//create user if he/she doesn't exist
		$query = "INSERT INTO tickets (raisedby, email, concern, currentdate, handler, status) VALUES ('$name', '$useremail', '$concern', '$currentdate', '$handler', '$status')";
		$query_run = mysqli_query($db, $query);

        if($query_run){
            echo '<script type="text/javascript"> alert("Ticket sent successfully")</script>';
        }else{
            echo '<script type="text/javascript"> alert("Ticket not sent")</script>';
        }

		header('location: about#contact-us-now');
	}

?>