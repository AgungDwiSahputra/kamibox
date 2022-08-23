<?php
include '../connect_db.php';
require '../session_data.php';

//pastikan hanya pemasok yg boleh akses halaman ini
if ($level !== '1') {
    header("location:index.php");
}

if (isset($_POST['update'])) {
    $idProfile = $_POST['id_user'];
    $namaProfile = $_POST['nama'];
    $emailProfile = $_POST['email'];
    $no_telpProfile = $_POST['no_telp'];
    $nama_jalanProfile = $_POST['nama_jalan'];
    $kotaProfile = $_POST['kota'];
    $provinsiProfile = $_POST['provinsi'];
    $negaraProfile = $_POST['negara'];
    $kd_posProfile = $_POST['kd_pos'];
    $norekProfile = $_POST['norek'];

    $query = mysqli_query($conn, "UPDATE users SET nama_lengkap = '$namaProfile', email = '$emailProfile', notelp = '$no_telpProfile', nama_jalan = '$nama_jalanProfile', kota = '$kotaProfile', provinsi = '$provinsiProfile', negara = '$negaraProfile', kd_pos = '$kd_posProfile',  nomor_rekening = '$norekProfile' WHERE id_user = '$idProfile'");

    if ($query) {
        setcookie('sukses', 'Berhasil Update Data Diri', time() + 3, '/');
        header("Location:profile.php");
    }
}

//cek login
if ($status_login === true and !empty($email) and $level == '1') {
    //echo "pemasok page. <a href='logout.php'>Logout</a>";

?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Profile | <?= $nama ?></title>
        <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
        <!-- Custom CSS -->
        <link href="css/style.css" rel="stylesheet">
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
                    <a href="jadwal_penjemputan.php">
                        <span class="icon">
                            <img src="../assets/Icon/calendar_p.png" alt="Jadwal Kurir" class="putih">
                            <img src="../assets/Icon/calendar_h.png" alt="Jadwal Kurir" class="hijau">
                        </span>
                        <span class="title">Jadwal Penjemputan</span>
                    </a>
                </li>
                <li class="list">
                    <b></b>
                    <b></b>
                    <a href="input_data.php">
                        <span class="icon">
                            <img src="../assets/Icon/input_p.png" alt="Input Data" class="putih">
                            <img src="../assets/Icon/input_h.png" alt="Input Data" class="hijau">
                        </span>
                        <span class="title">Input Data</span>
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
                <ul>
                    <?php
                    //query tampilkan nama barang
                    $query = mysqli_query($conn, "select * from users where id_user = $id_user");

                    while ($row = mysqli_fetch_assoc($query)) {
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
                            <span class="jenis" for="nama_jalan">Nama Jalan </span>
                            <input class="harga" type="text" id="nama_jalan" name="nama_jalan" value="<?= $row['nama_jalan'] ?>" placeholder="Masukan Nama Jalan">
                        </li>
                        <li>
                            <span class="jenis" for="kota">Kota </span>
                            <input class="harga" type="text" id="kota" name="kota" value="<?= $row['kota'] ?>" placeholder="Masukan Kota">
                        </li>
                        <li>
                            <span class="jenis" for="provinsi">Provinsi </span>
                            <input class="harga" type="text" id="provinsi" name="provinsi" value="<?= $row['provinsi'] ?>" placeholder="Masukan Provinsi">
                        </li>
                        <li>
                            <span class="jenis" for="negara">Negara </span>
                            <input class="harga" type="text" id="negara" name="negara" value="<?= $row['negara'] ?>" placeholder="Masukan Negara">
                        </li>
                        <li>
                            <span class="jenis" for="kd_pos">Kode Pos </span>
                            <input class="harga" type="number" id="kd_pos" name="kd_pos" value="<?= $row['kd_pos'] ?>" placeholder="Masukan Kode Pos">
                        </li>
                        <li>
                            <span class="jenis" for="norek">Nomor Rekening </span>
                            <input class="harga" id="norek" name="norek" value="<?= $row['nomor_rekening'] ?>" placeholder="Masukan Nomor Rekening">
                        </li>
                    <?php
                    }

                    ?>
                </ul>

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