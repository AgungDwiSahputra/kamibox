<?php error_reporting(0); ?>
<?php
require '../connect_db.php';
require '../session_data.php';
require 'hari_indo.php';
/* =========================================================== */
//pastikan hanya pemasok yg boleh akses halaman ini
if ($level !== '2') {
    header("location:../index.php");
}
/* =========================================================== */

// Query jadwal_kurir
$query_JadwalKurir = mysqli_query($conn, "SELECT * FROM jadwal_kurir WHERE id_mitra = '$id_user'");
$Jml_JadwalKurir = mysqli_num_rows($query_JadwalKurir);
// var_dump(mysqli_error($conn));

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Description Web -->
    <meta name="keywords" content="kamibox">
    <meta name="description" content="">
    <meta name="author" content="Agung Dwi Sahputra">
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">

    <title>Jadwal Penjemputan Kurir | Mitra Kamibox</title>

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
            <li class="list active">
                <b></b>
                <b></b>
                <a href="">
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
            <div class="col">
                <h2>Jadwal Penjemputan Kurir</h2>
                <h5>
                    <a href="">Beranda</a>
                    <span class="panah">></span>
                    <a href="">Jadwal Penjemputan</a>
                </h5>
            </div>
        </div>
        <div class="row">
            <div class="kotak box-shadow p-3 m-2">
                <?php
                if ($Jml_JadwalKurir != 0) {
                    while ($data = mysqli_fetch_array($query_JadwalKurir)) {
                        $id_mitra = $data['id_mitra']; // Untuk Data Jadwal kurir Mitra
                        $id_pemasok = $data['id_pemasok']; // Untuk Data Jadwal kurir Pemasok
                        $no_invoice = $data['no_invoice'];
                        $no_penjemputan = $data['no_penjemputan'];

                        // Query Data Jadwal kurir Mitra
                        $JadwalKurir_Mitra = mysqli_query($conn, "SELECT * FROM jadwal_kurir INNER JOIN users ON jadwal_kurir.id_mitra = users.id_user WHERE jadwal_kurir.id_mitra = $id_mitra");
                        $Data_JadwalKurir_Mitra = mysqli_fetch_array($JadwalKurir_Mitra);
                        // Query Data Jadwal kurir Pemasok
                        $JadwalKurir_Pemasok = mysqli_query($conn, "SELECT * FROM jadwal_kurir INNER JOIN users ON jadwal_kurir.id_pemasok = users.id_user WHERE jadwal_kurir.id_pemasok = $id_pemasok");
                        $Data_JadwalKurir_Pemasok = mysqli_fetch_array($JadwalKurir_Pemasok);

                        // MANIPULASI NO HP jadi +62
                        // cek apakah no hp mengandung karakter + dan 0-9
                        if (!preg_match('/[^+0-9]/', trim($Data_JadwalKurir_Mitra['notelp'])) || !preg_match('/[^+0-9]/', trim($Data_JadwalKurir_Pemasok['notelp']))) {
                            // cek apakah no hp karakter 1-3 adalah +62
                            if (substr(trim($Data_JadwalKurir_Mitra['notelp']), 0, 3) == '+62' || substr(trim($Data_JadwalKurir_Pemasok['notelp']), 0, 3) == '+62') {
                                $no_telp_kurir = trim($Data_JadwalKurir_Mitra['notelp']);
                                $no_telp_pemasok = trim($Data_JadwalKurir_Pemasok['notelp']);
                            }
                            // cek apakah no hp karakter 1 adalah 0
                            elseif (substr(trim($Data_JadwalKurir_Mitra['notelp']), 0, 1) == '0') {
                                $no_telp_kurir = '62' . substr(trim($Data_JadwalKurir_Mitra['notelp']), 1);
                                $no_telp_pemasok = '62' . substr(trim($Data_JadwalKurir_Pemasok['notelp']), 1);
                            }
                        }

                        // Konversi Tanggal menjadi format Indonesia
                        $date = $data['tgl_penjemputan'];
                        $date1 = date_create($date);
                        $date2 = date_format($date1, 'l');
                        $tgl   = date_format($date1, 'd');
                        $year  = date_format($date1, 'Y');
                        $date3 = hariIndo($date2);
                        $month = date_format($date1, 'm');
                        $month2 = bulanIndo($month);
                        $datetime = $date3 . ", " . $tgl . " " . $month2 . " " . $year;
                ?>
                        <div class="row">
                            <img src="../assets/Icon/trash.png" alt="Trash">
                            <div class="col py-2">
                                <span class="tanggal"><?= $datetime ?></span><br>
                                <span class="keterangan"><b>
                                        <?php
                                        echo 'No. Invoice : ' . ($no_invoice != null ? $no_invoice : '-');
                                        ?></b>
                                </span><br>
                                <span class="keterangan"><b>Mitra : </b><?= $Data_JadwalKurir_Mitra['nama_lengkap'] ?> | (<?= $Data_JadwalKurir_Mitra['notelp'] ?>)</span><br>
                                <span class="alamat"><b>Tujuan : </b><br>
                                    <?= "Nama : " . $Data_JadwalKurir_Pemasok['nama_lengkap'] . "<br>No.Telepon : " . $Data_JadwalKurir_Pemasok['notelp'] . "<br>Alamat : " . $Data_JadwalKurir_Pemasok['alamat'] ?>
                                </span>
                            </div>
                            <div class="row tombol pb-1">
                                <div class="col">
                                    <a href="<?= $Data_JadwalKurir_Pemasok['link_maps'] ?>" target="_BLANK"><button class="btn default">Lokasi</button></a>
                                </div>
                                <div class="col">
                                    <a href="https://api.whatsapp.com/send?phone=<?= $no_telp_pemasok ?>&text=Kami%20akan%20melakukan%20penjemputan%20pada%20tanggal%20*<?= $datatime ?>*%0ANama%20Kurir%20:%20<?= $Data_JadwalKurir_Mitra['nama_lengkap'] ?>%20|%20(<?= $Data_JadwalKurir_Mitra['notelp'] ?>)%0A*Tujuan%20:*%0ANama:%20<?= $Data_JadwalKurir_Pemasok['nama_lengkap'] ?>%0ANo.Telepon%20:%20<?= $Data_JadwalKurir_Pemasok['notelp'] ?>%0AAlamat%20:%20<?= $Data_JadwalKurir_Pemasok['alamat'] ?>%0ALink Gmaps%20:%20<?= $Data_JadwalKurir_Pemasok['link_maps'] ?>" target="_BLANK"><button class="btn default">Kontak Pemasok</button></a>
                                </div>
                                <div class="col">
                                    <!-- id = id pemasok || no = no penjemputan -->
                                    <?php
                                    if ($data['status'] != 'Selesai') {
                                    ?>
                                        <a href="input_data.php?action=Penjemputan&id=<?= $id_pemasok ?>&no=<?= $no_penjemputan ?>&key=<?= password_hash($id_user, PASSWORD_DEFAULT) ?>"><button class="btn default">Input Data</button></a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="#"><button class="btn selesai" disabled>Selesai</button></a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- <div class="isi-dropdown" id="isi-dropdown">
                                <input type="text" name="keterangan" placeholder="Masukan Keterangan Tambahan...">
                                <button type="submit" class="btn">Input</button>
                            </div>
                            <img src="../assets/Icon/arrow-point-to-right.png" alt="Panah" class="dropdown" id="dropdown"> -->
                            <hr width="100%" style="border:1px dashed black;">
                        </div>
                <?php
                    }
                } else {
                    echo '<tr><td><center style="color:red;font-size:14px;">Jadwal Penjemputan Kurir masih kosong</center></td></tr>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- ====================================== -->
    <!-- JAVA SCRIPT -->
    <!-- ====================================== -->
    <!-- Navigation Interactive -->
    <script>
        let list = document.querySelectorAll('.navigation .list'); //NAVIGATION
        let nav_dropdown = document.querySelectorAll('.nav-dropdown #nav-ListDropdown');
        let nav_ListDropdown = document.querySelectorAll('.navigation-top ul li .nav-ListDropdown');
        let dropdown = document.querySelectorAll('.row .kotak .row2 img.dropdown');
        let isi_dropdown = document.querySelectorAll('.row .kotak .row2 #isi-dropdown');

        //Navbar Sebelah Kiri
        // for (let i = 0; i < list.length; i++) {
        //     list[i].onclick = function() {
        //         let j = 0;
        //         while (j < list.length) {
        //             list[j++].className = "list";
        //         }
        //         list[i].className = "list active";
        //     }
        // }

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

        //Dropdown list menu harga
        {
            let active = 0;
            for (let i = 0; i < dropdown.length; i++) {
                dropdown[i].onclick = function() {
                    let j = 0;
                    while (j < isi_dropdown.length) {
                        isi_dropdown[j++].className = "isi-dropdown";
                        dropdown[j++].className = "dropdown";
                    }
                    if (active == 0) {
                        isi_dropdown[i].className = "isi-dropdown active";
                        dropdown[i].className = "dropdown active";
                        active = 1;
                    } else {
                        isi_dropdown[i].className = "isi-dropdown";
                        dropdown[i].className = "dropdown";
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