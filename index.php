<?php

	// session_start();
	error_reporting(0);
	include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>


	<link rel="stylesheet" type="text/css" href="comments.css">
	<link rel="stylesheet" type="text/css" href="home.css">

	<link rel="stylesheet" type="text/css" href="fonts/css/all.css">
	<link rel="stylesheet" href="fontboot/bootstrap-icons.css">
	<title>Home</title>
</head>
<body>
	
		<nav>
			<div class="logo">
				<b><i class="bi bi-house-door"></i>  <span>Manyumba</span>Housing</b>
			</div>
			<button type="button" class="btn-hamburger" data-action="nav-toggle"> 
				<span></span>
				<span></span>
				<span></span>
				<span></span>
				<span></span>
			</button>
			<ul class="nav-menu">
			    <li class="nav-item nav-item-sub1"><a href="#location">Location</a></li>
				<li class="nav-item nav-item-sub1"><a href="about">Services</a></li>
				<!-- <li class="nav-item nav-item-sub1"><a href="#testimonials">Testimonials</a></li> -->
				<li class="nav-item nav-item-sub1"><a href="about">About us</a></li>
				<li class="nav-item nav-item-sub1"><a href="about#contact-us-now">Contact</a></li>
				<li class="nav-item nav-item-sub1"><a href="registration"><i class="bi bi-person-plus"></i> Sign up</a></li>
				<li class="nav-item nav-item-sub2"><a href="login"><span><i class="bi bi-box-arrow-in-right"></i> Login</span></a></li>
				<li class="nav-item dropdown dis-none">
					<a href="#" data-action="dropdown-toggle">Account</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#">H1</a>
						<a class="dropdown-item" href="#">H2</a>
						<a class="dropdown-item" href="#">H3</a>
					</div>
				</li>
			</ul>
		</nav>
		<div class="sticky"> 
			<div class="row">
				<div class="home-sticky home-sticky2">
					<h1>Searching for a house....</h1>
					<p><i>Join us today to effortlessly identify affordable and amazing houses near you</i></p>
					<div class="login-bt">
						<button> <a href='login'> EXPLORE &#8594; </a></button>
					</div>
				</div>
		
			</div>
		</div>

		<div class="categories-container">
			<h2 id="top" class="title">Bedsitters</h2>
			<div class="row">
				<?php
					$x = 1;
					$res = mysqli_query($db, "SELECT * from houseinfo where bedroom='bedsitter'");
					while($x<5) {
						
						$row = mysqli_fetch_array($res) ?>

						<div class="col-3">
				
							<div class="image">
								<?php echo " <a href='more?ID={$row['houseID']}'> <img src='data:image;base64,".base64_encode($row["houseImage1"])."' alt='' style='width:100%; height:120px; position:center;'> </a>";
								?>
							</div>
							<p><b>Bedroom: <?php echo $row["bedroom"]; ?></b></p>
							<p><b>Location: <?php echo $row["location"]; ?></b></p>
							<p><b>Rent: KSH <?php echo $row["rent"]; ?></b></p>
						</div>
					<?php 
						$x++;
					}

				?>
			</div>
		</div>
		<div class="categories-container">
			<h2 class="title">1 Bedroom</h2>
			<div class="row">
				<?php
					$x = 1;
					$res = mysqli_query($db, "SELECT * from houseinfo where bedroom='1'");
					while($x<5) {
						
						$row = mysqli_fetch_array($res) ?>

						<div class="col-3">
				
							<div class="image">
								<?php echo " <a href='more?ID={$row['houseID']}'> <img src='data:image;base64,".base64_encode($row["houseImage1"])."' alt='' style='width:100%; height:120px; position:center;'> </a>";
								?>
							</div>
							<p><b>Bedroom: <?php echo $row["bedroom"]; ?></b></p>
							<p><b>Location: <?php echo $row["location"]; ?></b></p>
							<p><b>Rent: KSH <?php echo $row["rent"]; ?></b></p>
						</div>
					<?php 
						$x++;
					}

				?>
			</div>
		</div>
		<div class="categories-container">
			<h2 class="title">2 Bedrooms</h2>
			<div class="row">
				<?php
					$x = 1;
					$res = mysqli_query($db, "SELECT * from houseinfo where bedroom='2'");
					while($x<5) {
						
						$row = mysqli_fetch_array($res) ?>

						<div class="col-3">
				
							<div class="image">
								<?php echo " <a href='more?ID={$row['houseID']}'> <img src='data:image;base64,".base64_encode($row["houseImage1"])."' alt='' style='width:100%; height:120px; position:center;'> </a>";
								?>
							</div>
							<p><b>Bedroom: <?php echo $row["bedroom"]; ?></b></p>
							<p><b>Location: <?php echo $row["location"]; ?></b></p>
							<p><b>Rent: KSH <?php echo $row["rent"]; ?></b></p>
						</div>
					<?php 
						$x++;
					}

				?>
			</div>
		</div>


		<div class="row slide-1" id="services">
			<div class="slide-border">
				<h1>Our services include:</h1>
				<p>
					<ul>
						<li><i>&#10147;Reliable house search capabilities</i></li>
						<li><i>&#10147;Online rent payment processing</i></li>
						<li><i>&#10147;Reliable ticket raising via the site</i></li>
						<li><i>&#10147;Property registration</i></li>
						<li><i>&#10147;A monthly report generation for our registered landlords</i></li>
					</ul>
				</p>
			</div>
			<div class="col-slide">
				<!-- <img class ="car-1" src="Vehicles/1.jpg"> -->
				<div class="services">
					<!-- Slider main container -->
					<div class="swiper"> <!-- not closed -->
 						 <!-- Additional required wrapper -->
 			 			<div class="swiper-wrapper">
   							 <!-- Slides -->
			   				<div class="swiper-slide ">
			   					<img src="Houses/myimage1.png" alt="">
			   				</div>
			    			<div class="swiper-slide">
			    				<img src="Houses/myimage4.png" alt="">
			    			</div>
			    			<div class="swiper-slide">
			    				<img src="Houses/myimage3.png" alt="">
			    			</div>
 						</div>

			  			<div class="swiper-pagination"></div>

			  			<div class="swiper-button-prev"></div>
			  			<div class="swiper-button-next"></div>
					</div>
				</div>
			</div>
	</div>

	<div class="map-container" id="location">
		<h3>Our location</h3>
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.711819845998!2d36.93865741445511!3d-0.41863723541239756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x18285df22a5127a5%3A0x153d3ca7f391daa0!2sPEMBE%20TATU!5e0!3m2!1sen!2ske!4v1662497178697!5m2!1sen!2ske" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
	</div>

	

	<!--------Footer--------->
	<div class="footer">
		<div class="footer-container">
			<div class="row">
				<div class="footer-col-1">
					<h3><b><i class="bi bi-house-door"></i> MANYUMBA HOUSING AGENTS</b></h3>
				</div>
				<div class="footer-col-2">
					<h3>Features</h3>
					<ul>
						<li><i class="bi bi-search"></i>  House search</li>
						<li><i class="bi bi-cash-coin"></i>  Rent payment processing</li>
						<li><i class="bi bi-ticket-perforated"></i>  Ticket raising</li>
						<li><i class="bi bi-graph-down"></i>  Reports</li>
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

	<div class="go-top">
		<a href="#top"><i class="bi bi-arrow-up-circle-fill"></i></a>
	</div>

	<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
	<script src="scrolljQuery.js"></script>
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

	<script type="text/javascript">
		var counter = 1;
		setInterval(function(){
			document.getElementById('radio' + counter).checked = true;
			counter++;

			if(counter > 2){
				counter=1;
			}
		}, 5000);
	</script>

	<!-- <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script> -->
	<script src="swiperjQuery.js"></script>

	<script>
		const swiper = new Swiper('.swiper', {
			autoplay: {
				delay: 10000,
				disableOnInteraction: false,
			},

 		 	loop: true,

 		 	pagination:{
 		 		el: '.swiper-pagination',
 		 		// clickable: true,
 		 	},

  
 		 	// Navigation arrows
 			navigation: {
 		   		nextEl: '.swiper-button-next',
 		   		prevEl: '.swiper-button-prev',
  			},

		});

	</script>

</body>
</html>