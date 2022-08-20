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

$query3 =  mysqli_query($conn, "SELECT * FROM users where userlevelid = 2");

$datano[]=array();
$dataname[]=array();
$dataemail[]=array();
$datatelp[]=array();

$no=0;
$fields_string="";
$date = date("d/m/Y");

while ($row3 = mysqli_fetch_object($query3)) {
    $datano[$no] = $row3->id_user;
    $dataname[$no] = $row3->nama_lengkap;
    $dataemail[$no] = $row3->email;
    $datatelp[$no] = $row3->notelp;

    $fields_string .=   //"data[".$no."].id" . '=' . $datano[$no]. '&' .
                        "data[".$no."].name" . '=' . $dataname[$no]. '&' .
                        "data[".$no."].email" . '=' . $dataemail[$no]. '&' .
                        "data[".$no."].mobilePhone" . '=' . $datatelp[$no]. '&'.
                        "data[".$no."].customerNo" . '=' . $datano[$no]. '&'.
                        "data[".$no."].transDate" . '=' . $date. '&' ; 
    $no++;  
}

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
        "X-Session-ID: $session_db"
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

