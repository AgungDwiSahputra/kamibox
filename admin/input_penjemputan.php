<?php
require '../connect_db.php';
require '../session_data.php';

// Query Untuk Select Pemilihan Mitra
$query_Mitra = mysqli_query($conn, "SELECT * FROM users WHERE userlevelid = '2'");
$id_user = @$_POST['mitra'];

// Query Untuk Select Pemilihan Pemasok
$query_Pemasok = mysqli_query($conn, "SELECT * FROM users WHERE userlevelid = '3'");
$id_pemasok = @$_POST['pemasok'];
$query_PemasokHasil = mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$id_pemasok'"); // Kondisi menyesuaikan id user pemasok yang di pilih
$data_user_id = mysqli_fetch_array($query_PemasokHasil);

/* EKSEKUSI PENYIMPANAN DATA JADWAL PENJEMPUTAN KURIR*/
if (isset($_POST['simpan'])) {
    $id_accurate = $_POST['id_accurate'];
    $id_pemasok = $_POST['id_user'];
    $nama = $_POST['nama'];
    $nomor_p = $_POST['nomor_p'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $tgl_penjemputan = $_POST['tgl_penjemputan'];
    // $time_penjemputan = $_POST['time_penjemputan'];
    $id_mitra = $_POST['mitra'];
    $ketemu = 0;


    // var_dump($id_pemasok . "," . $id_mitra . "," . $tgl_penjemputan . " " . $time_penjemputan);

    // Proses simpan 
    $query = mysqli_query($conn, "INSERT INTO jadwal_kurir VALUES ('',null, '$id_mitra', '$id_pemasok', '$tgl_penjemputan', 'Menunggu')");
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
            <div class="col">
                <h2>Input Jadwal Penjemputan</h2>
                <h5>
                    <a href="">Beranda</a>
                    <span class="panah">></span>
                    <a href="">Jadwal Kurir</a>
                    <span class="panah">></span>
                    <a href="">Input Jadwal Penjemputan</a>
                </h5>
            </div>
        </div>
        <div id="phase-1">
            <div class="btn kembali"><a href="jadwal_kurir.php"><img src="../assets/Icon/arrow-point-to-right.png">Back</a></div>
            <form action="" method="POST" class="input_jadwal">
                <div class="row">
                    <div class="col">
                        <span><u><b>Data Pemasok</b></u></span><br>
                        <select onchange="this.form.submit()" name="pemasok" id="pemasok" style="width: 30%;">
                            <option value="">-- PILIH AKUN PEMASOK --</option>
                            <?php
                            while ($data = mysqli_fetch_array($query_Pemasok)) {
                            ?>
                                <option <?php if (!empty($data['id_user'])) {
                                            echo $data['id_user'] == $id_pemasok ? 'selected' : '';
                                        } ?> value="<?= $data['id_user'] ?>"><?= "[" . $data['id_user'] . "] " . $data['nama_lengkap'] . " (" . $data['notelp'] . ")" ?></option>
                            <?php
                                $no++;
                            }
                            ?>
                        </select>
                        <input type="hidden" name="id_accurate" placeholder="ID Accuarte" value="<?php if ($id_pemasok != "") {
                                                                                                        echo $data_user_id['id_accurate'];
                                                                                                    } else {
                                                                                                        echo '';
                                                                                                    } ?>" required>
                        <input type="hidden" name="id_user" placeholder="ID Pemasok" value="<?php if ($id_pemasok != "") {
                                                                                                echo $data_user_id['id_user'];
                                                                                            } else {
                                                                                                echo '';
                                                                                            } ?>" required>
                        <input type="text" name="nama" placeholder="Nama Lengkap" value="<?php if ($id_pemasok != "") {
                                                                                                echo $data_user_id['nama_lengkap'];
                                                                                            } else {
                                                                                                echo '';
                                                                                            } ?>" required readonly>
                        <input type="text" name="nomor_p" placeholder="Nomor Ponsel" value="<?php if ($id_pemasok != "") {
                                                                                                echo $data_user_id['notelp'];
                                                                                            } else {
                                                                                                echo '';
                                                                                            } ?>" required readonly>
                        <input type="email" name="email" placeholder="Email" value="<?php if ($id_pemasok != "") {
                                                                                        echo $data_user_id['email'];
                                                                                    } else {
                                                                                        echo '';
                                                                                    } ?>" required readonly>
                        <input type="text" name="alamat" placeholder="Alamat" value="<?php if ($id_pemasok != "") {
                                                                                            echo $data_user_id['alamat'];
                                                                                        } else {
                                                                                            echo '';
                                                                                        } ?>" required readonly>

                        <br>
                    </div>
                    <div class="col">
                        <span><u><b>Waktu Jemput</b></u></span><br>
                        <input type="date" name="tgl_penjemputan" placeholder="Masukan tanggal penjemputan" required>
                        <!-- <input type="time" name="time_penjemputan" placeholder="Masukan waktu penjemputan" required> -->
                        <br>
                        <span><u><b>Pilih Mitra</b></u></span><br>
                        <select name="mitra" id="mitra" style="width: 30%;" required>
                            <option value="">-- PILIH MITRA --</option>
                            <?php
                            while ($data = mysqli_fetch_array($query_Mitra)) {
                            ?>
                                <option <?php if (!empty($data['id_user'])) {
                                            echo $data['id_user'] == $id_user ? 'selected' : '';
                                        } ?> value="<?= $data['id_user'] ?>"><?= "[" . $data['id_user'] . "] " . $data['nama_lengkap'] . " (" . $data['kota'] . ")" ?></option>
                            <?php
                                $no++;
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Button -->
                </div>
                <button type="submit" class="btn default mt-3" name="simpan" value="simpan">Input Jadwal</button>
        </div>
        </form>
    </div>
    </div>

    <!-- ====================================== -->
    <!-- JAVA SCRIPT -->
    <!-- ====================================== -->
    <!-- Navigation Interactive -->
    <script>
        /* Select2 Jquery */
        $("#mitra").select2();
        /* Select2 Jquery */
        $("#pemasok").select2();

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