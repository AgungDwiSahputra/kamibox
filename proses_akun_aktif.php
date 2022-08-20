<?php 
session_start();

	include 'connect_db.php';

	if ($_POST['submit']=='kirim otp') {
		
		$email = $_POST['email'];

		if ($email == "") {
		
			$validasi = "Email harus diisi.";
		
		}else{
			
			//jika email tersedia di database

			$cek_email = mysqli_query($conn,"select * from users where email='$email'");

			$cek_rows = mysqli_num_rows($cek_email);
		
			if ($cek_rows>0) {         //jika email tersedia di database.";

				//cek status email

				//cek status
				$cek_status_email = mysqli_query($conn,"select * from users where email='$email' and active='0'");
				$data_Users = mysqli_fetch_array($cek_status_email);
				$cek_rows_status = mysqli_num_rows($cek_status_email);

				if($cek_rows_status>0){

					//update active= N di tble kodeotp where email

					//generate otp baru
					include 'build_otp.php';

					if(generate_otp($email) == true){

						include 'send_email.php';

						//get nama where email di tb users
						$nama = $data_Users['nama'];
						$_SESSION['email'] = $email;
			            $_SESSION['nama'] = $nama;
			            $_SESSION['iduser'] = $data_Users['id_user'];
						//get otp
						$otp = $_SESSION['kode_otp'];
				// 		var_dump($data_Users['id_user']);
				// 		var_dump($_SESSION['iduser']);

						if (send_otp_via_email($email, $nama, $otp)== true) {
							header('location:otp.php');
						}else{
							echo " gagal kirim email.";
						}
						
					}else{
						echo "gagal generate otp.";
					}


				}else{
					//jika email aktif
					$validasi = "Email Anda sudah aktif di database kami. Silahkan <a href='login.php'>login!</a>";

				}

			}else{
				//jika email tidak tersedia di database
				//header("location:aktifkan_akun_via_otp.php?email=tidak_tersedia");	
				$validasi = "Email tidak tersedia di database.";
			}

		}



		if (!empty($validasi)) {

			//jika validasi true
			$_SESSION['validasi'] = $validasi;
			header('location:aktifkan_akun_via_otp.php?pesan=validasi');
		}

	}
?>