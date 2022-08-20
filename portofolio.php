<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Portofolio Kamibox | 2022</title>
	<link rel="shortcut icon" type="image/png" href="assets/images/favicon.png">
	<link rel="stylesheet" type="text/css" href="assets/css/auth_style.css">
	<!-- menu toggle icon -->
	<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
	<style type="text/css">
		body{
			background: white;
		}
		
	</style>
</head>
<body>

	<header>
		<?php include 'navbar.php';?>
	</header>


	<!-- layanan-->
	<section class="portofolio" >
		<div class="container portofolio-wrapper">
			<p class="heading1">PORTOFOLIO</p> 
			<p class="heading2">Kamibox</p>
		</div>
	</section>

	<!-- testi-->
	<section class="testi">
		<div class="container testi-wrapper">
			<div class="heading-testi">
				<h3>TESTIMON<span style="color:#08AC4D;">I</span></h3>
			</div>

			<div class="flex-testi-wrapper">
				<div class="card-testi">
					<img class="ft-testi" src="assets/images/Icon/testi1.png">
					<p class="user-testi">Kartini</p> 
					<p class="status-user-testi">Ibu Rumah Tangga</p>
					<p class="ct-testi">"Saya merasa sangat terbantu dengan adanya Kamibox. Kita dapat dengan mudah mengelola sampah tanpa repot."</p>
				</div>
				<div class="card-testi">
					<img class="ft-testi" src="assets/images/Icon/testi2.png">
					<p class="user-testi">Herman</p> 
					<p class="status-user-testi">Karyawan</p>					
					<p class="ct-testi">"Kamibox terbaik dalam pelayanannya. Saya merasa puas! Sampah di rumah bisa menghasilkan uang."</p>
				</div>
			</div>
		</div>
	</section>


	<!-- klien-->
	<section class="testi">
		<div class="container testi-wrapper">
			<div class="heading-testi">
				<h3>KLIE<span style="color:#08AC4D;">N</span></h3>
			</div>

			<div class="flex-klien-wrapper">
				<div class="card-klien">
					<img class="ft-klien" src="assets/images/Icon/klien-1.png">
				</div>
				<div class="card-klien">
					<img class="ft-klien" src="assets/images/Icon/klien-2.png">
				</div>
				<div class="card-klien">
					<img class="ft-klien" src="assets/images/Icon/klien-3.png">
				</div>
				<div class="card-klien">
					<img class="ft-klien" src="assets/images/Icon/klien-4.png">
				</div>
			</div>
		</div>
	</section>

		<!-- lisensi decreativeart-->
	<footer>
		<div class="heading-footer">
			<p id="heading" style="font-family: var(--main-font2);">Copyright <span class="subheading-footer">Kamibox.id</span> | This website is made by <span class="subheading-footer">Team De Creative Agency</span></p>
		</div>
	</footer>

	<script src="assets/js/jquery3.6.0.min.js"></script>
	<script src="assets/js/main.js"></script>

</body>
</html>