<?php

	session_start();

	error_reporting(0);
	include 'db_connection.php';
	include 'status.php';

	
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">


	<!-- <link rel="stylesheet" type="text/css" href="navs.css"> -->
	<link rel="stylesheet" type="text/css" href="home.css">

	<link rel="stylesheet" type="text/css" href="fonts/css/all.css">
	<link rel="stylesheet" href="fontboot/bootstrap-icons.css">
	<title>Categories</title>
</head>
<body>
	
	<nav class="this-nav">
		<div class="logo">
			<i class="bi bi-house-door"></i>  <span>Manyumba</span>Housing</b>
		</div>
		<button type="button" class="btn-hamburger" data-action="nav-toggle"> 
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
		</button>
		<ul class="nav-menu">
			<li class="nav-item nav-item-sub1"><a href="home">Houses</a></li>
			<li class="nav-item nav-item-sub1"><a href="about">About</a></li>
			<li class="nav-item nav-item-sub1"><a href="about#contact-us-now">Raise ticket</a></li>
			<li class="nav-item nav-item-sub1 dropdown">
				<a href="#" data-action="dropdown-toggle"><i class="bi bi-person-circle"></i> <?php

		if(isset($_SESSION['mail'])){
			echo $_SESSION['mail'];
		}

		?></a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="profile">Profile</a><hr>
					<a class="dropdown-item" href="logout">Switch account</a><hr>
					<a class="dropdown-item" href="logout">Logout <i class="bi bi-power"></i></a>
				</div>
			</li>
		</ul>
	</nav>

	<div class="carry-all">
		<div class="small-container">
			<div class="row row-home">
				<?php

				if(isset($_GET['cat'])){

					$cat = mysqli_real_escape_string($db, $_GET['cat']);


					$sql = "SELECT * from houseinfo WHERE (bedroom='$cat' OR location='$cat' OR rent<'$cat') AND houseStatus='vaccant'"; 
					$res = mysqli_query($db, $sql);

					while ($row = mysqli_fetch_array($res)) {
					?>
					<div class="col-4">
						<div class="image">
							<?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage1']).'" alt="" style="width:100%; height:100px; position:center;">'; ?>
						</div>
						<p>Bedroom: <?php echo $row["bedroom"]; ?></p>
						<p>Location: <?php echo $row["location"]; ?></p>
						<p>Rent: KSH <?php echo $row["rent"]; ?></p>
						<p>House status: <?php echo $row["houseStatus"]; ?></p>
						<div class="bt-more">
							<button> <?php
								if(isset($_SESSION['mail'])){
					 				echo " <a href='more?ID={$row['houseID']}'> MORE &#8594; </a>"; 
								}else{
									echo '<script type="text/javascript"> alert("You are logged out")</script>';
								}
					 		?></button>
						</div>
					</div>
					<?php
					}
				}

				elseif(isset($_GET['cat2'])){

					$cat = mysqli_real_escape_string($db, $_GET['cat2']);


					$sql = "SELECT * from houseinfo WHERE (rent>6999 AND rent<'16000') AND houseStatus='vaccant'"; 
					$res = mysqli_query($db, $sql);

					while ($row = mysqli_fetch_array($res)) {
					?>
					<div class="col-4">
						<div class="image">
							<?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage1']).'" alt="" style="width:100%; height:100px; position:center;">'; ?>
						</div>
						<p>Bedroom: <?php echo $row["bedroom"]; ?></p>
						<p>Location: <?php echo $row["location"]; ?></p>
						<p>Rent: KSH <?php echo $row["rent"]; ?></p>
						<p>House status: <?php echo $row["houseStatus"]; ?></p>
						<div class="bt-more">
							<button> <?php
								if(isset($_SESSION['mail'])){
					 				echo " <a href='more?ID={$row['houseID']}'> MORE &#8594; </a>"; 
								}else{
									echo '<script type="text/javascript"> alert("You are logged out")</script>';
								}
					 		?></button>
						</div>
					</div>
					<?php
					}
				}

				elseif(isset($_GET['cat3'])){

					$cat = mysqli_real_escape_string($db, $_GET['cat3']);


					$sql = "SELECT * from houseinfo WHERE (rent>15999 AND rent<'26000') AND houseStatus='vaccant'"; 
					$res = mysqli_query($db, $sql);

					while ($row = mysqli_fetch_array($res)) {
					?>
					<div class="col-4">
						<div class="image">
							<?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage1']).'" alt="" style="width:100%; height:100px; position:center;">'; ?>
						</div>
						<p>Bedroom: <?php echo $row["bedroom"]; ?></p>
						<p>Location: <?php echo $row["location"]; ?></p>
						<p>Rent: KSH <?php echo $row["rent"]; ?></p>
						<p>House status: <?php echo $row["houseStatus"]; ?></p>
						<div class="bt-more">
							<button> <?php
								if(isset($_SESSION['mail'])){
					 				echo " <a href='more?ID={$row['houseID']}'> MORE &#8594; </a>"; 
								}else{
									echo '<script type="text/javascript"> alert("You are logged out")</script>';
								}
					 		?></button>
						</div>
					</div>
					<?php
					}
				}

				elseif(isset($_GET['cat4'])){

					$cat = mysqli_real_escape_string($db, $_GET['cat4']);


					$sql = "SELECT * from houseinfo WHERE (rent>25999 AND rent<'36000') AND houseStatus='vaccant'"; 
					$res = mysqli_query($db, $sql);

					while ($row = mysqli_fetch_array($res)) {
					?>
					<div class="col-4">
						<div class="image">
							<?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage1']).'" alt="" style="width:100%; height:100px; position:center;">'; ?>
						</div>
						<p>Bedroom: <?php echo $row["bedroom"]; ?></p>
						<p>Location: <?php echo $row["location"]; ?></p>
						<p>Rent: KSH <?php echo $row["rent"]; ?></p>
						<p>House status: <?php echo $row["houseStatus"]; ?></p>
						<div class="bt-more">
							<button> <?php
								if(isset($_SESSION['mail'])){
					 				echo " <a href='more?ID={$row['houseID']}'> MORE &#8594; </a>"; 
								}else{
									echo '<script type="text/javascript"> alert("You are logged out")</script>';
								}
					 		?></button>
						</div>
					</div>
					<?php
					}
				}

				elseif(isset($_GET['cat5'])){

					$cat = mysqli_real_escape_string($db, $_GET['cat5']);


					$sql = "SELECT * from houseinfo WHERE rent>35999 AND houseStatus='vaccant'"; 
					$res = mysqli_query($db, $sql);

					while ($row = mysqli_fetch_array($res)) {
					?>
					<div class="col-4">
						<div class="image">
							<?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage1']).'" alt="" style="width:100%; height:100px; position:center;">'; ?>
						</div>
						<p>Bedroom: <?php echo $row["bedroom"]; ?></p>
						<p>Location: <?php echo $row["location"]; ?></p>
						<p>Rent: KSH <?php echo $row["rent"]; ?></p>
						<p>House status: <?php echo $row["houseStatus"]; ?></p>
						<div class="bt-more">
							<button> <?php
								if(isset($_SESSION['mail'])){
					 				echo " <a href='more?ID={$row['houseID']}'> MORE &#8594; </a>"; 
								}else{
									echo '<script type="text/javascript"> alert("You are logged out")</script>';
								}
					 		?></button>
						</div>
					</div>
					<?php
					}
				}
				?>
			</div>
			<button class="btn">More</button>
		</div>
	</div>
	<!--------Footer--------->
	<div class="footer2">
		<div class="footer-container">
			<div class="row">
				<div class="footer-col-1">
					<h3><b><i class="bi bi-house-door"></i> MANYUMBA HOUSING AGENTS</b></h3>
				</div>
				<div class="footer-col-2">
					<h3>Features</h3>
					<ul>
						<li>Coupons</li>
						<li>Blog Post</li>
						<li>Return Policy</li>
						<li>Join Affiliate</li>
					</ul>

				</div>
				<div class="footer-col-3">
					<h3>Use cases</h3>
					<ul>
						<li>Landlord</li>
						<li>Tenant</li>
						<li>Agent</li>
					</ul>
				</div>
				<div class="footer-col-4" id="contact">
					<h3>Contact</h3>
					<ul>
						<li><i class="bi bi-whatsapp"></i>  011223344566</li>
						<li><i class="bi bi-telephone-inbound-fill"></i>  078223344566</li>
					</ul>

					<h3>Follow us</h3>
					<ul>
						<li><i class="bi bi-facebook" aria-hidden="true"></i> Facebook</li>
						<li><i class="bi bi-twitter" aria-hidden="true"></i> Twitter</li>
						<li><i class="bi bi-instagram" aria-hidden="true"></i> Instagram</li>
					</ul>
				</div>
			</div>
			<hr>
			<p class="copyright">&#169; 2022 - MANYUMBA HOUSING AGENTS</p>
		</div>
	</div>


	


	<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
	<script src="scrolljQuery.js"></script>
	<script>
		$(".col-4").slice(0, 12).show()
		$(".btn").on("click", function(){
			$(".col-4:hidden").slice(0, 12).slideDown('slow')
			if ($(".col-4:hidden").length == 0) {
				$(".btn").fadeOut('slow')
			}
		})

		// $(".col-4").slice(0, 6).show()
		// $(".btn-2").on("click", function(){
		// 	$(".col-4:hidden").slice(0, 6).slideDown('slow')
		// 	if ($(".col-4:hidden").length == 0) {
		// 		$(".btn-2").fadeOut('slow')
		// 	}
		// })
	</script>
	
	<script>
		let nav = document.querySelector('nav');
		let dropdown = nav.querySelector('.dropdown');
		let dropdownToggle = nav.querySelector("[data-action='dropdown-toggle']");

		let navToggle = nav.querySelector("[data-action='nav-toggle']");

		dropdownToggle.addEventListener('click', () =>{
			if (dropdown.classList.contains('show')) {
				dropdown.classList.remove('show');
			} else{
				dropdown.classList.add('show');
			}
		})

		navToggle.addEventListener('click', () =>{
			if (nav.classList.contains('opened')) {
				nav.classList.remove('opened');
			} else{
				nav.classList.add('opened');
			}
		})

		$(window).scroll(function() {
			if ($(window).scrollTop()) {
				$("nav").addClass("black");
			}
			else{
				$("nav").removeClass("black");
			}
		});
	</script>

</body>
</html>