<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    include '../../../connect_db.php';

    // if (isset($_POST['submit'])) {
    $id = $_POST["param"];
    $kd_barang = $_POST["kd_barang"];
    $nama = $_POST["nama"];
    $hpp = $_POST["hpp"];
    $harga = $_POST["harga"];

    $msg = [
        'error' => []
    ];

    if ($harga == '') {
        $msg['error'] = ['harga' => 'Harga barang tidak boleh kosong'];
    } else {
        if (!is_numeric($harga)) {
            $msg['error'] = ['harga' => 'Harga hanya berupa angka'];
        }
    }

    if ($nama == '') {
        $msg['error'] = ['nama' => 'Nama baranng tidak boleh kosong'];
    }

    if ($hpp == '') {
        $msg['error'] = ['hpp' => 'HPP barang tidak boleh kosong'];
    } else {
        if (!is_numeric($hpp)) {
            $msg['error'] = ['hpp' => 'HPP hanya berupa angka'];
        }
    }

    if (!empty($msg['error'])) {
        echo json_encode($msg);
    } else {
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
        $date = date("d/m/Y");

        curl_setopt_array($curl, array(
            CURLOPT_URL => "$host/accurate/api/item/save.do",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "id=$id&itemType=INVENTORY&name=$nama&unitPrice=$harga&no=$kd_barang",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "Authorization: Bearer $access_token",
                "X-Session-ID: $session_db"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $update_data = mysqli_query($conn, "UPDATE barang SET nama_barang='$nama', HPP='$hpp', harga_barang='$harga' WHERE id_barang = '$id'");
        if ($update_data == true) {
            $msg = [
                'sukses' => [
                    'status' => 200
                ]
            ];
        } else {
            $msg = [
                'error' => [
                    'msg' => 'Terjadi kesalahan coba lagi'
                ]
            ];
        }

        echo json_encode($msg);
    }





    // }
}
