<?php
include '../../connect_db.php';
$query2 =  mysqli_query($conn, "SELECT * FROM tb_database_response_api");
$access_token = "";
$session_db = "";
$host = "";
while ($row = mysqli_fetch_object($query2)) {
    $access_token .= $row->access_token;
    $session_db .= $row->session_db;
    $host .= $row->host;

}

$id=48;
$nama ="Hendrik De";
$email = "dehendrik@gmail.com";
$notelp = "08712345569";

$query3 =  mysqli_query($conn, "UPDATE users SET nama_lengkap='$nama', email='$email', notelp='$notelp' WHERE id_user = '$id'");


$fields_string="";
$date = date("d/m/Y");



    $fields_string .=   "data[".$id."].id" . '=' . $id. '&' .
                        "data[".$id."].name" . '=' . $nama. '&' .
                        "data[".$id."].email" . '=' . $email. '&' .
                        "data[".$id."].mobilePhone" . '=' . $notelp. '&'.
                        "data[".$id."].customerNo" . '=' . $id. '&'.
                        "data[".$id."].transDate" . '=' . $date. '&' ; 


$fieldsApi = rtrim($fields_string, '&');


$curl = curl_init();


curl_setopt_array($curl, array(
    CURLOPT_URL => "$host/accurate/api/customer/bulk-save.do",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $fieldsApi,
    CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
        "Authorization: Bearer $access_token",
        "X-Session-ID: $session_db",
       // "data[".$id."].id : $id",
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}

