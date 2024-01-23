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
	<title>Houses</title>
</head>
<body>
	
	<nav id="top" class="this-nav">
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
					<ul class="nav-menu"><li>
						<li class="nav-item nav-item-sub1"><a href="about">About us</a></li>
						<li class="nav-item nav-item-sub1"><a href="about#contact-us-now">Raise ticket</a></li>
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
						<li class="nav-item nav-item-sub1"><a href="about">About us</a></li>
						<li class="nav-item nav-item-sub1"><a href="about#contact-us-now">Raise ticket</a></li>
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
						<li class="nav-item nav-item-sub1"><a href="about">About us</a></li>
						<li class="nav-item nav-item-sub1"><a href="about#contact-us-now">Raise ticket</a></li>
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
			}
		?>
					
	</nav>

	<div class="carry-all">
		<div class="search-area">
			<div class="search-area4">
				<div class="search-area3">
					<form action="" method="post">
						<div class="search-area2">
							<div class="input-box">
								<input type="text" name="search-detail" id="search-detail" placeholder="location/rent/bedroom_no" required/>
							</div>
							<div class="up-bt">
								<input type="submit" name="search" value="SEARCH"/>
							</div>
						</div>
					</form>
				</div>
				<!-- <div class="up-bt">
					<input type="button" name="all" value="ALL"/>
				</div> -->
			</div>	
		</div>

		<div class="carry-all-2">
		<div class="home-categories">
		    <div id="top2"></div>
			<h3>Categories</h3>
			<ul>
				<li><i class="bi bi-house-door"></i> Type  <span>&#8250;</span><br>
					<div class="categories-list">
						<ul>
							<!-- <?php
				 				// echo " <a href='categories?cat={1}'><i class='bi bi-dot'></i> 1 Bedroom</a>"; 
					 		?> -->
							<li> <?php echo " <a href='categories?cat=1'><i class='bi bi-dot'></i> 1 Bedroom</a>"; ?></li>
							<li><?php echo " <a href='categories?cat=2'><i class='bi bi-dot'></i> 2 Bedrooms</a>"; ?></li>
							<li><?php echo " <a href='categories?cat=3'><i class='bi bi-dot'></i> 3 Bedrooms</a>"; ?></li>
							<li><?php echo " <a href='categories?cat=4'><i class='bi bi-dot'></i> 4 Bedrooms</a>"; ?></li>
							<li><?php echo " <a href='categories?cat=Single room'><i class='bi bi-dot'></i> Singleroom</a>"; ?></li>
							<li><?php echo " <a href='categories?cat=Bedsitter'><i class='bi bi-dot'></i> Bedsitter</a>"; ?></li>
						</ul>
					</div>
					
				</li>
				<li><i class="bi bi-geo-alt"></i>  Location  <span>&#8250;</span><br>
					<div class="categories-list">
						<ul>
							<li><?php echo " <a href='categories?cat=Farm lands'><i class='bi bi-dot'></i> Farm lands</a>"; ?></li>
							<li><?php echo " <a href='categories?cat=Chania'><i class='bi bi-dot'></i> Chania</a>"; ?></li>
							<li><?php echo " <a href='categories?cat=Kingongo'><i class='bi bi-dot'></i> Kingongo</a>"; ?></li>
							<li><?php echo " <a href='categories?cat=Nyeri view'><i class='bi bi-dot'></i> Nyeri view</a>"; ?></li>
						</ul>
					</div>
				</li>
				<li><i class="bi bi-coin"></i>  Rent  <span>&#8250;</span><br>
					<div class="categories-list">
						<ul>
							<li><?php echo " <a href='categories?cat=7000'><i class='bi bi-dot'></i> Below 7,000</a>"; ?></li>
							<li><?php echo " <a href='categories?cat2=16000'><i class='bi bi-dot'></i> Below 16,000</a>"; ?></li>
							<li><?php echo " <a href='categories?cat3=26000'><i class='bi bi-dot'></i> Below 26,000</a>"; ?></li>
							<li><?php echo " <a href='categories?cat4=36000'><i class='bi bi-dot'></i> Below 36,000</a>"; ?></li>
							<li><?php echo " <a href='categories?cat5=36000'><i class='bi bi-dot'></i> Above 36,000</a>"; ?></li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
		<div class="small-container-2">
		<div class="small-container">
			<div class="row row-home">
				<?php
					error_reporting(0);
					$searchDetail = mysqli_real_escape_string($db, $_POST['search-detail']);

					if(isset($_POST['search'])){
						$res = mysqli_query($db, "SELECT * from houseinfo WHERE (location='$searchDetail' OR rent='$searchDetail' OR bedroom='$searchDetail') AND houseStatus='vaccant'");
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
		</div>


		<div class="small-container">
			<div class="row row-home">
				<?php

					$res = mysqli_query($db, "SELECT * from houseinfo WHERE houseStatus='vaccant'");
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
					 				echo " <a href='more?ID={$row['houseID']}'> MORE &#8594; </a>"; 
					 		?></button>
						</div>
					</div>
					<?php
					}
				?>
			</div>
			<button class="btn">More</button>
		</div>
		</div>
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
	<a href="#top2"><i class="bi bi-arrow-up-circle-fill"></i></a>
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