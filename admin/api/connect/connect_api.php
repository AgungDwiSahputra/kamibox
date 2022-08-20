<?php
require '../client.php';
define("CALLBACK_URL", "$url/admin/api/get_token.php");
define("AUTH_URL", "https://account.accurate.id/oauth/authorize");
define("ACCESS_TOKEN_URL", "https://account.accurate.id/oauth/token");
define("CLIENT_ID", "$client_id");
define("SCOPE", "item_view item_save item_delete customer_view customer_save customer_delete vendor_save vendor_view vendor_delete purchase_invoice_delete purchase_invoice_save purchase_invoice_view");


$url_auth = AUTH_URL . "?"
    . "client_id=" . urlencode(CLIENT_ID)
    . "&response_type=code"
    . "&redirect_uri=" . urlencode(CALLBACK_URL)
    . "&scope=" . urlencode(SCOPE);
header('Location: ' . $url_auth);

// if (!$_GET) {
//     $url = AUTH_URL . "?"
//         . "client_id=" . urlencode(CLIENT_ID)
//         . "&response_type=code"
//         . "&redirect_uri=" . urlencode(CALLBACK_URL)
//         . "&scope=" . urlencode(SCOPE);
//     header('Location: ' . $url);
// } else {
//     $client_id = $client_id;
//     $client_secret = $client_secret;
// }

/*

Setiap Access Token yang diterima oleh aplikasi pihak ke-3 akan expire dalam waktu 15 hari sejak dibuat. Jika expire, Access Token tidak lagi dapat digunakan untuk mengakses API. Untuk flow Grant Type: Authorization Code, aplikasi pihak ke-3 juga menerima Refresh Token pada response Access Token, dimana Refresh Token ini dapat digunakan untuk mendapatkan Access Token baru. Best practice yang kami sarankan adalah aplikasi melakukan Refresh Token apabila Access Token sudah expire atau minimal 1 hari sebelum expire.

Untuk melakukan Refresh Token, server aplikasi dapat melakukan request ke server AOL sbb:

URL https://account.accurate.id/oauth/token
Method  HTTP POST
Header
Authorization   Basic NDJmMTJhMTAtMDhkZi00YjkxLWIxZTQtYzQ0NjVkNjg2MDcyOmUxMzM0MTBlYjYzMjU5NjI1NWFkZmJlNWE0OTk5MGZl
Request Body
grant_type  refresh_token
refresh_token   5f32ef57-a3ba-4c6d-a763-c83c67350c73

*/
