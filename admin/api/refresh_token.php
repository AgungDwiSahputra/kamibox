<?php
require 'client.php';
include '../../connect_db.php';

$query_refresh_token = mysqli_query($conn, "SELECT * FROM tb_api_accurate");
$refresh_token = mysqli_fetch_array($query_refresh_token);

var_dump($refresh_token['refresh_token']);

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://account.accurate.id/oauth/token",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "grant_type=refresh_token&refresh_token=" . $refresh_token['refresh_token'],
    CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
        "Authorization: Basic " . base64_encode("$client_id:$client_secret")
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

// var_dump($response);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $data = json_decode($response);
    if ($data->error != "invalid_grant") {
        include '../../connect_db.php';

        $access_token = $data->access_token;
        $token_type = $data->token_type;
        $refresh_token = $data->refresh_token;
        $expires_in = $data->expires_in;
        $scope = $data->scope;
        $referrer = $data->user->referrer;
        $name = $data->user->name;
        $email = $data->user->email;

        $cek_data = "select * from tb_api_accurate";
        $result = $conn->query($cek_data);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $update_data = mysqli_query($conn, "UPDATE tb_api_accurate SET access_token='$access_token', token_type='$token_type', refresh_token='$refresh_token', expires_in='$expires_in', scope='$scope', referrer='$referrer', name='$name', email='$email'");
                if ($update_data == true) {
                    header('Location: ' . $url . '/admin/api/get_database.php');
                }
            }
        } else {
            $insert_data = mysqli_query($conn, "insert into tb_api_accurate (access_token, token_type, refresh_token, expires_in, scope, referrer, name, email) values ('$access_token', '$token_type', '$refresh_token', '$expires_in', '$scope', '$referrer', '$name', '$email')");
            if ($insert_data == true) {
                header('Location: ' . $url . '/admin/api/get_database.php');
            }
        }
    } else {
        header('Location: ' . $url . '/admin/api/connect_api.php');
    }

    // // echo $response;
}
