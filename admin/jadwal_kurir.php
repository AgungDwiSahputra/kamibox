<?php
require '../connect_db.php';
require '../session_data.php';
require 'hari_indo.php';

// Query jadwal_kurir
$query_JadwalKurir = mysqli_query($conn, "SELECT * FROM jadwal_kurir");
$Jml_JadwalKurir = mysqli_num_rows($query_JadwalKurir);

// var_dump(mysqli_error($conn));

/* KONFIRMASI PENJEMPUTAN 
-- Untuk merubah status transaksi ke berhasil
*/
if (isset($_GET['no_invoice']) && $_GET['action'] == 'konfirmasi') {
    $no_invoice = $_GET['no_invoice'];
    $query = mysqli_query($conn, "UPDATE transaksi_pembelian SET status_transaksi = 2 WHERE no_invoice = '$no_invoice'");
    if ($query) {
        mysqli_query($conn, "UPDATE jadwal_kurir SET status = 'selesai' WHERE no_invoice = '$no_invoice'");
        header("Location:riwayat_transaksi.php");
    }
}

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

    <title>Jadwal Kurir | Admin Kamibox</title>

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- NAVIGATION TOP -->
    <?php
    require '../nav-top.php'; ?>
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
                <a href="update_harga.php">
                    <span class="icon">
                        <img src="../assets/Icon/transaction_p.png" alt="Update Harga" class="putih">
                        <img src="../assets/Icon/transaction_h.png" alt="Update Harga" class="hijau">
                    </span>
                    <span class="title">Update Harga</span>
                </a>
            </li>
            <li class="list">
                <b></b>
                <b></b>
                <a href="riwayat_transaksi.php">
                    <span class="icon">
                        <img src="../assets/Icon/input_p.png" alt="Riwayat Transaksi" class="putih">
                        <img src="../assets/Icon/input_h.png" alt="Riwayat Transaksi" class="hijau">
                    </span>
                    <span class="title">Riwayat Transaksi</span>
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
                    <span class="title">Jadwal Kurir</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- ====================================== -->
    <!-- ISI CONTENT -->
    <!-- ====================================== -->
    <div class="container">
        <div class="row header">
            <h2>Jadwal Penjemputan Kurir</h2>
            <h5>
                <a href="">Beranda</a>
                <span class="panah">></span>
                <a href="">Jadwal Kurir</a>
            </h5>
        </div>
        <div class="row content mb-1">
            <a href="input_penjemputan.php" class="link-btn"><button type="button" class="btn">Input Jadwal</button></a>
        </div>
        <div class="row">
            <div class="kotak">
                <?php
                if ($Jml_JadwalKurir != 0) {
                    while ($data = mysqli_fetch_array($query_JadwalKurir)) {
                        $id_mitra = $data['id_mitra']; // Untuk Data Jadwal kurir Mitra
                        $id_pemasok = $data['id_pemasok']; // Untuk Data Jadwal kurir Pemasok
                        $no_invoice = $data['no_invoice'];

                        // Query Data Jadwal kurir Mitra
                        $JadwalKurir_Mitra = mysqli_query($conn, "SELECT * FROM jadwal_kurir INNER JOIN users ON jadwal_kurir.id_mitra = users.id_user WHERE jadwal_kurir.id_mitra = $id_mitra");
                        $Data_JadwalKurir_Mitra = mysqli_fetch_array($JadwalKurir_Mitra);
                        // Query Data Jadwal kurir Pemasok
                        $JadwalKurir_Pemasok = mysqli_query($conn, "SELECT * FROM jadwal_kurir INNER JOIN users ON jadwal_kurir.id_pemasok = users.id_user WHERE jadwal_kurir.id_pemasok = $id_pemasok");
                        $Data_JadwalKurir_Pemasok = mysqli_fetch_array($JadwalKurir_Pemasok);

                        // MANIPULASI NO HP jadi +62
                        // cek apakah no hp mengandung karakter + dan 0-9
                        if (!preg_match('/[^+0-9]/', trim($Data_JadwalKurir_Mitra['notelp'])) || !preg_match('/[^+0-9]/', trim($JadwalKurir_Pemasok['notelp']))) {
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
                        // var_dump($Data_Data$Data_JadwalKurir_Pemasok);
                ?>
                        <div class="row2">
                            <div class="row3">
                                <div class="col">
                                    <img src="../assets/Icon/trash.png" alt="Trash">
                                </div>
                                <div class="col pt-1 pb-4 pr-3">
                                    <span class="tanggal"><?= $datetime ?></span>
                                    <span class="keterangan"><b>
                                            <?php
                                            echo 'No. Invoice : ' . ($no_invoice != null ? $no_invoice : '<span style="font-size:small;color:red;">Belum melakukan Penjemputan</span>');
                                            ?></b>
                                    </span>
                                    <span class="keterangan"><b>Mitra : </b><?= $Data_JadwalKurir_Mitra['nama_lengkap'] ?> | (<?= $Data_JadwalKurir_Mitra['notelp'] ?>)</span>
                                    <span class="alamat"><b>Tujuan : </b><br>
                                        <?= "Nama : " . $Data_JadwalKurir_Pemasok['nama_lengkap'] . "<br>No.Telepon : " . $Data_JadwalKurir_Pemasok['notelp'] . "<br>Alamat : " . $Data_JadwalKurir_Pemasok['alamat'] ?>
                                    </span>
                                </div>
                            </div>
                            <div class="row3 tombol pb-1">
                                <div class="col">
                                    <a href="<?= $Data_JadwalKurir_Pemasok['link_maps'] ?>" target="_BLANK"><button class="btn default">Lokasi</button></a>
                                </div>
                                <div class="col">
                                    <a href="https://api.whatsapp.com/send?phone=<?= $no_telp_kurir ?>&text=Jadwal%20Penjemputan%20:%20<?= $datetime ?>%0ANama%20Kurir%20:%20<?= $Data_JadwalKurir_Mitra['nama_lengkap'] ?>%20|%20(<?= $Data_JadwalKurir_Mitra['notelp'] ?>)%0A*Tujuan%20:*%0ANama:%20<?= $Data_JadwalKurir_Pemasok['nama_lengkap'] ?>%0ANo.Telepon%20:%20<?= $Data_JadwalKurir_Pemasok['notelp'] ?>%0AAlamat%20:%20<?= $Data_JadwalKurir_Pemasok['alamat'] ?>%0ALink Gmaps%20:%20<?= $Data_JadwalKurir_Pemasok['link_maps'] ?>" target="_BLANK"><button class="btn default">Kontak Mitra</button></a>
                                </div>
                                <div class="col">
                                    <?php
                                    if ($data['status'] != 'Selesai') {
                                    ?>
                                        <a href="#"><button class="btn selesai" disabled><?= $data['status'] ?></button></a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="#"><button class="btn default" disabled><?= $data['status'] ?></button></a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
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
        let list = document.querySelectorAll('.navigation .list');
        let nav_dropdown = document.querySelectorAll('.nav-dropdown #nav-ListDropdown');
        let nav_ListDropdown = document.querySelectorAll('.navigation-top ul li .nav-ListDropdown');
        let dropdown = document.querySelectorAll('.dropdown .list');
        let isi_dropdown = document.querySelectorAll('.content .dropdown .isi-dropdown');

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
                    if (active == 0) {
                        while (j < isi_dropdown.length) {
                            isi_dropdown[j++].className = "isi-dropdown";
                        }
                        isi_dropdown[i].className = "isi-dropdown active";
                        active = 1;
                    } else {
                        while (j < isi_dropdown.length) {
                            isi_dropdown[j++].className = "isi-dropdown";
                        }
                        isi_dropdown[i].className = "isi-dropdown";
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