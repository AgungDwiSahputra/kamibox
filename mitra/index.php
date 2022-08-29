<?php error_reporting(0); ?>
<?php
require '../connect_db.php';
require '../session_data.php';
include 'hari_indo.php';
/* =========================================================== */
//pastikan hanya pemasok yg boleh akses halaman ini
if ($level !== '2') {
    header("location:../index.php");
}
/* =========================================================== */

// Query jadwal_kurir
$query_JadwalKurir = mysqli_query($conn, "SELECT * FROM jadwal_kurir WHERE id_mitra = '$id_user' LIMIT 3");
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

    <title>Dashboard | Mitra Kamibox</title>

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
            <li class="list active">
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
    <section id="dashboard">
        <div class="container dashboard">
            <div class="row header">
                <h2>Dashboard</h2>
            </div>

            <div class="row body">
                <div class="col grafik box-shadow p-3 m-2">
                    <div class="table">
                        <span class=" judul">Grafik Terkini</span>
                        <?php
                        $query_PTransaksi = mysqli_query($conn, "SELECT DISTINCT pemasok_id FROM transaksi_pembelian");
                        $Total_PTransaksi = mysqli_num_rows($query_PTransaksi);
                        $query_UserTrx = mysqli_query($conn, "SELECT * FROM users");
                        while ($TotalUserTrx = mysqli_fetch_array($query_UserTrx)) {
                            $id_users = $TotalUserTrx['id_user'];
                        }
                        /* Riwayat Transaksi */
                        // $query_transaksi = mysqli_query($conn, "SELECT * FROM transaksi_pembelian WHERE mitra_id = '$id_user' LIMIT 6");
                        // $total_transaksi = mysqli_num_rows($query_transaksi);

                        //jika date tidak diinputkan
                        if (isset($_GET['ke'])) {
                            $dateprd = $_GET['ke'];
                        } else {
                            $dateprd = date('Y-m-d');
                        }
                        echo "<form action='index.php' method='get'>
          		<label>Pilih Tanggal</label>
				<input type='date' name='ke' value='" . $dateprd . "'>
				<input type='submit' value='cari'>
                </form>
                <a href='index.php?ke=all'><button>Semua</button></a>
                ";

                        $date = $dateprd;
                        $date1 = date_create($date);
                        $date2 = date_format($date1, 'l');
                        $tgl   = date_format($date1, 'd');
                        $year  = date_format($date1, 'Y');
                        $date3 = hariIndo($date2);
                        $month = date_format($date1, 'm');
                        $month2 = bulanIndo($month);
                        if (isset($_GET['ke'])) {
                            if ($_GET['ke'] != 'all') {
                                echo "<div style='margin-top:10px;color:green;font-size:0.9rem;'>" . $date3 . ", " . $tgl . " " . $month2 . " " . $year . "</div>";

                                $query_transaksi = mysqli_query($conn, "SELECT * FROM transaksi_pembelian WHERE mitra_id = '$id_user' AND date_grafik between '$dateprd 00:00' and '$dateprd 23:59'");
                                $total_transaksi = mysqli_num_rows($query_transaksi);
                            } else {
                                echo "<div style='margin-top:10px;color:green;font-size:0.9rem;'>Semua Transaksi</div>";

                                $query_transaksi = mysqli_query($conn, "SELECT * FROM transaksi_pembelian WHERE mitra_id = '$id_user'");
                                $total_transaksi = mysqli_num_rows($query_transaksi);
                            }
                        } else {
                            echo "<div style='margin-top:10px;color:green;font-size:0.9rem;'>" . $date3 . ", " . $tgl . " " . $month2 . " " . $year . "</div>";

                            $query_transaksi = mysqli_query($conn, "SELECT * FROM transaksi_pembelian WHERE mitra_id = '$id_user' AND date_grafik between '$dateprd 00:00' and '$dateprd 23:59'");
                            $total_transaksi = mysqli_num_rows($query_transaksi);
                        }

                        if ($total_transaksi != 0) {
                            echo '<div id="basic-doughnut" style="height:20vw;"></div>';
                        } else {
                            echo '<center><span style="color:red;font-size:14px;">Data Transaksi masih kosong</span></center>';
                        }
                        ?>
                    </div>
                    <?php
                    //Kondisi jika total transaksi tidak = 0
                    if ($total_transaksi != 0) {
                    ?>
                        <span class="footer">Total Penjualan : <b>Rp. <?= number_format($total_penjualan, 0, ',', '.') ?></b> dari <b> <?= $Total_PTransaksi ?></b> Akun Pemasok </span>
                    <?php
                    } else {
                    ?>
                        <span class="footer">Total Penjualan : <b>Rp. 0</b> dari <b> 0</b> Akun Pemasok </span>
                    <?php
                    }
                    ?>
                </div>
                <div class="col transaksi box-shadow p-3 m-2">
                    <span class="judul">Riwayat Transaksi</span>
                    <div class="table">
                        <table>
                            <?php
                            // Tabel Transaksi Pembelian
                            if ($total_transaksi != 0) {
                                while ($data_transaksi = mysqli_fetch_array($query_transaksi)) {
                                    $pemasok_id = $data_transaksi['pemasok_id'];
                                    $query_user = mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$pemasok_id'");
                                    $data_user = mysqli_fetch_array($query_user);
                            ?>
                                    <tr>
                                        <td><?= $data_user['nama_lengkap'] ?></td>
                                        <td>Rp. <?= number_format($data_transaksi['total_harga'], 0, ',', '.') ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td style="color:red;text-align:center;font-size:14px;">Data Transaksi masih kosong</td></tr>';
                            }
                            ?>
                        </table>
                        <a href="riwayat_transaksi.php" id="selengkapnya">Selengkapnya</a>
                    </div>
                </div>
            </div>
            <div class="row footer">
                <div class="col box-shadow p-3 m-2">
                    <span class="judul">Jadwal Penjemputan</span>
                    <?php
                    if ($Jml_JadwalKurir != 0) {
                        while ($data = mysqli_fetch_array($query_JadwalKurir)) {
                            $no_invoice = $data['no_invoice'];
                            $query_Users = mysqli_query($conn, "SELECT users.nama_lengkap, users.notelp, transaksi_pembelian.no_invoice, transaksi_pembelian.pemasok_id FROM users INNER JOIN transaksi_pembelian ON users.id_user = transaksi_pembelian.pemasok_id WHERE no_invoice = '$no_invoice' LIMIT 6");
                            $Data_Users = mysqli_fetch_array($query_Users);

                            // MANIPULASI NO HP jadi +62
                            // cek apakah no hp mengandung karakter + dan 0-9
                            if (!preg_match('/[^+0-9]/', trim($data['no_telp'])) || !preg_match('/[^+0-9]/', trim($Data_Users['notelp']))) {
                                // cek apakah no hp karakter 1-3 adalah +62
                                if (substr(trim($data['no_telp']), 0, 3) == '+62' || substr(trim($Data_Users['notelp']), 0, 3) == '+62') {
                                    $no_telp_kurir = trim($data['no_telp']);
                                    $no_telp_pemasok = trim($Data_Users['notelp']);
                                }
                                // cek apakah no hp karakter 1 adalah 0
                                elseif (substr(trim($data['no_telp']), 0, 1) == '0') {
                                    $no_telp_kurir = '62' . substr(trim($data['no_telp']), 1);
                                    $no_telp_pemasok = '62' . substr(trim($Data_Users['notelp']), 1);
                                }
                            }
                    ?>
                            <div class="row">
                                <img src="../assets/Icon/trash.png" alt="Trash">
                                <div class="col py-2">
                                    <span class="tanggal"><?= $data['tgl_penjemputan'] ?></span><br>
                                    <span class="keterangan"><b><?= "No. Invoice : " . $no_invoice ?></b></span><br>
                                    <span class="keterangan"><b>Nama Kurir : </b><?= $data['nama_kurir'] ?> | (<?= $data['no_telp'] ?>)</span><br>
                                    <span class="alamat"><b>Tujuan : </b><br>
                                        <?= "Nama : " . $Data_Users['nama_lengkap'] . "<br>No.Telepon : " . $Data_Users['notelp'] . "<br>Alamat : " . $data['alamat'] ?>
                                    </span>
                                </div>
                            </div>
                            <hr width="100%" style="border:1px dashed black;">
                    <?php
                        }
                    } else {
                        echo '<tr><td><center style="color:red;font-size:14px;">Jadwal Penjemputan Kurir masih kosong</center></td></tr>';
                    }
                    ?>
                    <center>
                        <a href="jadwal_penjemputan.php"><button type="submit" class="btn default">Selengkapnya</button></a>
                    </center>
                </div>
                <!-- <div class="isi-dropdown" id="isi-dropdown">
                                <input type="text" name="keterangan" placeholder="Masukan Keterangan Tambahan...">
                                <button type="submit" class="btn">Input</button>
                            </div>
                            <img src="../assets/Icon/arrow-point-to-right.png" alt="Panah" class="dropdown" id="dropdown"> -->

            </div>
        </div>
    </section>
    <!-- ====================================== -->
    <!-- JAVA SCRIPT -->
    <!-- ====================================== -->
    <script src="js/echarts-en.min.js"></script>

    <!-- Navigation Interactive -->
    <!-- Untuk Grafik -->
    <?php
    $query_Barang = mysqli_query($conn, "SELECT * FROM barang");
    $List_Barang = array();
    $data = array();
    // $data['data'] = array();
    while ($List = mysqli_fetch_assoc($query_Barang)) {
        array_push($List_Barang, $List['nama_barang']);
        $id_barang = $List['id_barang'];
        $query_TrxBarang = mysqli_query($conn, "SELECT * FROM transaksi_barang WHERE id_barang = '$id_barang'");
        $total_barang = mysqli_num_rows($query_TrxBarang);
        $hasil['value'] = $total_barang;
        $hasil['name'] = $List['nama_barang'];
        array_push($data, $hasil);
        // var_dump($total_barang);
    }
    $List_BarangENC = json_encode($List_Barang);
    $List_DataGrafik = json_encode($data);
    // var_dump($List_DataGrafik);
    ?>
    <!-- =========================== -->
    <script>
        let list = document.querySelectorAll('.navigation .list');
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

        // Toggle Button untuk Navigation 
        let menuToggle = document.querySelector('.toggle');
        let navigation = document.querySelector('.navigation');
        menuToggle.onclick = function() {
            menuToggle.classList.toggle('active');
            navigation.classList.toggle('active');
        }

        // ------------------------------
        // Basic pie chart
        // ------------------------------
        // based on prepared DOM, initialize echarts instance
        var basicdoughnutChart = echarts.init(document.getElementById('basic-doughnut'));
        var barang = <?= $List_BarangENC ?>; //List Barang sesuai Database
        var DataGrafik = <?= $List_DataGrafik ?>;
        console.log(DataGrafik);
        var option = {

            // Add legend
            legend: {
                orient: 'vertical',
                x: 'right',
                data: barang
            },

            // Add custom colors
            // color: ['#ffbc34', '#4fc3f7', '#2962FF', '#f62d51'],

            // Display toolbox
            toolbox: {
                show: false,
            },

            // Enable drag recalculate
            calculable: true,

            // Add series
            series: [{
                name: 'Grafik Terkini',
                type: 'pie',
                radius: ['20%', '30%'],
                center: ['40%', '40%'],
                itemStyle: {
                    normal: {
                        label: {
                            show: true
                        },
                        labelLine: {
                            show: true
                        }
                    },
                    emphasis: {
                        label: {
                            show: true,
                            formatter: '{b}' + '\n\n' + '{c} ({d}%)',
                            position: 'center',
                            textStyle: {
                                fontSize: '13',
                                fontWeight: '800'
                            }
                        }
                    }
                },

                data: DataGrafik
            }]
        };

        basicdoughnutChart.setOption(option);
    </script>

</body>

</html>