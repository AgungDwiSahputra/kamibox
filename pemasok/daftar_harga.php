<?php 
session_start();
include '../connect_db.php';
include 'session_timeout.php';

//cek status login user di session
		$status_login = $_SESSION['login'];
		$id_user      = $_SESSION['id_user'];
        $email        = $_SESSION['email_user'];
        $avatar       = $_SESSION['avatar_user'];
        $nama         = $_SESSION['nama_user'];
        $telp         = $_SESSION['notelp_user'];
        $level        = $_SESSION['level_user'];
        $status_user  = $_SESSION['status_user'];	
		
		if(($status_login !== true) && empty($email)){
			header("location:login.php");
		}
		
        //pastikan hanya pemasok yg boleh akses halaman ini
		if($level !== '3'){
			header("location:index.php");
		}

		//cek login
		if($status_login === true and !empty($email) and $level == '3'){
			//echo "pemasok page. <a href='logout.php'>Logout</a>";
		
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Daftar Harga | Pemasok Kamibox</title>
	<link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
	<!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
            ::-webkit-scrollbar {
                width: 10px;
            }
             
            ::-webkit-scrollbar-track {
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);     
                background: #666;    
            }
             
            ::-webkit-scrollbar-thumb {
                background: #232323;
            }

        @media screen and (max-width: 750px) {
            .navigation{
                width: 70px;
            }

            .row{
                margin: 10px auto;
            }

            .container .row:nth-child(2){
                    background-color: #fff;
                    border-radius: none;
                    box-shadow: none;
                    width: 80%;
                    padding: 0px;
                    overflow: scroll;
            }

        }

        @media screen and (max-width: 550px) {
                body{
                    font-size: 12px;
                }
                .navigation{
                    width: 60px;
                    top: 10px;
                    left: 1px;
                    bottom: 10px;
                }

                .navigation-top ul{
                    padding: 0 8px;
                }

                .navigation-top ul li a .user{
                    width: 25px;
                }
                .navigation-top ul li a .bell{
                    width: 18px;
                }

                .row{
                    margin: 0px auto;
                }
                .container .row{
                    margin-top: 40px;
                    margin-left: 85px;
                }
                .container .row:nth-child(2){
                    background-color: #fff;
                    border-radius: none;
                    box-shadow: none;
                    width: 60%;
                    margin-left: 85px;
                    padding: 0px;
                    overflow: scroll;
                }

                .container .row.body ul{
                    padding: 10px 8px;
                }
                .container .row.body li{
                    padding: 5px 20px;
                    height: 20px;
                    border-radius: 30px;
                    margin: 8px 0;
                }


        }

        @media screen and (max-width: 450px) {
            
            .navigation ul li .icon img.putih,
            .navigation ul li .icon img.hijau{
                width: 25px;
            }

            .navigation-top ul li.nav-left{
                margin-left: 80px;
                margin-top: 15px;
                font-size: 12px;
            }

            .toggle img.close{
                width: 25px;
                margin-left: 5px;
            }

            .container .row:nth-child(2){
                    background-color: #fff;
                    border-radius: none;
                    box-shadow: none;
                    width: 80%;
                    padding: 0px;
                    overflow: scroll;
                    margin-left: 75px;
            }

            .container .row.body ul{
                    padding: 8px 6px;
            }
            .container .row.body li{
                    padding: 5px 10px;
                    height: 15px;
                    border-radius: 20px;
                    margin: 6px 0;
            }

        }




    </style>
</head>

<body>
	<!-- NAVIGATION TOP -->
        <?php require '../nav-top.php'; ?>
        <!-- ============================= -->

        <div class="navigation">
        <ul>
            <div class="toggle">
                <img src="../assets/Logo Kamibox Putih.png" alt="Logo Kamibox" class="open">
                <img src="../assets/logo.png" alt="Logo Kamibox" class="close">
            </div>
            <li class="list">
                <b></b>
                <b></b>
                <a href="index.php">
                    <span class="icon">
                        <img src="../assets/Icon/home_p.png" alt="Beranda" class="putih">
                        <img src="../assets/Icon/home_h.png" alt="Beranda" class="hijau">
                    </span>
                    <span class="title">Beranda</span>
                </a>
            </li>
            <li class="list">
                <b></b>
                <b></b>
                <a href="riwayat_transaksi.php">
                    <span class="icon">
                        <img src="../assets/Icon/transaction_p.png" alt="Riwayat Transaksi" class="putih">
                        <img src="../assets/Icon/transaction_h.png" alt="Riwayat Transaksi" class="hijau">
                    </span>
                    <span class="title">Riwayat Transaksi</span>
                </a>
            </li>
            <li class="list active">
                <b></b>
                <b></b>
                <a href="daftar_harga.php">
                    <span class="icon">
                        <img src="../assets/Icon/input_p.png" alt="Input Data" class="putih">
                        <img src="../assets/Icon/input_h.png" alt="Input Data" class="hijau">
                    </span>
                    <span class="title">Harga Barang</span>
                </a>
            </li>
        </ul>
    </div>

        <!-- ====================================== -->
    <!-- ISI CONTENT -->
    <!-- ====================================== -->
    <div class="container">
        <div class="row header">
            <h2>Daftar Harga</h2>
            <h5>
                <a href="">Beranda</a>
                <span class="panah">></span>
                <a href="">Daftar Harga</a>
            </h5>
        </div>
        <div class="row body">
            <ul>
                <?php 
                include '../connect_db.php';

                //query tampilkan nama barang
				$query = mysqli_query($conn, "select * from barang");
                
                while($row=mysqli_fetch_array($query)){
					echo "<li>";
					echo "<span class=jenis>".$row['nama_barang']."</span>";
					echo "<span class=harga> Rp. ".$row['harga_barang']."/kg </span>";
					echo "</li>";
				}

                ?>
            </ul>

        </div>
    </div>
    <br/><br/>

    <!-- ====================================== -->
    <!-- JAVA SCRIPT -->
    <!-- ====================================== -->
    <!-- Navigation Interactive -->
    <script>
        let list = document.querySelectorAll('.navigation .list'); //NAVIGATION
        let nav_dropdown = document.querySelectorAll('.nav-dropdown #nav-ListDropdown');
        let nav_ListDropdown = document.querySelectorAll('.navigation-top ul li .nav-ListDropdown');

        //Dropdown Navigasi
        {
            let active = 0;
            for (let i = 0; i < nav_dropdown.length; i++) {
                nav_dropdown[i].onclick = function() {
                    let j = 0;
                    if (active == 0) {
                        while (j < nav_ListDropdown.length) {
                            nav_ListDropdown[j++].className = "nav-ListDropdown";
                        }
                        nav_ListDropdown[i].className = "nav-ListDropdown active";
                        active = 1;
                    } else {
                        while (j < nav_ListDropdown.length) {
                            nav_ListDropdown[j++].className = "nav-ListDropdown";
                        }
                        nav_ListDropdown[i].className = "nav-ListDropdown";
                        active = 0;
                    }

                }
            }
        }
    </script>

    <!-- Toggle Button untuk Navigation -->
    <script>
        let menuToggle = document.querySelector('.toggle');
        let navigation = document.querySelector('.navigation');
        menuToggle.onclick = function() {
            menuToggle.classList.toggle('active');
            navigation.classList.toggle('active');
        }
    </script>

</body>

</html>




<?php }?>