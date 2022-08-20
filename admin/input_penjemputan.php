<?php
require '../connect_db.php';
require '../session_data.php';

$no_invoice = @$_POST['transaksi_pembelian'];

// Query transaksi pembelian berdasarkan no_invoice yang dipilih
$query_TrxPembelian = mysqli_query($conn, "SELECT * FROM transaksi_pembelian WHERE no_invoice = '$no_invoice'");
$data_TrxPembelian = mysqli_fetch_array($query_TrxPembelian);
// Quert users berdasarkan data pada transaksi pembelian
$query_Users = mysqli_query($conn, "SELECT users.nama_lengkap, transaksi_pembelian.no_invoice, transaksi_pembelian.pemasok_id FROM users INNER JOIN transaksi_pembelian ON users.id_user = transaksi_pembelian.pemasok_id WHERE status_transaksi = 0");

/* EKSEKUSI PENYIMPANAN DATA JADWAL PENJEMPUTAN KURIR*/
if (isset($_POST['simpan'])) {
    $no_invoice = $_POST['no_invoice'];
    $nama_kurir = $_POST['nama_kurir'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $tgl_penjemputan = $_POST['tgl_penjemputan'];

    // Proses simpan 
    $query = mysqli_query($conn, "INSERT INTO jadwal_kurir VALUES ('','$no_invoice', '$nama_kurir', '$no_telp', '$alamat', '$tgl_penjemputan', 'belum')");
    if ($query) {
        mysqli_query($conn, "UPDATE transaksi_pembelian SET status_transaksi = 1 WHERE no_invoice = '$no_invoice'");
        header("Location:jadwal_kurir.php");
    } else {
        echo mysqli_error($conn);
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

    <title>Input Jadwal Penjemputan | Admin Kamibox</title>

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Select2 (Untuk inputan dalam select) -->
    <link rel="stylesheet" href="css/select2.min.css">

    <!-- JS Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
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
            <h2>Input Jadwal Penjemputan</h2>
            <h5>
                <a href="">Beranda</a>
                <span class="panah">></span>
                <a href="">Jadwal Kurir</a>
                <span class="panah">></span>
                <a href="">Input Jadwal Penjemputan</a>
            </h5>
        </div>
        <div id="phase-1">
            <div class="row">
                <div class="btn kembali"><a href="jadwal_kurir.php"><img src="../assets/Icon/arrow-point-to-right.png">Back</a></div>
                <form action="" method="POST" class="input_jadwal">
                    <select onchange="this.form.submit()" name="transaksi_pembelian" id="transaksi_pembelian" style="width: 30%;">
                        <option value="">-- PILIH TRANSAKSI --</option>
                        <?php
                        while ($data = mysqli_fetch_array($query_Users)) {
                        ?>
                            <option <?php if (!empty($data['no_invoice'])) {
                                        echo $data['no_invoice'] == $no_invoice ? 'selected' : '';
                                    } ?> value="<?= $data['no_invoice'] ?>"><?= "[" . $data['pemasok_id'] . "] " . $data['nama_lengkap'] . " (" . $data['no_invoice'] . ")" ?></option>
                        <?php
                            $no++;
                        }
                        ?>
                    </select>
                    <input type="text" name="no_invoice" placeholder="No Invoice" value="<?php if ($no_invoice != "") {
                                                                                                echo $data_TrxPembelian['no_invoice'];
                                                                                            } else {
                                                                                                echo '';
                                                                                            } ?>" readonly>
                    <input type="text" name="alamat" placeholder="Alamat" value="<?php if ($no_invoice != "") {
                                                                                        echo $data_TrxPembelian['alamat'];
                                                                                    } else {
                                                                                        echo '';
                                                                                    } ?>" readonly>
                    <input type="text" name="nama_kurir" placeholder="Nama Lengkap Kurir">
                    <input type="date" name="tgl_penjemputan" placeholder="Masukan tanggal penjemputan">
                    <input type="number" name="no_telp" placeholder="Masukan No Telepon Kurir">

                    <!-- Button -->
                    <button type="submit" class="btn" name="simpan" value="simpan">Input Jadwal</button>
                </form>
            </div>
        </div>
    </div>

    <!-- ====================================== -->
    <!-- JAVA SCRIPT -->
    <!-- ====================================== -->
    <!-- Navigation Interactive -->
    <script>
        /* Select2 Jquery */
        $("#transaksi_pembelian").select2();

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