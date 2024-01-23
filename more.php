<?php
	
	session_start();

	error_reporting(0);
	include 'db_connection.php';
	include 'status.php';


	if(isset($_GET['ID'])){

		$ID = mysqli_real_escape_string($db, $_GET['ID']);


		$sql = "SELECT * from houseinfo where houseID='$ID'"; 
		$res = mysqli_query($db, $sql);
		$row = mysqli_fetch_array($res);
	}
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
	<title>More details</title>
</head>
<body>
	
	<nav class="this-nav">
		<?php
			if(isset($_SESSION['mail'])){ ?>
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
					<li class="nav-item nav-item-sub1"><a href="about#contact-us-now">Contact</a></li>
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
			<?php }else{ ?>
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
					<li class="nav-item nav-item-sub1"><a href="index">Home</a></li>
					<li class="nav-item nav-item-sub1"><a href="#contact">Raise ticket</a></li>
				</ul>
			<?php }
		?>	
	</nav>

	<div class="carry-all">	
		<div class="small-container space-up">
			<div class="row">
				<div class="col-2">
					<?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage1']).'" alt="" style="width:100%; height:400px; position:center;" id="ProductImg">'; ?>

					<div class="small-img-row">
						<div class="small-img-col">
							<?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage1']).'" alt="" style="width:100%; height:100%; position:center;" class="small-img">'; ?>
								
						</div>
						<div class="small-img-col">
							<?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage2']).'" alt="" style="width:100%; height:100%; position:center;" class="small-img">'; ?>
						</div>
						<div class="small-img-col">
							<?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage3']).'" alt="" style="width:100%; height:100%; position:center;" class="small-img">'; ?>
						</div>
						 <div class="small-img-col"> 
							<?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage4']).'" alt="" style="width:100%; height:100%; position:center;" class="small-img">'; ?>
						</div>
						<div class="small-img-col">
							<?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage5']).'" alt="" style="width:100%; height:100%; position:center;" class="small-img">'; ?>
						</div>
					</div>
				</div>

				<div class="col-2 col-2-info">
					<div class="top">
						House Info:<br>
					</div>
					<p>Loction: <?php echo $row["location"]; ?><br>
					Bedroom: <?php echo $row["bedroom"]; ?><br>
					Rent: <?php echo $row["rent"]; ?><br>
					House status: <?php echo $row["houseStatus"]; ?><br>
					House ID: <?php echo $row["houseID"]; ?><br>
					</p>
					<div class="descrip">
						<p><span class="description">Description <i class="bi bi-card-text"></i></span><hr><br>
						<?php echo $row["houseDescription"]; ?></p>
						<p>Caretaker: <?php echo $row["caretakerName"]; ?><br>
							Contact: <?php echo $row["caretakerNumber"]; ?>
						</p><br>
					</div>
					<p></p><br>

					<div class="up-bt">
						<?php
							if(isset($_SESSION['mail'])){
								echo " <a href='paymentform?HID={$row['houseID']}'> <input type='submit' name='pay' value='Pay now'/> </a>";
							}else{
								echo " <a href='login'> <input type='submit' name='pay' value='Pay now'/> </a>";
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!--------Footer--------->
	<div class="footer2">
		<div class="container">
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

</body>
</html>