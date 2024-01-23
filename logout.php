<?php

session_start();
include 'db_connection.php';

if(isset($_SESSION['mail'])){
	unset($_SESSION['mail']);
}

header('Location: login');