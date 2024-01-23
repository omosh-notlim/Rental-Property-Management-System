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
	<title>House management</title>
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
			<li>
				<a href="#" class="serv-btn house-mng"><i class="bi bi-house-door"></i> 
					House management <i class="bi bi-caret-down-fill"></i>
				</a>
				<ul class="serv-show">
					<li><a href="#addHouse">Add house</a></li>
					<li><a href="#editHouse">Housing update</a></li>
					<li><a href="#houseSearch">House search</a></li>
				</ul>
			</li>
			<li><a href="adminpaneltwo"><i class="bi bi-people-fill"></i> User management</a></li>
			<li><a href="home"><i class="bi bi-house-fill"></i> Houses</a></li>
			<li><a href="about#contact-us-now"><i class="bi bi-body-text"></i> Raise ticket</a></li>
			<li><a class="dropdown-item" href="profile"><i class="bi bi-person-lines-fill"></i>  Profile</a></li>
			<li><a href="logout"><i class="bi bi-toggles2"></i>  Switch account</a></li>
			<br>
			<br>
			<li><a href="logout">Logout <i class="bi bi-power"></i></a></li>
		</ul>
	</nav>

	<div class="content-area">
		<div class="wrapper">
			<div id="addHouse" class="myForm">
				<form action="" method="post" enctype="multipart/form-data">
				<fieldset>
					<legend>ADD HOUSE:</legend>
					<?php
						$query = "SELECT * FROM houseinfo ORDER BY houseID DESC LIMIT 1";
						$query_run = mysqli_query($db, $query);

						if (mysqli_num_rows($query_run) > 0) {
							foreach ($query_run as $key) {
							?>
							<p></p><h5>Last ID:  <?php echo $key['houseID'];?></h5></p>
							<?php
							}
						}
					?>
					<?php
						$errors = "";
						$errors2 = "";
			

						if(isset($_POST['upload'])){
							if(isset($_SESSION['mail'])){
								$houseID = mysqli_real_escape_string($db, $_POST['houseID']);
								$bedroom = mysqli_real_escape_string($db, $_POST['bedroom']);
								$location = mysqli_real_escape_string($db, $_POST['location']);
								$rent = mysqli_real_escape_string($db, $_POST['rent']);
								$landlordEmail = mysqli_real_escape_string($db, $_POST['landlordEmail']);
								$houseDescription = mysqli_real_escape_string($db, $_POST['houseDescription']);
								$houseStatus = mysqli_real_escape_string($db, $_POST['houseStatus']);
								$file1 = addslashes(file_get_contents($_FILES["pic1"]["tmp_name"]));
								$file2 = addslashes(file_get_contents($_FILES["pic2"]["tmp_name"]));
								$file3 = addslashes(file_get_contents($_FILES["pic3"]["tmp_name"]));
								$file4 = addslashes(file_get_contents($_FILES["pic4"]["tmp_name"]));
								$file5 = addslashes(file_get_contents($_FILES["pic5"]["tmp_name"]));
								$file6 = addslashes(file_get_contents($_FILES["pic6"]["tmp_name"]));
								$file7 = addslashes(file_get_contents($_FILES["pic7"]["tmp_name"]));
								$file8 = addslashes(file_get_contents($_FILES["pic8"]["tmp_name"]));
								$caretakerName = mysqli_real_escape_string($db, $_POST['caretakerName']);
								$caretakerNumber = mysqli_real_escape_string($db, $_POST['caretakerNumber']);


								//checking is credentials already exist
								$user_check_query = "SELECT * FROM houseinfo WHERE houseID=? LIMIT 1";
								$stmt = mysqli_stmt_init($db);
								// $result = mysqli_query($db, $user_check_query);

								if (!mysqli_stmt_prepare($stmt, $user_check_query)) {
									echo "SQL statement failed";
								} else{
									mysqli_stmt_bind_param($stmt, "s", $email);
									// running parameters inside the database
									mysqli_stmt_execute($stmt);
									$result = mysqli_stmt_get_result($stmt);
									$house = mysqli_fetch_assoc($result);

									if ($house) {//if user exists
										if ($house['houseID'] === $houseID) {
											$errors = "SORRY!! Record already exists.";
										}
									}

									if ($errors != ""){
										echo "<span style='color:red; font-weight: 800'>$errors</span>";
									}
								}

								//add house if it doesn't exist
								if ($errors == ""){
									$query = "INSERT INTO houseinfo (houseID, bedroom, location, rent, landlordEmail, houseDescription, houseStatus, houseImage1, houseImage2, houseImage3, houseImage4, houseImage5, houseImage6, houseImage7, houseImage8, caretakerName, caretakerNumber) VALUES ('$houseID', '$bedroom', '$location', '$rent', '$landlordEmail', '$houseDescription', '$houseStatus', '$file1', '$file2', '$file3', '$file4', '$file5', '$file6', '$file7', '$file8', '$caretakerName', '$caretakerNumber')";
									$query_run = mysqli_query($db, $query);

									if($query_run){
										$errors2 = "Data successfully saved.....";

										if ($errors2 != ""){
											echo "<span style='color:green; font-weight: 800'>$errors</span>";
										}

										header('location: adminpanel');
									}
									
			
									// else{
									// 	echo '<script type="text/javascript"> alert("Upload failed")</script>';
									// 	header('location: adminpanel');
									// }
								}
							}else{
								echo '<script type="text/javascript"> alert("You are logged out")</script>';
							}
						}
					?>

					<div class="user-details">
						<div class="input-box">
							<span class="details"><label for="houseID">House ID:</label></span><br>
							<input type="text" name="houseID" id="houseID" required/>
						</div>
						<div class="input-box">
							<span class="details"><label for="bedroom">Bedroom:</label></span><br>
							<select name="bedroom" id="bedroom">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="Bedsitter">Bedsitter</option>
								<option value="Single room">Single room</option>
								<option value="0" selected="selected">--Select one--</option>
							</select>
						</div>
						<div class="input-box">
							<span class="details"><label for="location">Location:</label></span><br>
							<input type="text" name="location" id="location" required/>
						</div>
						<div class="input-box">
							<span class="details"><label for="rent">Rent paid:</label></span><br>
							<input type="number" name="rent" id="rent" required/>
						</div>
						<div class="input-box">
							<span class="details"><label for="landlordEmail">Landlord's Email:</label></span><br>
							<input type="text" name="landlordEmail" id="landlordEmail" placeholder="myself@gmail.com" required/>
						</div>
						<div class="input-box-long">
							<span class="details"><label for="houseDescription">House description:</label></span><br>
							<textarea name="houseDescription"></textarea>
						</div>
						<div class="input-box">
							<span class="details"><label for="houseStatus">House status:</label></span><br>
							<select name="houseStatus" id="houseStatus">
								<option value="Vaccant">Vaccant</option>
								<option value="Occupied">Occupied</option>
								<option value="Sold">Sold</option>
								<option value="0" selected="selected">--Select house status--</option>
							</select>
						</div>
						<div class="input-box">
							<span class="details"><label for="houseImage1">House image 1:</label></span><br>
							<input type="file" name="pic1" id="pic1" required/>
						</div>
						<div class="input-box">
							<span class="details"><label for="houseImage2">House image 2:</label></span><br>
							<input type="file" name="pic2" id="pic2" required/>
						</div>
						<div class="input-box">
							<span class="details"><label for="houseImage3">House image 3:</label></span><br>
							<input type="file" name="pic3" id="pic3" required/>
						</div>
						<div class="input-box">
							<span class="details"><label for="houseImage4">House image 4:</label></span><br>
							<input type="file" name="pic4" id="pic4" required/>
						</div>
						<div class="input-box">
							<span class="details"><label for="houseImage5">House image 5:</label></span><br>
							<input type="file" name="pic5" id="pic5" required//>
						</div>
						<div class="input-box">
							<span class="details"><label for="houseImage6">House image 6:</label></span><br>
							<input type="file" name="pic6" id="pic6" required//>
						</div>
						<div class="input-box">
							<span class="details"><label for="houseImage7">House image 7:</label></span><br>
							<input type="file" name="pic7" id="pic7" required//>
						</div>
						<div class="input-box">
							<span class="details"><label for="houseImage8">House image 8:</label></span><br>
							<input type="file" name="pic8" id="pic8" required//>
						</div>
						<div class="input-box">
							<!---name changed from per-vis--->
							<span class="details"><label for="caretakerName">Caretaker's name:</label></span><br>
							<input type="text" name="caretakerName" id="caretakerName" required/>
						</div>
						<div class="input-box">
							<!---name changed from per-vis--->
							<span class="details"><label for="caretakerNumber">Caretaker's number:</label></span><br>
							<input type="number" name="caretakerNumber" id="caretakerNumber" required/>
						</div>
					</div>

					<div class="gen-bt">
						<div class="button">
							<input type="submit" name="upload" value="UPLOAD"/>
						</div>
					</div>
				</fieldset>
			</form>
		</div>

		<div id="editHouse" class="myForm">
			<form action="" method="post" enctype="multipart/form-data">
				<fieldset>
					<legend>UPDATE HOUSE DETAILS:</legend>

					<?php
						$errors = "";
						
						
						include 'db_connection.php';

						if(isset($_POST['delete'])){
							if(isset($_SESSION['mail'])){
								$houseID = mysqli_real_escape_string($db, $_POST['houseIDsearch']);

								//Delete house......
								$query = "DELETE FROM houseinfo WHERE houseID='$houseID' OR landlordEmail='$houseID'";
								$query_run = mysqli_query($db, $query);

								if($query_run){
									$errors = "Data deleted.....";
									if ($errors != ""){
										echo "<span style='color:red; font-weight: 800'>$errors</span>";
									}

									header('location: adminpanel#editHouse');
								}else{
									echo '<script type="text/javascript"> alert("Upload failed")</script>';
									header('location: adminpanel#editHouse');
								}
							}else{
								echo '<script type="text/javascript"> alert("You are logged out")</script>';
							}

						}

						if(isset($_POST['update'])){
							if(isset($_SESSION['mail'])){
								$houseID = mysqli_real_escape_string($db, $_POST['houseID']);
								$bedroom = mysqli_real_escape_string($db, $_POST['bedroom']);
								$location = mysqli_real_escape_string($db, $_POST['location']);
								$rent = mysqli_real_escape_string($db, $_POST['rent']);
								$landlordEmail = mysqli_real_escape_string($db, $_POST['landlordEmail']);
								$houseDescription = mysqli_real_escape_string($db, $_POST['houseDescription']);
								$houseStatus = mysqli_real_escape_string($db, $_POST['houseStatus']);
								// $file1 = addslashes(file_get_contents($_FILES["pic1"]["tmp_name"]));
								// $file2 = addslashes(file_get_contents($_FILES["pic2"]["tmp_name"]));
								// $file3 = addslashes(file_get_contents($_FILES["pic3"]["tmp_name"]));
								// $file4 = addslashes(file_get_contents($_FILES["pic4"]["tmp_name"]));
								// $file5 = addslashes(file_get_contents($_FILES["pic5"]["tmp_name"]));
								// $file6 = addslashes(file_get_contents($_FILES["pic6"]["tmp_name"]));
								// $file7 = addslashes(file_get_contents($_FILES["pic7"]["tmp_name"]));
								// $file8 = addslashes(file_get_contents($_FILES["pic8"]["tmp_name"]));
								$caretakerName = mysqli_real_escape_string($db, $_POST['caretakerName']);
								$caretakerNumber = mysqli_real_escape_string($db, $_POST['caretakerNumber']);


								//updating details........
								$query = "UPDATE houseinfo SET bedroom='$bedroom', location='$location', rent='$rent', landlordEmail='$landlordEmail', houseDescription='$houseDescription', houseStatus='$houseStatus', caretakerName='$caretakerName', caretakerNumber='$caretakerNumber' WHERE houseID='$houseID'";
								$query_run = mysqli_query($db, $query);

								if($query_run){
									$errors = "Data updated.....";

									if ($errors != ""){
										echo "<span style='color:green; font-weight: 800'>$errors</span>";
									}

									header('location: adminpanel#editHouse');
								}else{
									echo '<script type="text/javascript"> alert("Upload failed")</script>';
									header('location: adminpanel#editHouse');
								}
							}else{
								echo '<script type="text/javascript"> alert("You are logged out")</script>';
							}
						}
					?>

					<div class="user-details">
						<div class="input-box">
							<span class="details"><label for="houseIDsearch"> Enter House ID:	</label></span><br>
							<input type="text" name="houseIDsearch" id="houseIDsearch"/>
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
							    <h1>Delete house</h1>
							    <p>Are you sure you want to delete this house?</p>

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
						$houseIDsearch = mysqli_real_escape_string($db, $_POST['houseIDsearch']);

						if(isset($_POST['find'])){
							header('location: adminpanel#editHouse');
							$res = mysqli_query($db, "SELECT * from houseinfo WHERE houseID='$houseIDsearch' OR landlordEmail='$houseIDsearch'");
							while ($row = mysqli_fetch_array($res)) {
							?>
								<div class="user-details">
									<div class="input-box">
										<span class="details"><label for="houseID">House ID:</label></span><br>
										<input type="text" readonly name="houseID" id="houseID" value="<?php echo $row["houseID"]; ?>" required/>
									</div>
									<div class="input-box">
										<span class="details"><label for="bedroom">Bedroom:</label></span><br>
										<select name="bedroom" id="bedroom">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="Bedsitter">Bedsitter</option>
											<option value="Single room">Single room</option>
											<option value="<?php $row["bedroom"]; ?>" selected="selected"><?php echo $row["bedroom"]; ?></option>
										</select>
									</div>
									<div class="input-box">
										<span class="details"><label for="location">Location:</label></span><br>
										<input type="text" name="location" id="location" value="<?php echo $row["location"]; ?>" />
									</div>
									<div class="input-box">
										<span class="details"><label for="rent">Rent paid:</label></span><br>
										<input type="number" name="rent" id="rent" value="<?php echo $row["rent"]; ?>" />
									</div>
									<div class="input-box">
										<span class="details"><label for="landlordEmail">Landlord's Email:</label></span><br>
										<input type="text" name="landlordEmail" id="landlordEmail" value="<?php echo $row["landlordEmail"]; ?>" />
									</div>
									<div class="input-box-long">
										<span class="details"><label for="houseDescription">House description:</label></span><br>
										<textarea name="houseDescription"><?php echo $row["houseDescription"]; ?></textarea>
									</div>
									<div class="input-box">
										<span class="details"><label for="houseStatus">House status:</label></span><br>
										<select name="houseStatus" id="houseStatus">
											<option value="Vaccant">Vaccant</option>
											<option value="Occupied">Occupied</option>
											<option value="Sold">Sold</option>
											<option value="<?php $row["houseStatus"]; ?>" selected="selected"><?php echo $row["houseStatus"]; ?></option>
										</select>
									</div>
									<div class="input-box">
										<!---name changed from per-vis--->
										<span class="details"><label for="caretakerName">Caretaker's name:</label></span><br>
										<input type="text" name="caretakerName" id="caretakerName" value="<?php echo $row["caretakerName"]; ?>" />
									</div>
									<div class="input-box">
										<!---name changed from per-vis--->
										<span class="details"><label for="caretakerNumber">Caretaker's number:</label></span><br>
										<input type="number" name="caretakerNumber" id="caretakerNumber" value="<?php echo $row["caretakerNumber"]; ?>" />
									</div>
								</div>
							<?php

							}
						}
						?>

						<div class="gen-bt">
							<div class="button button-2nd">
								<input type="submit" name="update" value="UPDATE"/>
							</div>
						</div>	
					</fieldset>
				</form>
			</div>


			<div id="houseSearch" class="myForm">
				<form action="" method="post" enctype="multipart/form-data">
					<fieldset>
						<legend>HOUSE SEARCH:</legend>
						<div class="user-details">
							<div class="input-box">
								<span class="details"><label for="houseIDsearch"> Enter House ID:	</label></span><br>
								<input type="text" name="houseIDsearch" id="houseIDsearch"/>
							</div>
						</div>
						<div class="gen-bt">
							<div class="button button-2nd">
								<input type="submit" name="search" value="SEARCH"/>
							</div>
						</div>
						<hr>

						<div class="row">
							<?php
								error_reporting(0);
								$searchDetail = mysqli_real_escape_string($db, $_POST['houseIDsearch']);

								if(isset($_POST['search'])){
									$res = mysqli_query($db, "SELECT * from houseinfo WHERE houseID='$searchDetail'");
									while ($row = mysqli_fetch_array($res)) {
									?>
									<div class="row">
										<div class="col-2">
											<?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage1']).'" alt="" style="width:100%; height:400px; position:center;" id="ProductImg">'; ?>

											<div class="small-img-row">
												<div class="small-img-col">
													<?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage1']).'" alt="" style="width:90px; height:90px; position:center;" class="small-img">'; ?>
														
												</div>
												<div class="small-img-col">
													<?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage2']).'" alt="" style="width:90px; height:90px; position:center;" class="small-img">'; ?>
												</div>
												<div class="small-img-col">
													<?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage3']).'" alt="" style="width:90px; height:90px; position:center;" class="small-img">'; ?>
												</div>
												 <div class="small-img-col"> 
													<?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage4']).'" alt="" style="width:90px; height:90px; position:center;" class="small-img">'; ?>
												</div>
												<div class="small-img-col">
													<?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage5']).'" alt="" style="width:90px; height:90px; position:center;" class="small-img">'; ?>
												</div>
											</div>
										</div>
									</div>
		
									<div class="col-4">
										<p><b>House ID: <?php echo $row["houseID"]; ?></b></p>
										<p><b>Bedroom: <?php echo $row["bedroom"]; ?></b></p>
										<p><b>Location: <?php echo $row["location"]; ?></b></p>
										<p><b>Rent: KSH <?php echo $row["rent"]; ?></b></p>
										<p><b>Occupation status: <?php echo $row["houseStatus"]; ?></b></p>
										<p><b>House description: <?php echo $row["houseDescription"]; ?></b></p>
										<p><b>Landlord's email: <?php echo $row["landlordEmail"]; ?></b></p>
										<p><b>Caretaker's name: <?php echo $row["caretakerName"]; ?></b></p>
										<p><b>Caretaker's number: <?php echo $row["caretakerNumber"]; ?></b></p>
									</div>
		
									<?php
									}
									}
								?>
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
		var ProductImg = document.getElementById("ProductImg");
		var SmallImg = document.getElementsByClassName("small-img");

		SmallImg[0].onclick = function(){
			ProductImg.src = SmallImg[0].src;
		}
		SmallImg[1].onclick = function(){
			ProductImg.src = SmallImg[1].src;
		}
		SmallImg[2].onclick = function(){
			ProductImg.src = SmallImg[2].src;
		}
		SmallImg[3].onclick = function(){
			ProductImg.src =SmallImg[3].src;
		}
		SmallImg[4].onclick = function(){
			ProductImg.src =SmallImg[4].src;
		}
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

	<!-- <script>
		const dropdown = document.querySelector('#drop-menu');
		const dropMenu = document.querySelector('#drop-menu2');


		const dropdown2 = document.querySelector('#drop-menu3');
		const dropMenu2 = document.querySelector('#drop-menu4');


		
		dropdown.onclick = function(){
			dropMenu.classList.toggle('hide');
		}

		
		
		dropdown2.onclick = function(){
			dropMenu2.classList.toggle('hide');	
		}
		

	</script> -->
</body>
</html>