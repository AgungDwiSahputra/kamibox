<?php 
error_reporting(0);
//cek login
		if($_SESSION['login']==true && $_SESSION['level_user']=='1'||$_SESSION['login']==true && $_SESSION['level_user']=='2' || $_SESSION['login']==true && $_SESSION['level_user']=='3'){
			header("location:index.php");
		}else{

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Kirim Ulang OTP</title>
	<link rel="shortcut icon" type="image/png" href="assets/icon.png">
	<link rel="stylesheet" type="text/css" href="assets/css/auth_style3.css">
	<style type="text/css">
		.btn-otp-viaemail2{
			margin-top: 20px;
			width: 400px;
			font-family: var(--main-font);
			text-align: center;
			background-color: #000;
			color: #fff;
			padding: 10px;
			font-weight: 500;
			font-size: 1rem;
			border-radius: 30px;
			border: 1px solid #000;
			box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.3);
			-webkit-transition :0.5s;
			transition: 0.5s;
			outline: none;
		}
		.form-email{
			margin-top: 10px;
		}
		.input-email{
			width: 180px;
			height: 30px;
			text-align: center;
			border : 1px solid rgba(0,0,0,0.5);
			margin-top: 20px;
			margin-bottom: 50px;
		}
		.btn-submit-otp2{
			width: 100px;
			font-family: var(--main-font);
			background-color: #FFF;
			color: #000;
			padding: 2px 4px;
		    font-weight: 700;
		    font-size: 0.8rem;
		    border-radius: 1px;
			border: 1px solid #000;
			box-shadow: 0px 2px 4px 0px rgba(0,0,0,0.5);
		  	-webkit-transition: 0.5s;
		  	transition: 0.5s;
		  	outline: none;	
		}
		.validasi-otp2{
			font-size: 0.8rem;
			margin-top: 8px;
			color: orangered;
		}
		.nav-wrapper .menu-wrapper{
			display: none;
			opacity: 0;
		}

		.nav-wrapper .menu-wrapper .menu{
			display: none;
			opacity: 0;
		}

		.menu-wrapper .menu .menu-link{
			display: none;
			opacity: 0;
		}

	</style>
</head>
<body>
	<header>
		<?php include "navbar.php"; ?>
	</header>

	<section class="otp">
		<div class="otp-wrapper">
			<div class="otp-card">
				<h3 class="heading-otp">Kirim OTP Terbaru</h3>
				<div class="btn-otp">
					<span class="btn-otp-viaemail2">Kami akan mengirimkan kode OTP terbaru Anda.</span>
					<div class="heading-validasi-otp">
						<span >Masukkan <span style="color:red;">Email </span> Anda</span>
					</div>
					<div class="heading-error-otp">
					<?php 
						session_start();

							if(isset($_GET['pesan'])){
								if($_GET['pesan']=='validasi'){
									$validasi = $_SESSION['validasi'];
									echo "<p class='validasi-otp2'>".$validasi."</p>";
								}
							}
					?>
					</div>

					<form action="proses_akun_aktif.php" method="post">
						<div class="form-email">
							<input type="text" class="input-email" name="email" placeholder="masukkan email Aktif">
							<input type="submit" class="btn-submit-otp2" name="submit" value="kirim otp">							
						</div>
	
					</form>

				</div>
			</div>
		</div>
	</section>
</body>
</html>
<?php }?>