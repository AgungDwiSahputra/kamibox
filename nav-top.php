<div class="navigation-top">
    <ul>
        <?php
        if ($level != '1') {
        ?>
            <li class="nav-left"><b>Hai,</b> <?= $nama . " <b>[ID : " . $id_user . "]</b>" ?> </li>
        <?php
        }
        ?>
        <li class="nav-dropdown">
            <a href="#" id="nav-ListDropdown">
                <img src="../assets/Icon/user.png" alt="Account" class="user">
            </a>
            <div class="nav-ListDropdown" id="user">
                <div class="head">
                    <h4 style="margin: 0;">Profile</h4>
                </div>
                <div class="body">
                    <a href="profile.php"><img src="../assets/Icon/arrow-point-to-right.png" alt="Panah"> Data Diri</a>
                </div>
                <div class="footer">
                    <a href="../logout.php" style="text-align:center;" class="btn">Logout</a>
                </div>
            </div>
        </li>
        <li class="nav-dropdown">
            <a href="#" id="nav-ListDropdown">
                <img src="../assets/Icon/bell.png" alt="Notifikasi" class="bell">
            </a>
            <div class="nav-ListDropdown" id="bell">
                <div class="head">
                    <h4 style="margin: 0;">Notifikasi</h4>
                </div>
                <div class="body" style="overflow-x:hidden;">
                    <?php
                    /* RIWAYAT TRANSAKSI */
                    if ($level == '1') {
                        $query_transaksi = mysqli_query($conn, "SELECT * FROM transaksi_pembelian INNER JOIN users ON users.id_user = transaksi_pembelian.pemasok_id LIMIT 5");
                    } else  if ($level == '2') {
                        $query_transaksi = mysqli_query($conn, "SELECT * FROM transaksi_pembelian INNER JOIN users ON users.id_user = transaksi_pembelian.pemasok_id WHERE mitra_id = '$id_user' LIMIT 5");
                    } else  if ($level == '3') {
                        $query_transaksi = mysqli_query($conn, "SELECT * FROM transaksi_pembelian INNER JOIN users ON users.id_user = transaksi_pembelian.pemasok_id WHERE pemasok_id = '$id_user' LIMIT 5");
                    } else {
                        $query_transaksi = mysqli_query($conn, "SELECT * FROM transaksi_pembelian INNER JOIN users ON users.id_user = transaksi_pembelian.pemasok_id WHERE pemasok_id = '$id_user' LIMIT 5");
                    }
                    $total_penjualan = 0; //UNTUK TOTAL PENJUALAN PADA GRAFIK
                    while ($data_transaksiN = mysqli_fetch_array($query_transaksi)) {
                        // Status Transaksi
                        $status = 'Menunggu';
                        $color_status = 'danger';
                        if ($data_transaksiN['status_transaksi'] == '0') {
                            $status = 'Menunggu';
                            $color_status = 'danger';
                        } else if ($data_transaksiN['status_transaksi'] == '1') {
                            $status = 'Penjemputan';
                            $color_status = 'warning';
                        } else if ($data_transaksiN['status_transaksi'] == '2') {
                            $status = 'Berhasil';
                            $color_status = 'success';
                        }
                        // ====================================================
                        $total_penjualan += $data_transaksiN['total_harga'];
                    ?>
                        <a href="#">
                            <div class="row">
                                <div class="col">
                                    <img src="../assets/Icon/hvs.png" alt="Riwayat" id="riwayat">
                                </div>
                                <a href="invoice.php?no_invoice=<?= $data_transaksiN['no_invoice'] ?>">
                                    <div class="col">
                                        <span class="tanggal"><?= $data_transaksiN['tgl_transaksi'] ?></span>
                                        <span class="nama"><b><?= $data_transaksiN['nama_lengkap'] ?></b></span>
                                        <span class="keterangan <?= $color_status ?>"><b><?= $status ?></b></span>
                                    </div>
                                </a>
                            </div>
                        </a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </li>
    </ul>
</div>