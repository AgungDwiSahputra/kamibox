<ul class="list_riwayat">
    <?php
    require '../connect_db.php';
    require '../session_data.php';

    /* Search */
    $s_keyword = "";
    if (isset($_POST['keyword'])) {
        $s_keyword = $_POST['keyword'];
    }
    $search_keyword = '%' . $s_keyword . '%';
    /* Riwayat Transaksi */
    $query_transaksi = mysqli_query($conn, "SELECT * FROM transaksi_pembelian WHERE mitra_id = '$id_user' AND no_invoice LIKE '$search_keyword' OR pemasok_id LIKE '$search_keyword' OR tgl_transaksi LIKE '$search_keyword'");
    $total_transaksi = @mysqli_num_rows($query_transaksi);
    // Tabel Transaksi Pembelian
    if ($total_transaksi != 0) {
        while ($data_transaksi = mysqli_fetch_array($query_transaksi)) {
            // Status Transaksi
            $status = 'Menunggu';
            $color_status = 'danger';
            if ($data_transaksi['status_transaksi'] == '0') {
                $status = 'Menunggu';
                $color_status = 'danger';
            } else if ($data_transaksi['status_transaksi'] == '1') {
                $status = 'Penjemputan';
                $color_status = 'warning';
            } else if ($data_transaksi['status_transaksi'] == '2') {
                $status = 'Berhasil';
                $color_status = 'success';
            }
            // ====================================================
            $pemasok_id = $data_transaksi['pemasok_id'];
            $query_user = mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$pemasok_id'");
            $data_user = mysqli_fetch_array($query_user);
    ?>
            <a class="list-hover" href="invoice.php?no_invoice=<?= $data_transaksi['no_invoice'] ?>">
                <li>
                    <div class="row2">
                        <div class="col">
                            <span class="tanggal"><?= $data_transaksi['tgl_transaksi'] ?></span>
                            <span class="nomor">#<?= $data_transaksi['no_invoice'] ?></span>
                        </div>
                    </div>
                    <div class="row2">
                        <div class="col">
                            <span class="keterangan"><b><?= "(" . $data_user['id_user'] . ")" . $data_user['nama_lengkap'] ?></b></span>
                            <span class="status <?= $color_status ?>"><?= $status ?></span>
                        </div>
                    </div>
                    <div class="row2">
                        <div class="col">
                            <span class="alamat"><b>Alamat : </b><?= $data_transaksi['alamat'] ?></span>
                        </div>
                    </div>
                </li>
            </a>
            <hr width="100%" style="border:1px dashed black;">
    <?php
        }
    } else {
        if (isset($_POST['keyword'])) {
            echo '<tr><td><center style="color:red;font-size:14px;">Data Transaksi tidak ditemukan</center></td></tr>';
        } else {
            echo '<tr><td><center style="color:red;font-size:14px;">Data Transaksi masih kosong</center></td></tr>';
        }
    }
    ?>
</ul>