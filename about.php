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
	<link rel="stylesheet" type="text/css" href="about.css">

	<title>About</title>
</head>
<body>
	
	<nav class="this-nav">
		<?php
			if(isset($_SESSION['mail'])){
				$current_user = $_SESSION['mail'];

				$this_res = mysqli_query($db, "SELECT * from users WHERE email='$current_user'");
				$this_row = mysqli_fetch_array($this_res);
				// if ($this_row['role'] ==  ) {
				if ($this_row['role'] == 'admin') {
				?>
					<div class="logo">
						<i class="bi bi-house-door"></i>  <b><span>Manyumba</span>Housing</b>
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
						<li class="nav-item nav-item-sub1"><a href="#">Services</a></li>
						<li class="nav-item nav-item-sub1"><a href="#contact">Contact</a></li>
						<li class="nav-item nav-item-sub1"><a href="dashboard">Admin panel</a></li>
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

				<?php }elseif ($this_row['role'] == 'tenant' ) { ?>
					<div class="logo">
						<i class="bi bi-house-door"></i>  <b><span>Manyumba</span>Housing</b>
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
						<li class="nav-item nav-item-sub1"><a href="#">Services</a></li>
						<li class="nav-item nav-item-sub1"><a href="#contact-us-now">Contact</a></li>
						<li class="nav-item nav-item-sub1 dropdown">
							<a href="#" data-action="dropdown-toggle"> <i class="bi bi-person-circle"></i> <?php

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
				<?php }elseif ($this_row['role'] == 'landlord') { ?>
					<div class="logo">
						<i class="bi bi-house-door"></i>  <b><span>Manyumba</span>Housing</b>
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
						<li class="nav-item nav-item-sub1"><a href="#">Services</a></li>
						<li class="nav-item nav-item-sub1"><a href="#contact-us-now">Contact</a></li>
						<li class="nav-item nav-item-sub1"><a href="landlord">Dashboard</a></li>
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
				<?php }
			} else{ ?>
				<div class="logo">
					<i class="bi bi-house-door"></i>   <b><span>Manyumba</span>Housing</b>
				</div>
				<button type="button" class="btn-hamburger" data-action="nav-toggle"> 
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
				</button>
				<ul class="nav-menu">
					<li class="nav-item nav-item-sub1"><a href="index">Home</a></li>
					<li class="nav-item nav-item-sub1"><a href="#">Services</a></li>
					<li class="nav-item nav-item-sub1"><a href="#contact-us-now">Contact</a></li>
					<li class="nav-item nav-item-sub1"><a href="registration"><i class="bi bi-person-plus"></i> Sign up</a></li>
					<li class="nav-item nav-item-sub2"><a href="login"><span><i class="bi bi-box-arrow-in-right"></i> Login</span></a></li>
				</ul>
			<?php }
		?>
					
	</nav>

	<div class="carry-all-about">
		
		<div class="contact-us">
			<h2>Our services</h2>
			<div class="contact-us-child contact-us-child-2">
				<i class="bi bi-search"></i><br>
				<h2>House search</h2>
				<p>	    Through our website, you are able to efficiently search for affordable houses from any of our available locations.<br>Sign up today to get started.</p>
			</div>
			<div class="contact-us-child contact-us-child-2">
				<i class="bi bi-cash-coin"></i><br>
				<h2>Rent payment</h2>
				<p>		Pay rent today through our website. This module is readily available for all our houses in the 'more details' section of a house.</p>
			</div>
			<div class="contact-us-child contact-us-child-2">
				<i class="bi bi-ticket-perforated"></i><br>
				<h2>Ticket raising</h2>
				<p>	    This is a feature that allows all registered users to raise any concerns they may have, be it related to our website or their rental property.</p>
			</div>
			<div class="contact-us-child contact-us-child-2">
				<i class="bi bi-patch-question-fill"></i><br>
				<h2>General inquiries</h2>
				<p>		Send us an email today for any questions you may be having concerning us and our services.<br>This feature is available to all our registered and unregisterd system users.
			</div>
			<div class="contact-us-child contact-us-child-2">
				<i class="bi bi-graph-down"></i><br>
				<h2>Report generation</h2>
				<p>		All our registered landlords will have access to monthly and annually reports based on rent received from their property and the house occupancy percentage as well, allowing them to visuallize their profits.</p>
			</div>
		</div>
		
		<div class="mission">
			<h3>Our mission</h3>
			<p><i>
				      To provide the best online services related to property renting thereby allowing all our tenants and potential tenants to comfortablly search for affordable houses in a location of their choice from the comfort of wherever they may be and to as well process their rent payment via our website.

				
			</i></p>
			
			<h3>Our vision</h3>
			<p><i>
				      To be the leading real estate agency within our nation and to as well revolutionize this amazing nation into embrassing online real estate services.
				
				

				
			</i></p>
			<p><i>
				Join us today to make our vision a reality.... build the future you hope for.
				
				

				
			</i></p>
		</div>
		
	
		<div id="contact-us-now" class="contact-us">
			<h2>Contact Us</h2>
			<div class="contact-us-child">
				<i class="bi bi-patch-question-fill"></i><br>
				<h2>General Inquiries</h2>
				<p>		Send as an email today for any question you may be having.....</p>
				<button id="show-login-2" class="show-btn">Send email</button>
			</div>
			
			<div class="contact-us-child">
				<i class="bi bi-telephone-inbound-fill"></i><br>
				<h2>Our contacts</h2>
				<p>		Get in touch with us today for any inquiries or assistance you may need.</p>
				<p></p>
				<p>
					011223344566; whatsapp & calls <br>
					<a href="tel:+254 797 561665">0797 561665;</a> calls only<br>
					<h5>Email: mayomiles15@gmail.com</h5>
				</p>
			</div>
			
			<div class="contact-us-child">
				<i class="bi bi-ticket-detailed"></i><br>
				<h2>Raise ticket</h2>
				<p>		Already a registered user and you have probably encountered an issue?</p>
				<button id="show-login" class="show-btn">Raise ticket</button>
			</div>
		</div>


		<div class="popup">
			<div class="close-btn">&times;</div>
			<div class="pop-heading">
				<h1>Raise ticket</h1>
			</div>
			<?php
				if(isset($_SESSION['mail'])){ 
					$mail_search = $_SESSION['mail'];
					$res44 = mysqli_query($db, "SELECT name from users WHERE email='$mail_search'");
					$row44 = mysqli_fetch_array($res44);
					?>
					<form method="post" action="#">
						<?php include 'ticket.php'; ?>

						<div class="pop-text-area">
							<label for="name">Name:</label><br>
							<input type="email" name="name" value="<?php echo $row44['name']; ?>" readonly required>
						</div>
						<div class="pop-text-area">
							<label for="tenantemail">Email:</label><br>
							<input type="email" name="useremail" value="<?php echo $_SESSION['mail']; ?>" readonly required>
						</div>

						<div class="pop-text-area">
							<label for="amount">Concern:</label><br>
							<textarea name="concern"></textarea>
						</div>

						<div class="pop-bt">
							<input type="submit" name="sendticket" value="Raise ticket">
						</div>				
					</form>
				<?php }else{ ?>
					<div class="pop-bt">
						<label for="">Kindly <a href="login">login </a> first to enjoy this service.</label><br>
					</div>
				<?php }
			?>
		</div>

		<div class="popup-2">
			<div class="close-btn-2">&times;</div>
			<div class="pop-heading">
				<h1>Inquiry</h1>
			</div>
			<form action="https://formsubmit.co/1322c2ab0f184f986942250311898847" method="POST">
				<div class="pop-text-area">
					<label for="tenantemail">Email:</label><br>
					<input type="email" name="from" required>
				</div>

				<div class="pop-text-area">
					<label for="inquiry">Question:</label><br>
					<textarea name="inquiry" required></textarea>
				</div>

				<div class="pop-bt">
					<input type="submit" name="sendemail" value="Send email">
				</div>				
			</form>
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
						<li><i class="bi bi-telephone-inbound-fill"></i>  0797 561665</li>
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
	<a href="about"><i class="bi bi-arrow-up-circle-fill"></i></a>
</div>
	


	<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
	<script src="scrolljQuery.js"></script>

	<script type="text/javascript">
		document.querySelector("#show-login").addEventListener("click", function(){
			document.querySelector(".popup").classList.add("active");
		});
		document.querySelector(".popup .close-btn").addEventListener("click", function(){
			document.querySelector(".popup").classList.remove("active");
		});



		document.querySelector("#show-login-2").addEventListener("click", function(){
			document.querySelector(".popup-2").classList.add("active-2");
		});
		document.querySelector(".popup-2 .close-btn-2").addEventListener("click", function(){
			document.querySelector(".popup-2").classList.remove("active-2");
		});
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