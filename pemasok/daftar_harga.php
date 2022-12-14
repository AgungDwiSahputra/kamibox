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

if (($status_login !== true) && empty($email)) {
    header("location:login.php");
}

//pastikan hanya pemasok yg boleh akses halaman ini
if ($level !== '3') {
    header("location:index.php");
}

//cek login
if ($status_login === true and !empty($email) and $level == '3') {
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
                -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
                background: #666;
            }

            ::-webkit-scrollbar-thumb {
                background: #232323;
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
                <div class="col">
                    <h2>Daftar Harga</h2>
                    <h5>
                        <a href="">Beranda</a>
                        <span class="panah">></span>
                        <a href="">Daftar Harga</a>
                    </h5>
                </div>
            </div>
            <div class="row body">
                <div class="col">
                    <ul>
                        <?php
                        include '../connect_db.php';

                        //query tampilkan nama barang
                        $query = mysqli_query($conn, "select * from barang");

                        while ($row = mysqli_fetch_array($query)) {
                            echo "<li>";
                            echo "<span class=jenis>" . $row['nama_barang'] . "</span>";
                            echo "<span class=harga> Rp. " . $row['harga_barang'] . "/kg </span>";
                            echo "</li>";
                        }

                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <br /><br />

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




<?php } ?>