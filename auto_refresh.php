<?php
/* REFRESH TOKEN */
$query = mysqli_query($conn, "SELECT * FROM tb_api_accurate");
$data = mysqli_fetch_object($query);
// var_dump(date('Y-m-d', strtotime('+5 days', strtotime(date('Y-m-d')))));
// var_dump(date('Y-m-d'));
// var_dump($data->expired_token);
// $dateNOW = date('Y-m-d', strtotime('+5 days', strtotime(date('Y-m-d'))));
$dateNOW = date('Y-m-d');
if ($dateNOW == $data->expired_token) {
    require 'admin/api/refresh_token.php';
}
