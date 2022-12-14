<?php
require '../connect_db.php';
require '../session_data.php';
/* =========================================================== */
//pastikan hanya pemasok yg boleh akses halaman ini
if ($level !== '2') {
    header("location:../index.php");
}
/* =========================================================== */
/* DATA YANG DI BAWA DARI PROSES SEBELUMNYA */
$invoice_session = $_SESSION['no_invoice'];
/* =========================================================== */

/* Jika Belum Menyelesaikan step awal */
// Kondisi jika setelah memilih barang daur ulang tidak bisa kembali ketampilan ini dari URL kecuali dari button tambah pada tampilan menambahkan berat
if (!isset($_SESSION['input_barang'])) {
    header("Location: input_data_1.php");
}

/* Mengambil TRX BARANG untuk mengambil id barang yang sedang di input */
$query_TrxBarang = mysqli_query($conn, "SELECT * FROM transaksi_barang INNER JOIN barang ON barang.id_barang = transaksi_barang.id_barang WHERE no_invoice = '$invoice_session'");
$query_TrxPembelian = mysqli_query($conn, "SELECT * FROM transaksi_pembelian WHERE no_invoice = '$invoice_session'");
$Data_TrxPembelian = mysqli_fetch_object($query_TrxPembelian);
// var_dump(mysqli_fetch_object($query_TrxPembelian));
// $Data_TrxBarang = mysqli_fetch_object($query_TrxBarang);
// var_dump($Data_TrxBarang);

/* Proses Input Berat */
if (isset($_POST['berat_barang'])) {
    $id_TrxBarang = $_POST['id_TrxBarang'];
    $berat_TrxBarang = $_POST['berat_TrxBarang']; //Berat barang semula
    $berat_barang = $_POST['berat_barang']; //Berat Barang Inputan

    // var_dump($berat_TrxBarang);
    if ($berat_TrxBarang == null) {
        $Update_BBarang = mysqli_query($conn, "UPDATE transaksi_barang SET berat = '$berat_barang' WHERE id = '$id_TrxBarang'");
    } else {
        $berat_TrxBarang .= ", " . $berat_barang;
        $Update_BBarang = mysqli_query($conn, "UPDATE transaksi_barang SET berat = '$berat_TrxBarang' WHERE id = '$id_TrxBarang'");
    }

    header("Location: input_data_2.php");
}

if (isset($_POST['tambah_item'])) {
    unset($_SESSION['input_barang']);
    header("Location: input_data_1.php");
}

/* INPUT DATA */
// Di Proses setelah user megklik tombol input data
if (isset($_POST['input_data'])) {
    // ========================== api acurate ==========================
    require '../auto_refresh.php'; // Auto Refresh token 5 hari sekali dari awal pembuatan token 

    // mengambil data user
    $get_data_user = mysqli_query($conn, "SELECT * FROM users WHERE id_user='$id_user'");

    $nama_lengkap = "";
    $tanggal = date("d/m/Y");
    $email = "";
    $alamat = "";
    $no_hp = "";
    while ($row = mysqli_fetch_object($get_data_user)) {
        $nama_lengkap .= $row->nama_lengkap;
        $email .= $row->email;
        $alamat .= $row->alamat;
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

    // Variabel Array untuk curl 
    $datano[] = array();
    $dataprice[] = array();

    $fields_string = "";
    $no = 0;
    while ($Data_TrxBarang = mysqli_fetch_object($query_TrxBarang)) {
        /* Menghitung total berat per item */
        $total_berat = 0;
        $exp_total_berat = explode(",", $Data_TrxBarang->berat);
        for ($i = 0; $i < count($exp_total_berat); $i++) {
            $total_berat += $exp_total_berat[$i];
        }
        // var_dump($total_berat);
        /* =============================== */

        $datano[$no] = $Data_TrxBarang->kd_barang;
        $dataprice[$no] = $Data_TrxBarang->harga_barang;

        $fields_string .=   "detailItem[" . $no . "].itemNo" . '=' . $datano[$no] . '&' .
            "detailItem[" . $no . "].quantity" . '=' . $total_berat . '&' .
            "detailItem[" . $no . "].unitPrice" . '=' . $dataprice[$no] . '&';
        $no++;
    }

    $fieldsApi = rtrim($fields_string, '&');
    // var_dump("transDate=$datetime_accurate&vendorNo=$id_user&number=$invoice_session&currencyCode=IDR&$fieldsApi");
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "$host/accurate/api/purchase-invoice/save.do",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "transDate=$datetime_accurate&vendorNo=$Data_TrxPembelian->pemasok_id&number=$invoice_session&currencyCode=IDR&$fieldsApi",
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

    /* END API */
    $harga_item = $_POST['harga_item'];
    $biaya_penjemputan = $_POST['biaya_penjemputan'];
    $total_harga = $_POST['total_harga'];
    $total_berat = $_POST['total_berat'];
    $Update_TrxPembelian = mysqli_query($conn, "UPDATE transaksi_pembelian SET harga_item = '$harga_item', total_berat = '$total_berat', biaya_jemput = '$biaya_penjemputan', total_harga = '$total_harga' WHERE no_invoice = '$invoice_session'");

    if ($Update_TrxPembelian) {
        if (isset($_SESSION['no_penjemputan'])) {
            /* RUBAH STATUS PENJEMPUTAN */
            $no_penjemputan = $_SESSION['no_penjemputan'];
            $Update_Penjemputan = mysqli_query($conn, "UPDATE jadwal_kurir SET status = 'Selesai' WHERE no_penjemputan = '$no_penjemputan'");

            /* ===================== */
        }

        unset($_SESSION['no_invoice']);
        unset($_SESSION['input_barang']);
        unset($_SESSION['id_pemasok']);
        header("Location: invoice.php?no_invoice=$invoice_session");
    } else {
        header("Location: input_data_2.php");
    }
}

/* HAPUS LIST BARANG YANG DIPILIH */
// $key = md5(rand(1, 999999999));
// setcookie('key', $key, time() + (10 * 1), "/");
if (isset($_GET['hapus'])) {
    $id_barang = $_GET['hapus'];
    $Delete_TrxBarang = mysqli_query($conn, "DELETE FROM transaksi_barang WHERE id = '$id_barang'");
    if ($Delete_TrxBarang) {
        header("Location: input_data_2.php");
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
            <div class="col">
                <h2>Input Data</h2>
                <h5>
                    <a href="">Beranda</a>
                    <span class="panah">></span>
                    <a href="">Input Data</a>
                </h5>
            </div>
        </div>

        <!-- PHASE 3 -->
        <div id="phase-3">
            <div class="row">
                <div class="col">
                    <h5>Jenis Daur Ulang</h5>
                    <ul>
                        <?php
                        // ---------------------------------------------------------------------------------
                        $total_beratAll = 0; //Total Berat untuk di hitung total semua item daur ulang
                        $total_harga = 0; //Total Harga semua Item Daur Ulang
                        $biaya_penjemputan = 10000; //Harga per 1kg
                        $total_penjemputan = 0; //Total Penjemputan untuk total smua berat item daur ulang
                        $total_keseluruhan = 0;
                        while ($TrxBarang = mysqli_fetch_array($query_TrxBarang)) {
                            $id_barang = $TrxBarang['id_barang'];
                            $query_BarangID = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang = '$id_barang'");
                            $BarangId = mysqli_fetch_array($query_BarangID); //Data Barang yang sesuai dengan ID arang pada TRX Barang
                        ?>
                            <li class="dropdown">
                                <a href="?hapus=<?= $TrxBarang['id'] ?>">
                                    <img src="../assets/Icon/delete-button.png" alt="Hapus" id="hapus">
                                </a>
                                <div class="list">
                                    <span class="jenis"><?= $BarangId['nama_barang'] ?></span>
                                    <img src="../assets/Icon/arrow-point-to-right.png" alt="panah" id="panah">
                                    <form action="" method="POST" style="display: inline;" id="input_berat_item">
                                        <input id="id_TrxBarang" type="text" name="id_TrxBarang" value="<?= $TrxBarang['id'] ?>" hidden>
                                        <input id="berat_TrxBarang" type="text" name="berat_TrxBarang" value="<?= $TrxBarang['berat'] ?>" hidden>
                                        <input id="berat_barang" name="berat_barang" type="number" class="total" placeholder="100" min="0">kg
                                        <button type="submit" class="btn_add"><img src="../assets/Icon/add-button.png" alt="Add" id="add"></button>
                                    </form>
                                </div>
                                <ul class="isi-dropdown">
                                    <div class="berat_list">
                                        <?php
                                        $List_TrxBerat = explode(',', $TrxBarang['berat']);
                                        $total_berat = 0; // Total Berat per Item Daur Ulang
                                        // var_dump($List_TrxBerat[0]);
                                        for ($i = 0; $i < count($List_TrxBerat); $i++) {
                                            if ($List_TrxBerat[$i] != null) {
                                        ?>
                                                <li>
                                                    <span class="daur_ulang">Penimbangan <?= $i + 1 ?>&emsp;: <?= $List_TrxBerat[$i] ?>kg</span>
                                                </li>
                                        <?php
                                                $total_berat += $List_TrxBerat[$i]; //Proses Perhitungan total berat per item
                                                $total_beratAll += $List_TrxBerat[$i]; //Proses Perhitungan total berat semua item
                                                $total_harga += $BarangId['harga_barang'] * $List_TrxBerat[$i];
                                            } else {
                                                echo '<li><span class="daur_ulang">Belum ada hasil penimbangan</span></li>';
                                            }
                                        }
                                        $total_penjemputan = $biaya_penjemputan * $total_beratAll;
                                        $total_keseluruhan = $total_harga + $total_penjemputan;
                                        ?>
                                    </div>
                                    <div class="berat_total">
                                        <li class="daur_ulang_total">
                                            <span>Total Berat&emsp;: <?= $total_berat ?>kg</span>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                    <!-- Button -->
                    <form action="" method="POST">
                        <button type="submit" class="btn default float-left" name="tambah_item" value="tambah_item">
                            Tambah
                        </button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5>Perkiraan Pendapatan</h5>
                    <div class="row">
                        <div class="col box-shadow p-3 mr-2">
                            <ul class="atas">
                                <li>
                                    <span class="title">Total Harga</span>
                                    <span class="keterangan"><?= number_format($total_harga, 0, ',', '.') ?></span>
                                </li>
                                <li>
                                    <span class="title">Total Berat</span>
                                    <span class="keterangan"><?= $total_beratAll ?>kg</span>
                                </li>
                                <li>
                                    <span class="title">Biaya Penjemputan</span>
                                    <span class="keterangan"><?= number_format($total_penjemputan, 0, ',', '.') ?></span>
                                </li>
                            </ul>
                            <h4 class="bawah">
                                <span class="title">Estimasi Pendapatan</span>
                                <span class="keterangan"><?= number_format($total_keseluruhan, 0, ',', '.') ?></span>
                            </h4>
                        </div>
                    </div>
                    <!-- Button -->
                    <form action="" method="POST">
                        <input type="text" name="harga_item" value="<?= $total_harga ?>" hidden>
                        <input type="text" name="biaya_penjemputan" value="<?= $total_penjemputan ?>" hidden>
                        <input type="text" name="total_harga" value="<?= $total_keseluruhan ?>" hidden>
                        <input type="text" name="total_berat" value="<?= $total_beratAll ?>" hidden>
                        <button type="submit" class="btn default mt-4 float-left" name="input_data">Input Data</button>
                    </form>
                </div>
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
        let dropdown2 = document.querySelectorAll('#phase-2 ul li.dropdown .list');
        let isi_dropdown2 = document.querySelectorAll('#phase-2 ul li.dropdown ul.isi-dropdown');
        let dropdown3 = document.querySelectorAll('#phase-3 ul li.dropdown #panah');
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

        //Dropdown Jenis Daur Ulangmu(Phase 3)
        {
            let active = 0;
            for (let i = 0; i < dropdown3.length; i++) {
                dropdown3[i].onclick = function() {
                    let j = 0;
                    if (active == 0) {
                        while (j < isi_dropdown3.length) {
                            isi_dropdown3[j++].className = "isi-dropdown";
                        }
                        isi_dropdown3[i].className = "isi-dropdown active";
                        active = 1;
                    } else {
                        while (j < isi_dropdown3.length) {
                            isi_dropdown3[j++].className = "isi-dropdown";
                        }
                        isi_dropdown3[i].className = "isi-dropdown";
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