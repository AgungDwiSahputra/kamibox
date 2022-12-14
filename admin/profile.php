<?php
include '../connect_db.php';
require '../session_data.php';

//pastikan hanya pemasok yg boleh akses halaman ini
if ($level !== '1') {
    header("location:index.php");
}

/* EKSEKUSI UPDATE PROFILE */
if (isset($_POST['update'])) {
    $idProfile = $_POST['id_user'];
    $idAccurate = $_POST['id_accurate'];
    $namaProfile = $_POST['nama'];
    $emailProfile = $_POST['email'];
    $no_telpProfile = $_POST['no_telp'];
    $nama_jalanProfile = $_POST['nama_jalan'];
    $kotaProfile = $_POST['kota'];
    $provinsiProfile = $_POST['provinsi'];
    $negaraProfile = $_POST['negara'];
    $kd_posProfile = $_POST['kd_pos'];
    $norekProfile = $_POST['norek'];
    $notes = "Nomor Rekening : " . $norekProfile;
    $alamat = $nama_jalanProfile . ", " . $kotaProfile . ", " . $provinsiProfile . ", " . $negaraProfile . ", " . $kd_posProfile; //Mengambil dari pecahan inputan alamat di jadikan 1 ke variabel alamat
    $tanggal = date("d/m/Y");

    $query = mysqli_query($conn, "UPDATE users SET nama_lengkap = '$namaProfile', email = '$emailProfile', notelp = '$no_telpProfile', nama_jalan = '$nama_jalanProfile', kota = '$kotaProfile', provinsi = '$provinsiProfile', negara = '$negaraProfile', kd_pos = '$kd_posProfile',  nomor_rekening = '$norekProfile' WHERE id_user = '$idProfile'");

    if ($query) {
        // ========================== api acurate ==========================
        require '../auto_refresh.php'; // Auto Refresh token 5 hari sekali dari awal pembuatan token 

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

        curl_setopt_array($curl, array(
            CURLOPT_URL => "$host/accurate/api/vendor/save.do",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "id=$idAccurate&name=$namaProfile&transDate=$tanggal&email=$email&billCity=$kotaProfile&billCountry=$negaraProfile&billProvince=$provinsiProfile&billStreet=$alamat&billZipCode=$kd_posProfile&mobilePhone=$no_telpProfile&vendorNo=$id_user&notes=$notes",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "Authorization: Bearer $access_token",
                "X-Session-ID: $session_db"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        /* ====================================================== */

        setcookie('sukses', 'Berhasil Update Data Diri', time() + 3, '/');
        header("Location:profile.php");
    }
}
/* ================================= */

//cek login
if ($status_login === true and !empty($email) and $level == '1') {
    //echo "pemasok page. <a href='logout.php'>Logout</a>";

?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Profile | <?= $nama ?></title>
        <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
        <!-- Custom CSS -->
        <link href="css/style.css" rel="stylesheet">
        <style>
            .subheading-error-otp {
                display: block;
                padding: 5px 20px;
                margin-top: 10px;
                background-color: rgba(255, 0, 0, 0.2);
                color: red;
                font-size: 0.85rem;
                font-weight: 500;
            }

            .subheading-sukses-otp {
                display: block;
                padding: 5px 20px;
                margin-top: 10px;
                background-color: rgba(6, 155, 69, 0.2);
                color: #069B45;
                font-size: 0.85rem;
                font-weight: 500;
            }
        </style>
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
        <div class="container">
            <div class="row header">
                <div class="col">
                    <h2>Data Diri</h2>
                    <h5>
                        <a href="index.php">Beranda</a>
                        <span class="panah">></span>
                        <a href="profile.php">Profile</a>
                    </h5>
                </div>
            </div>
            <div class="row body">
                <div class="col">
                    <form action="" method="post">
                        <?php
                        if (isset($_COOKIE['gagal'])) {
                            echo '<span class="subheading-error-otp">' . $_COOKIE['gagal'] . '</span>';
                        } elseif (isset($_COOKIE['sukses'])) {
                            echo '<span class="subheading-sukses-otp">' . $_COOKIE['sukses'] . '</span>';
                        }
                        ?>
                        <ul>
                            <?php
                            include '../connect_db.php';

                            //query tampilkan nama barang
                            $query = mysqli_query($conn, "select * from users where id_user = $id_user");

                            while ($row = mysqli_fetch_assoc($query)) {
                                // echo "<li>";
                                // echo "<span class=jenis>Nama </span>";
                                // echo "<span class=harga>" . $row['nama_lengkap'] . "</span>";
                                // echo "</li>";
                                // echo "<li>";
                                // echo "<span class=jenis>Email </span>";
                                // echo "<span class=harga>" . $row['email'] . "</span>";
                                // echo "</li>";
                                // echo "<li>";
                                // echo "<span class=jenis>Nomor Ponsel </span>";
                                // echo "<span class=harga>" . $row['notelp'] . "</span>";
                                // echo "</li>";
                                // echo "<li>";
                                // echo "<span class=jenis>Alamat </span>";
                                // echo "<span class=harga>" . $row['alamat'] . "</span>";
                                // echo "</li>";
                            ?>
                                <li>
                                    <span class="jenis" for="nama">Nama </span>
                                    <input class="harga" name="id_user" value="<?= $row['id_user'] ?>" hidden>
                                    <input class="harga" type="text" id="nama" name="nama" value="<?= $row['nama_lengkap'] ?>" placeholder="Masukan Nama">
                                </li>
                                <li>
                                    <span class="jenis" for="email">Email </span>
                                    <input class="harga" type="email" id="email" name="email" value="<?= $row['email'] ?>" placeholder="Masukan Email">
                                </li>
                                <li>
                                    <span class="jenis" for="no_telp">Nomor Ponsel </span>
                                    <input class="harga" type="text" id="no_telp" name="no_telp" value="<?= $row['notelp'] ?>" placeholder="Masukan Nomor Ponsel">
                                </li>
                                <li>
                                    <span class="jenis" for="nama_jalan">Nama Jalan </span>
                                    <input class="harga" type="text" id="nama_jalan" name="nama_jalan" value="<?= $row['nama_jalan'] ?>" placeholder="Masukan Nama Jalan">
                                </li>
                                <li>
                                    <span class="jenis" for="kota">Kota </span>
                                    <input class="harga" type="text" id="kota" name="kota" value="<?= $row['kota'] ?>" placeholder="Masukan Kota">
                                </li>
                                <li>
                                    <span class="jenis" for="provinsi">Provinsi </span>
                                    <input class="harga" type="text" id="provinsi" name="provinsi" value="<?= $row['provinsi'] ?>" placeholder="Masukan Provinsi">
                                </li>
                                <li>
                                    <span class="jenis" for="negara">Negara </span>
                                    <input class="harga" type="text" id="negara" name="negara" value="<?= $row['negara'] ?>" placeholder="Masukan Negara">
                                </li>
                                <li>
                                    <span class="jenis" for="kd_pos">Kode Pos </span>
                                    <input class="harga" type="number" id="kd_pos" name="kd_pos" value="<?= $row['kd_pos'] ?>" placeholder="Masukan Kode Pos">
                                </li>
                                <li>
                                    <span class="jenis" for="norek">Nomor Rekening </span>
                                    <input class="harga" id="norek" name="norek" value="<?= $row['nomor_rekening'] ?>" placeholder="Masukan Nomor Rekening">
                                </li>
                            <?php
                            }

                            ?>
                            <button type="submit" name="update" class="btn default mt-3">Update</button>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
        <br /><br />

        <!-- ====================================== -->
        <!-- JAVA SCRIPT -->
        <!-- ====================================== -->
        <!-- Navigation Interactive -->
        <script>
            let list = document.querySelectorAll('.navigation .list'); //NAVIGATION
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




<?php } ?>