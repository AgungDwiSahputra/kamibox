<?php
session_start();
include '../connect_db.php';
include 'session_timeout.php';

//cek status login user di session//
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

/* EKSEKUSI UPDATE PROFILE */
if (isset($_POST['update'])) {
    $idProfile = $_POST['id_user'];
    $namaProfile = $_POST['nama'];
    $emailProfile = $_POST['email'];
    $no_telpProfile = $_POST['no_telp'];
    $alamatProfile = $_POST['alamat'];
    $norekProfile = $_POST['norek'];

    $query = mysqli_query($conn, "UPDATE users SET nama_lengkap = '$namaProfile', email = '$emailProfile', notelp = '$no_telpProfile', alamat = '$alamatProfile', nomor_rekening = '$norekProfile' WHERE id_user = '$idProfile'");

    if ($query) {
        header("Location:index.php");
    }
}
/* ================================= */

//cek login
if ($status_login === true and !empty($email) and $level == '3') {
    //echo "pemasok page. <a href='logout.php'>Logout</a>";

?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Data Diri | Pemasok Kamibox</title>
        <link rel="shortcut icon" href="../assets/icon.png" type="image/x-icon">
        <!-- Custom CSS -->
        <link href="css/style.css" rel="stylesheet">
        <style type="text/css">
           @media screen and (max-width: 750px) {
            .navigation{
                width: 70px;
            }
           }

           @media screen and (max-width: 550px) {
                
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
                    width: 65%;
                    margin-left: 80px;
                    padding: 0px;
                    overflow: scroll;
                }
                .container .row.body li{
                    padding: 15px 20px;
                    height: 50px;
                    border: 1px solid rgba(0, 0, 0, 0.2);
                    border-radius: 10px;
                    margin: 10px 0;
                    display: block;
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
                    margin-left: 80px;
                    padding: 0px;
                    overflow: scroll;
                }
            .container .row.body li{
                    padding: 15px 20px;
                    height: 70px;
                    border: 1px solid rgba(0, 0, 0, 0.2);
                    border-radius: 10px;
                    margin: 10px 0;
                    display: block;
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
                <h2>Data Diri</h2>
                <h5>
                    <a href="index.php">Beranda</a>
                    <span class="panah">></span>
                    <a href="profile.php">Profile</a>
                </h5>
            </div>
            <div class="row body">
                <form action="" method="post">
                    <ul>
                        <?php
                        include '../connect_db.php';

                        //query tampilkan nama barang
                        $query = mysqli_query($conn, "select * from users where id_user = $id_user");

                        while ($row = mysqli_fetch_assoc($query)) {
                            // echo "<li>";
                            // echo "<span class=jenis>Nama </span>";
                            // echo "<span class=harga>" . $row['nama_lengkap'] . "</span>";
                            // echo "</li>";
                            // echo "<li>";
                            // echo "<span class=jenis>Email </span>";
                            // echo "<span class=harga>" . $row['email'] . "</span>";
                            // echo "</li>";
                            // echo "<li>";
                            // echo "<span class=jenis>Nomor Ponsel </span>";
                            // echo "<span class=harga>" . $row['notelp'] . "</span>";
                            // echo "</li>";
                            // echo "<li>";
                            // echo "<span class=jenis>Alamat </span>";
                            // echo "<span class=harga>" . $row['alamat'] . "</span>";
                            // echo "</li>";
                        ?>
                            <li>
                                <span class="jenis" for="nama">Nama </span>
                                <input class="harga" name="id_user" value="<?= $row['id_user'] ?>" hidden>
                                <input class="harga" id="nama" name="nama" value="<?= $row['nama_lengkap'] ?>">
                            </li>
                            <li>
                                <span class="jenis" for="email">Email </span>
                                <input class="harga" id="email" name="email" value="<?= $row['email'] ?>">
                            </li>
                            <li>
                                <span class="jenis" for="no_telp">Nomor Ponsel </span>
                                <input class="harga" id="no_telp" name="no_telp" value="<?= $row['notelp'] ?>">
                            </li>
                            <li>
                                <span class="jenis" for="alamat">Alamat </span>
                                <textarea class="harga" id="alamat" name="alamat" value="<?= $row['alamat'] ?>"><?= $row['alamat'] ?></textarea>
                            </li>
                            <li>
                                <span class="jenis" for="norek">Nomor Rekening </span>
                                <input class="harga" id="norek" name="norek" value="<?= $row['nomor_rekening'] ?>" placeholder="Masukan Nomor Rekening">
                            </li>
                        <?php
                        }

                        ?>
                        <button type="submit" name="update" class="btn default ml-5s">Update</button>
                    </ul>
                </form>
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