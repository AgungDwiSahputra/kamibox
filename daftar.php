<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Daftar Kamibox | 2022</title>
	<link rel="shortcut icon" type="image/png" href="assets/icon.png">
	<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="assets/css/auth_style3.css">
	<style type="text/css">
		
	</style>
</head>
<body>
	<header>
		<?php include "navbar.php";?>
	</header>
	<section class="daftar">
		<div class="container daftar-wrapper">
			<div class="content-left">
				<div class="img-daftar">
					<img src="assets/images/design-5.png">
				</div>
			</div>

			<div class="content-right">
				<div class="card-daftar">
					<div class="heading-daftar">
                    	<h2 class="heading-welcome">Selamat Datang</h2>
                    	<p class="subheading-welcome">Silahkan isi kolom di bawah ini</p>
                	</div>

                	<div class="heading-error-daftar">
                		<?php
                			session_start();
                			if(isset($_GET['pesan'])){
                				if($_GET['pesan']== "validasi"){
	                				$validasi=$_SESSION['validasi'];
    		            				foreach ($validasi as $value) {
											echo "<p class='subheading-error-daftar'>$value</p>";
										}	
                				}else{
                					if($_GET['pesan']== "checklist"){
                						$value = $_SESSION['validasi'];
										echo "<p class='subheading-error-daftar'>$value</p>";
										
                					}
                				}
                			}
                		?>
                	</div>

                	<form action="cek_daftar.php" method="post">	
	                	<div class="form-daftar">                    
		                    <div class="input-form-daftar">
		                        <i class='bx bxs-user icon-daftar' style="font-size: 1.5rem;"></i>
		                        <input class="input-field-daftar <?php if(!empty($validasi['nama'])){echo "input-field-daftar-error";}?>" type="text" placeholder="isi dengan nama lengkap anda" name="nama" value="<?php if(!empty($_SESSION['set_nama'])){echo $_SESSION['set_nama'];}else{echo $_SESSION['set_nama']='';}?>" />  
		                    </div>
		                    <div class="input-form-daftar">
		                        <i class='bx bxs-envelope icon-daftar' style="font-size: 1.5rem;"></i>
		                        <input class="input-field-daftar <?php if(!empty($validasi['email'])){echo "input-field-daftar-error";}?>" type="email" placeholder="isi dengan email aktif" name="email" value="<?php if(!empty($_SESSION['set_email'])){echo $_SESSION['set_email'];}else{echo $_SESSION['set_nama']='';}?>" />  
		                    </div>
		                    <div class="input-form-daftar">
		                        <i class='bx bxs-phone icon-daftar' style="font-size: 1.5rem;"></i>
		                        <input class="input-field-daftar <?php if(!empty($validasi['notelp'])){echo "input-field-daftar-error";}?>" type="text" placeholder="isi dengan nomor aktif" name="notelp" value="<?php if(!empty($_SESSION['set_notelp'])){echo $_SESSION['set_notelp'];}else{echo $_SESSION['set_nama']='';}?>" />  
		                    </div>                    
		                </div>

		                <div class="checklist-daftar">
		                    <div class="check">
		                        <input class="check-permis <?php if($_GET['pesan']== "checklist"){echo "check-permis-error";}?>" type="checkbox" name="checklist">
		                        <span class="checkmark"></span>
		                    </div>
		                    <div class="check">
		                        <p class="text-permis" style="font-size:0.8rem;">Dengan mendaftar, saya setuju pada <span style="color:blue;">Syarat & Ketentuan </span> dan <span style="color:blue">Kebijakan Privasi </span> Kamibox.id</p>  
		                    </div>
		                </div>

		                <div class="btn-daftar">
		                    <i class="icon-btn"></i>
		                      <input class="btn-submit-daftar" style="margin-left: 20px;" type="submit" value="Daftar"/>  
		                </div>
		           </form>

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

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="assets/js/main.js"></script>

</body>
</html>