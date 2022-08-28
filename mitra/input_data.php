<?php
require '../connect_db.php';
require '../session_data.php';
include 'hari_indo.php';

/* =========================================================== */
//pastikan hanya pemasok yg boleh akses halaman ini
if ($level !== '2') {
    header("location:../index.php");
}

// Memastikan jika mitra sudah mengisi data pemasok tidak akan bisa masuk kembali ke tampilan ini
if (isset($_SESSION['no_invoice'])) {
    header("Location: input_data_1.php");
}
/* =========================================================== */

$query = mysqli_query($conn, "SELECT * FROM users WHERE userlevelid = '3'");
$id = @$_POST['akun_customer'];
$query_user = mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$id'");
$data_user_id = mysqli_fetch_array($query_user);

/* Setelah klik button next */
if (isset($_POST['next'])) {
    $id_accuratePemasok = $_POST['id_accurate'];
    $id_userPemasok = $_POST['id_user'];
    $nama_jalan =  $_POST['nama_jalan'];
    $kota =  $_POST['kota'];
    $provinsi =  $_POST['provinsi'];
    $negara =  $_POST['negara'];
    $kd_pos =  $_POST['kd_pos'];
    $nomor_rekening = $_POST['nomor_rekening'];
    $catatan =  "Nomor Rekening :" . $_POST['nomor_rekening'];
    $alamat = $nama_jalan . ", " . $kota . ", " . $provinsi . ", " . $negara . ", " . $kd_pos; //Mengambil dari pecahan inputan alamat di jadikan 1 ke variabel alamat
    $link_maps = $_POST['link_maps'];
    // var_dump("alamat = '$alamat',nama_jalan = '$nama_jalan',kota = '$kota',provinsi = '$provinsi',negara = '$negara',kd_pos = '$kd_pos', nomor_rekening = '$nomor_rekening', link_maps = '$link_maps'");

    /* INVOICE */
    /* 
    tahun|bulan|tanggal|Jam|menit|detik|4 Angka Random
    22|08|31|23|59|59|9999
    */
    $invoice = date('ymdHis') . rand(1000, 9999);

    $dateprd = date('Y-m-d');
    $date = $dateprd;
    $date1 = date_create($date);
    $date2 = date_format($date1, 'l');
    $tgl   = date_format($date1, 'd');
    $year  = date_format($date1, 'Y');
    $date3 = hariIndo($date2);
    $month = date_format($date1, 'm');
    $month2 = bulanIndo($month);
    $datetime = $date3 . ", " . $tgl . " " . $month2 . " " . $year;

    // ========================== api acurate ==========================
    $get_data_user = mysqli_query($conn, "SELECT * FROM users WHERE id_user='$id_user'");
    $nama_lengkap = "";
    $tanggal = date("d/m/Y");
    $email = "";
    $no_hp = "";
    while ($row = mysqli_fetch_object($get_data_user)) {
        $nama_lengkap .= $row->nama_lengkap;
        $email .= $row->email;
        $no_hp .= $row->notelp;
    }

    // mengambil sesion db accurate
    $get_sesi_db_accuate = mysqli_query($conn, "SELECT * FROM tb_database_response_api");
    $access_token = "";
    $session_db = "";
    $host = "";
    while ($row = mysqli_fetch_object($get_sesi_db_accuate)) {
        $access_token .= $row->access_token;
        $session_db .= $row->session_db;
        $host .= $row->host;
    }

    $curl = curl_init();
    // var_dump($id_userPemasok . "<br>");

    curl_setopt_array($curl, array(
        CURLOPT_URL => "$host/accurate/api/vendor/save.do",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "id=$id_accuratePemasok&name=$nama_lengkap&transDate=$tanggal&email=$email&shipStreet=$alamat&billStreet=$nama_jalan&billCity=$kota&billProvince=$provinsi&billCountry=$negara&billZipCode=$kd_pos&notes=$catatan&mobilePhone=$no_hp&vendorNo=$id_userPemasok",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "Authorization: Bearer $access_token",
            "X-Session-ID: $session_db"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    // var_dump($response);
    // ==================================================================

    $queryTransaksi = mysqli_query($conn, "INSERT INTO transaksi_pembelian VALUES ('$invoice','$id_user','$id_userPemasok',null,null,null,null, '$alamat','$link_maps','$datetime',null,'2')");

    $queryUsers = mysqli_query($conn, "UPDATE users SET alamat = '$alamat',nama_jalan = '$nama_jalan',kota = '$kota',provinsi = '$provinsi',negara = '$negara',kd_pos = '$kd_pos', nomor_rekening = '$nomor_rekening', link_maps = '$link_maps' WHERE id_user = '$id_userPemasok'");
    if ($queryTransaksi == true && $queryUsers == true) {
        $_SESSION['no_invoice'] = $invoice;
        $_SESSION['id_pemasok'] = $id_userPemasok;

        header("Location: input_data_1.php");
    } else {
        header("Location: input_data.php");
    }
}

/* KOndisi ketika input data memiliki get action */
if (isset($_GET['action'])) {
    var_dump(password_verify($id_user, $_GET['key']));
    if (password_verify($id_user, $_GET['key'])) {

        $invoice = date('ymdHis') . rand(1000, 9999);
        // $id_user = $id_user;  //SUdah ada pada SESSION
        $id_userPemasok = $_GET['id'];
        $no_penjemputan = $_GET['no'];

        $dateprd = date('Y-m-d');
        $date = $dateprd;
        $date1 = date_create($date);
        $date2 = date_format($date1, 'l');
        $tgl   = date_format($date1, 'd');
        $year  = date_format($date1, 'Y');
        $date3 = hariIndo($date2);
        $month = date_format($date1, 'm');
        $month2 = bulanIndo($month);
        $datetime = $date3 . ", " . $tgl . " " . $month2 . " " . $year;
        // Mengambil Data users berdasarkan id_user pemasok yang di ambil dari get jadwal penjemputan
        $queryUsers = mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$id_userPemasok'");
        $data_queryUsers = mysqli_fetch_array($queryUsers);
        $alamat = $data_queryUsers['alamat'];
        $link_maps = $data_queryUsers['link_maps'];

        // var_dump($invoice . ',' . $id_user . ',' . $id_userPemasok . ',null,null,null,null, ' . $alamat . ',' . $link_maps . ',' . $datetime . ',null,' . '2');
        // Proses insert data
        $queryTransaksi = mysqli_query($conn, "INSERT INTO transaksi_pembelian VALUES ('$invoice','$id_user','$id_userPemasok',null,null,null,null, '$alamat','$link_maps','$datetime',null,'2')");
        $queryJadwalKurir = mysqli_query($conn, "UPDATE jadwal_kurir SET no_invoice = '$invoice' WHERE no_penjemputan = '$no_penjemputan'");

        if ($queryTransaksi) {
            $_SESSION['no_invoice'] = $invoice;
            $_SESSION['no_penjemputan'] = $no_penjemputan;
            $_SESSION['id_pemasok'] = $id_userPemasok;

            header("Location: input_data_1.php");
        } else {
            header("Location: jadwal_penjemputan.php");
        }
    } else {
        header("Location:../index.php");
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

    <title>Input Data | Mitra Kamibox</title>

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
            <li class="list active">
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
            <h2>Input Data</h2>
            <h5>
                <a href="">Beranda</a>
                <span class="panah">></span>
                <a href="">Input Data</a>
            </h5>
        </div>
        <div id="phase-1">
            <div class="row">
                <form action="" method="POST" class="input_jadwal">
                    <select onchange="this.form.submit()" name="akun_customer" id="akun_customer">
                        <option value="">-- PILIH AKUN PEMASOK --</option>
                        <?php
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <option <?php if (!empty($data['id_user'])) {
                                        echo $data['id_user'] == $id ? 'selected' : '';
                                    } ?> value="<?= $data['id_user'] ?>"><?= "[" . $data['id_user'] . "] " . $data['nama_lengkap'] . " (" . $data['notelp'] . ")" ?></option>
                        <?php
                            $no++;
                        }
                        ?>
                    </select>
                    <input type="text" name="id_accurate" placeholder="ID Accuarte" value="<?php if ($id != "") {
                                                                                                echo $data_user_id['id_accurate'];
                                                                                            } else {
                                                                                                echo '';
                                                                                            } ?>" readonly>
                    <input type="text" name="id_user" placeholder="ID Pemasok" value="<?php if ($id != "") {
                                                                                            echo $data_user_id['id_user'];
                                                                                        } else {
                                                                                            echo '';
                                                                                        } ?>" readonly>
                    <input type="text" name="nama" placeholder="Nama Lengkap" value="<?php if ($id != "") {
                                                                                            echo $data_user_id['nama_lengkap'];
                                                                                        } else {
                                                                                            echo '';
                                                                                        } ?>" readonly>
                    <input type="text" name="nomor_p" placeholder="Nomor Ponsel" value="<?php if ($id != "") {
                                                                                            echo $data_user_id['notelp'];
                                                                                        } else {
                                                                                            echo '';
                                                                                        } ?>" readonly>
                    <span class="pesan">Note : Nomor telepon harus sesuai dengan nomor yang terdaftar di akun pemasok</span>
                    <input type="email" name="email" placeholder="Email" value="<?php if ($id != "") {
                                                                                    echo $data_user_id['email'];
                                                                                } else {
                                                                                    echo '';
                                                                                } ?>" readonly>
                    <span class="pesan">Note : Email harus sesuai dengan yang terdaftar di akun pemasok</span>
                    <input type="text" name="nomor_rekening" placeholder="Masukan Nomor Rekening" value="<?php if ($id != "") {
                                                                                                                if ($data_user_id['nomor_rekening']) {
                                                                                                                    echo $data_user_id['nomor_rekening'];
                                                                                                                }
                                                                                                            } else {
                                                                                                                echo '';
                                                                                                            } ?>" required>
                    <input type="text" name="nama_jalan" placeholder="Masukan Nama Jalan" value="<?php if ($id != "") {
                                                                                                        if ($data_user_id['nama_jalan']) {
                                                                                                            echo $data_user_id['nama_jalan'];
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo '';
                                                                                                    } ?>" required>
                    <input type="text" name="kota" placeholder="Masukan Kota" value="<?php if ($id != "") {
                                                                                            if ($data_user_id['kota']) {
                                                                                                echo $data_user_id['kota'];
                                                                                            }
                                                                                        } else {
                                                                                            echo '';
                                                                                        } ?>" required>
                    <input type="text" name="provinsi" placeholder="Masukan Provinsi" value="<?php if ($id != "") {
                                                                                                    if ($data_user_id['provinsi']) {
                                                                                                        echo $data_user_id['provinsi'];
                                                                                                    }
                                                                                                } else {
                                                                                                    echo '';
                                                                                                } ?>" required>
                    <input type="text" name="negara" placeholder="Masukan Negara" value="<?php if ($id != "") {
                                                                                                if ($data_user_id['negara']) {
                                                                                                    echo $data_user_id['negara'];
                                                                                                }
                                                                                            } else {
                                                                                                echo '';
                                                                                            } ?>" required>
                    <input type="number" name="kd_pos" placeholder="Masukan Kode Pos" value="<?php if ($id != "") {
                                                                                                    if ($data_user_id['kd_pos']) {
                                                                                                        echo $data_user_id['kd_pos'];
                                                                                                    }
                                                                                                } else {
                                                                                                    echo '';
                                                                                                } ?>" required>
                    <input type="text" name="link_maps" placeholder="Copy Link Google Maps" value="<?php if ($id != "") {
                                                                                                        if ($data_user_id['link_maps']) {
                                                                                                            echo $data_user_id['link_maps'];
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo '';
                                                                                                    } ?>" required>


                    <!-- Button -->
                    <button type="submit" class="btn" name="next" value="next">Next</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        /* Select2 Jquery */
        $("#akun_customer").select2();

        let list = document.querySelectorAll('.navigation .list'); //NAVIGATION
        let nav_dropdown = document.querySelectorAll('.nav-dropdown #nav-ListDropdown');
        let nav_ListDropdown = document.querySelectorAll('.navigation-top ul li .nav-ListDropdown');
        let dropdown2 = document.querySelectorAll('#phase-2 ul li.dropdown .list');
        let isi_dropdown2 = document.querySelectorAll('#phase-2 ul li.dropdown ul.isi-dropdown');
        let dropdown3 = document.querySelectorAll('#phase-3 ul li.dropdown .list');
        let isi_dropdown3 = document.querySelectorAll('#phase-3 ul li.dropdown ul.isi-dropdown');

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