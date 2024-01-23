<?php
	
	session_start();

	include 'db_connection.php';

	date_default_timezone_set('Africa/Nairobi');

	if(isset($_SESSION['mail'])){
		$current_user555 = $_SESSION['mail'];
		$date555 = date("Y-m-d H:i:s");

		$query555 = "UPDATE users SET lastactivity='$date555' WHERE email='$current_user555'";
		$query_run555 = mysqli_query($db, $query555);
	}
	
	$mydate52 = date("Y-m-d H:i:s");

	$myquery52 = "UPDATE users SET status='offline' WHERE TIMESTAMPDIFF(MINUTE, lastactivity, '$mydate52') > 30";
	$myquery_run52 = mysqli_query($db, $myquery52);

	$myquery522 = "UPDATE users SET status='online' WHERE TIMESTAMPDIFF(MINUTE, lastactivity, '$mydate52') < 30";
	$myquery_run522 = mysqli_query($db, $myquery522);
?>