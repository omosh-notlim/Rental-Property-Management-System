<?php
	session_start();
	error_reporting(0);

	include 'db_connection.php';
	include 'status.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="adminPanel.css">
	
	<link rel="stylesheet" href="fontboot/bootstrap-icons.css">
	<title>User management</title>
</head>
<body>
	<div class="btn">
		<i class="bi bi-list"></i>
		<i class="bi bi-x"></i>
	</div>
	<nav class="sidebar">
		<div class="text"><i class="bi bi-person-circle"></i> 
			<?php

			if(isset($_SESSION['mail'])){
				echo $_SESSION['mail'];
			}

			?>
		</div>
		<ul>
			<li><a href="dashboard"><i class="bi bi-windows"></i>  Dashboard</a></li>
			<li><a href="landlordreports"><i class="bi bi-graph-down-arrow"></i> Landlord reports</a></li>
			<li><a href="ticketreading"><i class="bi bi-ticket-perforated"></i> View tickets</a></li>
			<li><a href="paymentview"><i class="bi bi-cash-coin"></i> Payment view</a></li>
			<li><a href="adminpanel"><i class="bi bi-house-door"></i> House management</a></li>
            <li>
				<a href="#" class="feat-btn user-mng"><i class="bi bi-people-fill"></i>
					User management <i class="bi bi-caret-down-fill"></i>
				</a>
				<ul class="feat-show">
					<li><a href="#userDetails">Add user</a></li>
					<li><a href="#updateUser">Update user</a></li>
					<!-- <li><a href="#houseSearch">Search user</a></li> -->
				</ul>
			</li>
			<li><a href="home"><i class="bi bi-house-fill"></i> Houses</a></li>
			<li><a href="about#contact-us-now"><i class="bi bi-body-text"></i> Raise ticket</a></li>
			<li><a class="dropdown-item" href="profile"><i class="bi bi-person-lines-fill"></i>   Profile</a></li>
			<li><a href="logout"><i class="bi bi-toggles2"></i>   Switch account</a></li>
			<br>
			<br>
			<li><a href="logout">Logout <i class="bi bi-power"></i></a></li>
		</ul>
	</nav>

	<div class="content-area">
		<div class="wrapper">

			<div id="addUser" class="myForm">
				<form action="" method="post" enctype="multipart/form-data">
					<fieldset>
						<legend>ADD USER:</legend>
						<?php
				$errors = "";
				$errors2 = "";
				$errors3 = "";

				include 'db_connection.php';

				if(isset($_POST['submit'])){
					if(isset($_SESSION['mail'])){
						$name = mysqli_real_escape_string($db, $_POST['name']);
						$email = mysqli_real_escape_string($db, $_POST['email']);
						$phone = mysqli_real_escape_string($db, $_POST['phone']);
						$role = mysqli_real_escape_string($db, $_POST['role']);
						$password = mysqli_real_escape_string($db, $_POST['password']);
						$conpassword = mysqli_real_escape_string($db, $_POST['conpassword']);
						$houseID = mysqli_real_escape_string($db, $_POST['houseID']);

						if($password !== $conpassword) {
							$errors = "Password mismatch!!";
						}

						//checking is credentials already exist
						$user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
						$result = mysqli_query($db, $user_check_query);
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

						//create user if he/she doesn't exist
						if ($errors == "" AND $errors2 == "") {
							$query = "INSERT INTO users (name, email, phone, role, password, conpassword, houseID) VALUES ('$name', '$email', '$phone', '$role', '$password', '$conpassword', '$houseID')";
							
							$query_run = mysqli_query($db, $query);
			
							if($query_run){
								$errors3 = "Data successfully saved.....";
								
								header('location: adminpaneltwo');

								// if ($errors3 != ""){
								// 	echo "<span style='color:green; font-weight: 800'>$errors</span>";
								// }
								// header('location: adminpaneltwo');
							}else{
								echo '<script type="text/javascript">
									alert("Upload failed");
								</script>';
							}
						}
						if ($errors3 != ""){
							echo "<span style='color:green; font-weight: 800'>$errors3</span>";
						}
					}else{
						echo '<script type="text/javascript"> alert("You are logged out")</script>';
					}
				}
			?>
						<div class="user-details">
							<div class="input-box">
								<span class="details"><label for="name">Name:</label></span><br>
								<input type="text" name="name" id="name" required/>
							</div>
							<div class="input-box">
								<span class="details"><label for="email">Email:</label></span><br>
								<input type="email" name="email" id="email" placeholder="myself@gmail.com" required/>
							</div>
							<div class="input-box">
								<span class="details"><label for="phone">Phone no:</label></span><br>
								<input type="text" name="phone" id="phone" required/>
							</div>
							<div class="input-box">
								<span class="details"><label for="rank">User role:</label></span><br>
								<select name="role" id="role">
									<option value="admin">ADMIN</option>
									<option value="landlord">LANDLORD</option>
									<option value="tenant">TENANT</option>
									<option value="" selected="selected">--Select user role--</option>
								</select>
							</div>
							<div class="input-box">
								<span class="details"><label for="password">Set password:</label></span><br>
								<input type="Password" name="password" id="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" required/>
							</div>
							<div class="input-box">
								<span class="details"><label for="conpassword">Confirm password:</label></span><br>
								<input type="Password" name="conpassword" id="conpassword" placeholder=" Confirm Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" required/>
							</div>
							<div class="input-box">
								<span class="details"><label for="houseID">House ID:</label></span><br>
								<input type="text" name="houseID" id="houseID" required/>
							</div>
						</div>

						<div class="gen-bt">
							<div class="button">
								<input type="submit" name="submit" value="SUBMIT"/>
							</div>
							<div class="button">
								<input type="reset" name="rest" value="CLEAR"/>
							</div>
						</div>
					</fieldset>
				</form>
			</div>

			<div id="updateUser" class="myForm">
				<form action="" method="post" enctype="multipart/form-data">
					<fieldset>
						<legend>UPDATE USER:</legend>
						<?php
				
				$errors2 = "";

				include 'db_connection.php';

				if(isset($_POST['delete'])){
					if(isset($_SESSION['mail'])){
						$errors = "";
						$useremail = mysqli_real_escape_string($db, $_POST['useremail']);

						//Delete house......
						$query = "DELETE FROM users WHERE email='$useremail'";
						$query_run = mysqli_query($db, $query);

						if($query_run){
							$errors = "Data deleted.....";
							if ($errors != ""){
								echo "<span style='color:red; font-weight: 800'>$errors</span>";
							}

							header('location: adminpaneltwo');
						}else{
							echo '<script type="text/javascript"> alert("Upload failed")</script>';
							header('location: adminpaneltwo');
						}
					}else{
						echo '<script type="text/javascript"> alert("You are logged out")</script>';
					}
				}

				if(isset($_POST['update'])){
					if(isset($_SESSION['mail'])){
						$errors = "";
						$errors3 = "";
						$myerrors = "";

						$name = mysqli_real_escape_string($db, $_POST['name']);
						$email = mysqli_real_escape_string($db, $_POST['email']);
						$phone = mysqli_real_escape_string($db, $_POST['phone']);
						$role = mysqli_real_escape_string($db, $_POST['role']);
						$password = mysqli_real_escape_string($db, $_POST['password']);
						$conpassword = mysqli_real_escape_string($db, $_POST['conpassword']);
						$houseID = mysqli_real_escape_string($db, $_POST['houseID']);
								

						if($password !== $conpassword) {
							$errors = "Password mismatch!!";
						}

						//checking is credentials already exist
						if ($errors != ""){
							echo "<span style='color:red; font-weight: 800'>$errors</span><br>";
						}
						
						//create user if he/she doesn't exist
						if ($errors == "") {

							$query = "UPDATE users SET name='$name', phone='$phone', role='$role', password='$password', conpassword='$conpassword', houseID='$houseID' WHERE email='$email'";
							
							$query_run = mysqli_query($db, $query);
			
							if($query_run){

								$errors3 = "Data updated.....";

									if ($errors != ""){
										echo "<span style='color:green; font-weight: 800'>$errors3</span>";
									}

									header('location: adminpaneltwo#updateUser');
							}else{
								echo '<script type="text/javascript"> alert("Upload failed")</script>';
								header('location: adminpaneltwo');
							}
						}
						}else{
							echo '<script type="text/javascript"> alert("You are logged out")</script>';
						}
				}
			?>

						<div class="user-details">
							<div class="input-box">
								<span class="details"><label for="useremail"> Enter Email:	</label></span><br>
								<input type="text" name="useremail" id="useremail"/>
							</div>
						</div>
						<div class="gen-bt">
							<div class="button button-2nd">
								<input type="submit" name="find" value="FIND"/>
							</div>
							<div class="button button-2nd">
								<input type="button" name="del" value="DELETE" onclick="document.getElementById('id01').style.display='block'"/>
							</div>



							<div id="id01" class="modal">
								<span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
								<div class="modal-content">
								  <div class="container-delete">
								    <h1>Delete account</h1>
								    <p>Are you sure you want to delete this account?</p>

								    <div class="clearfix">
								      <button type="button" class="cancelbtn" onclick="cancel()">Cancel</button>
								      <button type="submit" name="delete" class="deletebtn">Delete</button>
								    </div>
								  </div>
								</div>
							</div>
						</div>
						<hr>


						<?php
							error_reporting(0);
							$useremail = mysqli_real_escape_string($db, $_POST['useremail']);

							if(isset($_POST['find'])){
								// header('location: adminpanel#editHouse');
								$res = mysqli_query($db, "SELECT * from users WHERE email='$useremail'");
								while ($row = mysqli_fetch_array($res)) {
								?>

									<div class="user-details">
										<div class="input-box">
											<span class="details"><label for="name">Name:</label></span><br>
											<input type="text" name="name" id="name" value="<?php echo $row['name']; ?>" required/>
										</div>
										<div class="input-box">
											<span class="details"><label for="email">Email:</label></span><br>
											<input type="email" name="email" id="email" placeholder="myself@gmail.com" value="<?php echo $row['email']; ?>" readonly required/>
										</div>
										<div class="input-box">
											<span class="details"><label for="phone">Phone no:</label></span><br>
											<input type="text" name="phone" id="phone" value="<?php echo $row['phone']; ?>" required/>
										</div>
										<div class="input-box">
											<span class="details"><label for="rank">User role:</label></span><br>
											<select name="role" id="role">
												<option value="admin">ADMIN</option>
												<option value="landlord">LANDLORD</option>
												<option value="tenant">TENANT</option>
												<option value="<?php echo $row['role']; ?>" selected="selected"><?php echo $row['role']; ?></option>
											</select>
										</div>
										<div class="input-box">
											<span class="details"><label for="password">Set password:</label></span><br>
											<input type="Password" name="password" id="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" value="<?php echo $row['password']; ?>" required/>
										</div>
										<div class="input-box">
											<span class="details"><label for="conpassword">Confirm password:</label></span><br>
											<input type="Password" name="conpassword" id="conpassword" placeholder=" Confirm Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" value="<?php echo $row['conpassword']; ?>" required/>
										</div>
										<div class="input-box">
											<span class="details"><label for="houseID">House ID:</label></span><br>
											<input type="text" name="houseID" id="houseID" value="<?php echo $row['houseID']; ?>" required/>
										</div>
										<div class="input-box">
											<span class="details"><label for="logintime">Last login:</label></span><br>
											<input type="text" name="logintime" id="logintime" value="<?php echo $row['lastlogin']; ?>" readonly required/>
										</div>
									</div>
								<?php
								}
							}
						?>

						<div class="gen-bt">
							<div class="button">
								<input type="submit" name="update" value="UPDATE"/>
							</div>
							<div class="button">
								<input type="reset" name="rest" value="CLEAR"/>
							</div>
						</div>
					</fieldset>
				</form>
			</div>	
		</div>
	</div>

	<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
	<script src="scrolljQuery.js"></script>
	<script>
		$('.btn').click(function(){
			$(this).toggleClass("click");
			$('.sidebar').toggleClass("show");
		});

		$('.feat-btn').click(function(){
			$('nav ul .feat-show').toggleClass("show");
		});

		$('.serv-btn').click(function(){
			$('nav ul .serv-show').toggleClass("show1");
		});

		$('nav ul li').click(function(){
			$(this).addClass("active").siblings().removeClass("active");
		});

	</script>

	<script>
		// Get the modal
		var modal = document.getElementById('id01');

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
		  if (event.target == modal) {
		    modal.style.display = "none";
		  }
		}

		function cancel(){
		    modal.style.display = "none";
		}
	</script>
</body>
</html>