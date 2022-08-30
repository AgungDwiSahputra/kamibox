<?php
require '../connect_db.php';
require '../session_data.php';
/* =========================================================== */
//pastikan hanya pemasok yg boleh akses halaman ini
if ($level !== '1') {
    header("location:../index.php");
}
/* =========================================================== */
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

    <title>Invoice | Admin Kamibox</title>

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">

    <!-- JQUERY -->
    <script src="../assets/js/jquery-3.6.0.min.js"></script>

    <!-- SC untuk html -> GAMBAR -->
    <script src="../assets/js/html2canvas.js"></script>
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
            <li class="list">
                <b></b>
                <b></b>
                <a href="jadwal_kurir.php">
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
    <div class="container mb-1">
        <a href="riwayat_transaksi.php" style="width: 70px; cursor:pointer;">
            <button style="padding: 2px 15px; line-height: 30px;vertical-align: middle;border-radius: 30px; font-size: 14px; background-color: red; cursor:pointer; ">
                <img src="../assets/Icon/arrow-point-to-right.png" style="width: 13px;transform: rotate(180deg);line-height: 20px;vertical-align: middle;">
                Back
            </button>
        </a>
        <?php
        if (isset($_GET['no_invoice'])) {
        ?>
            <button type="submit" class="btn default ml-1" style="display: inline;" id="download">Download</button>
        <?php
        }
        ?>
    </div>
    <div class="container" id="invoice">
        <div class="invoice box-shadow p-3 m-2">
            <div class="row">
                <div class="col">
                    <?php
                    if (isset($_GET['no_invoice'])) {
                        $no_invoice = $_GET['no_invoice'];
                        $query_TrxPembelian = mysqli_query($conn, "SELECT users.nama_lengkap, transaksi_pembelian.* FROM transaksi_pembelian INNER JOIN users ON users.id_user = transaksi_pembelian.pemasok_id WHERE no_invoice = '$no_invoice'");
                        $query_TrxBarang = mysqli_query($conn, "SELECT * FROM transaksi_barang INNER JOIN barang ON barang.id_barang = transaksi_barang.id_barang WHERE transaksi_barang.no_invoice = '$no_invoice'");
                        $data_TrxPembelian = mysqli_fetch_object($query_TrxPembelian);
                    ?>
                        <div class="box" id="cetak">
                            <div class="row header">
                                <div class="col">
                                    <h1>Invoice #<span id="no_invoice"><?= $data_TrxPembelian->no_invoice ?></span></h1>
                                    <table align="left" style="font-weight:bold;">
                                        <tr>
                                            <td width="100px">Nama</td>
                                            <td width="500px">: <?= $data_TrxPembelian->nama_lengkap ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal</td>
                                            <td>: <?= $data_TrxPembelian->tgl_transaksi ?></td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>: <?= $data_TrxPembelian->alamat ?></td>
                                        </tr>
                                        <tr>
                                            <td>Link Maps</td>
                                            <td>: <a href="<?= $data_TrxPembelian->link_maps ?>" target="_BLANK" style="color: #08AC4D;"><?= $data_TrxPembelian->link_maps ?></a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row body">
                                <div class="col">
                                    <table class="list-produk" border="1">
                                        <thead>
                                            <tr>
                                                <th>Produk</th>
                                                <th>Berat (kg)</th>
                                                <th>Harga /Item</th>
                                                <th>Total Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody style="text-align: center;">
                                            <?php
                                            while ($data_TrxBarang = mysqli_fetch_object($query_TrxBarang)) {

                                            ?>
                                                <tr>
                                                    <td><b><?= $data_TrxBarang->nama_barang ?></b></td>

                                                    <td>
                                                        <?php
                                                        $List_TrxBerat = explode(',', $data_TrxBarang->berat);
                                                        $total_harga = 0; // Total Berat per Item Daur Ulang
                                                        $total_berat = 0; // Total berat per item
                                                        // var_dump($List_TrxBerat[0]);
                                                        for ($i = 0; $i < count($List_TrxBerat); $i++) {
                                                            if ($List_TrxBerat[$i] != null) {
                                                        ?>
                                                                <!-- CETAK PENIMBANGAN -->
                                                                Penimbangan <?= $i + 1 ?>&emsp;: <?= $List_TrxBerat[$i] ?>kg<br>
                                                                <!-- ============================ -->
                                                        <?php
                                                                $total_harga += $data_TrxBarang->harga_barang * $List_TrxBerat[$i];
                                                                $total_berat += $List_TrxBerat[$i];
                                                            } else {
                                                                echo '<li><span class="daur_ulang">Belum ada hasil penimbangan</span></li>';
                                                            }
                                                        }
                                                        echo "<b>TOTAL BERAT : " . $total_berat . "kg</b>";
                                                        ?>
                                                    </td>

                                                    <td>Rp. <?= number_format($data_TrxBarang->harga_barang, 0, ',', '.') ?></td>
                                                    <td>Rp. <?= number_format($total_harga, 0, ',', '.') ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <br>
                                    <table class="rekam mt-4">
                                        <tr>
                                            <td>Subtotal</td>
                                            <td width="130px">Rp. <?= number_format($data_TrxPembelian->harga_item, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>Pajak</td>
                                            <td>Rp. <?= number_format($data_TrxPembelian->biaya_jemput, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>

                                            <th>
                                                <h3>TOTAL</h3>
                                            </th>
                                            <th>
                                                <h3>Rp. <?= number_format($data_TrxPembelian->total_harga, 0, ',', '.') ?></h3>
                                            </th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- <div id="preview" style="width:100px;"></div> -->
                    <?php
                    } else {
                        echo '<span style="text-align:center;display:block;color:red;">No Invoice TIdak Tersedia</span>';
                    }
                    ?>
                    <!-- Button -->
                    <!-- <button type="submit" class="btn default mt-4 ml-5s" id="preview-btn">Preview</button> -->
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


    <!-- HTML to GAMBAR -->
    <script>
        // html2canvas(document.getElementById("invoice")).then(function(canvas) {
        //     var anchorTag = document.createElement("a");
        //     var no_invoice = document.getElementById("no_invoice").innerText;
        //     document.body.appendChild(anchorTag);
        //     document.getElementById("preview").appendChild(canvas);
        //     // document.getElementById("invoice").style.visibility = 'hidden';
        // });
        document.getElementById("download").addEventListener("click", function() {
            html2canvas(document.getElementById("cetak")).then(function(canvas) {
                var anchorTag = document.createElement("a");
                var no_invoice = document.getElementById("no_invoice").innerText;
                document.body.appendChild(anchorTag);
                // document.getElementById("preview").appendChild(canvas);
                anchorTag.download = "invoice-" + no_invoice + ".jpg";
                anchorTag.href = canvas.toDataURL();
                anchorTag.target = '_blank';
                anchorTag.click();
            });
        });
    </script>

</body>

</html>