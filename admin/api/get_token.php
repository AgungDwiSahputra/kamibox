<?php
require 'client.php';

$code = $_GET['code'];

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://account.accurate.id/oauth/token",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "code=$code&grant_type=authorization_code&client_id=" . $client_id . "&redirect_uri=" . $url . "/admin/api/get_token.php",
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/x-www-form-urlencoded",
        "Authorization: Basic " . base64_encode("$client_id:$client_secret")
    ),
));

$response = curl_exec($curl);

$err = curl_error($curl);

curl_close($curl);

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

        // Expired Token di buat 5 hari dari pembuatan token
        $date = date('Y-m-d');
        $date5 = date('Y-m-d', strtotime('+5 days', strtotime($date)));
        // =================================================

        $cek_data = "select * from tb_api_accurate";
        $result = $conn->query($cek_data);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $update_data = mysqli_query($conn, "UPDATE tb_api_accurate SET access_token='$access_token', token_type='$token_type', refresh_token='$refresh_token', expires_in='$expires_in', expired_token = '$date5', scope='$scope', referrer='$referrer', name='$name', email='$email'");
                if ($update_data == true) {
                    header('Location: ' . $url . '/admin/api/get_database.php');
                }
            }
        } else {
            $insert_data = mysqli_query($conn, "insert into tb_api_accurate (access_token, token_type, refresh_token, expires_in, expired_token, scope, referrer, name, email) values ('$access_token', '$token_type', '$refresh_token', '$expires_in', '$date5', '$scope', '$referrer', '$name', '$email')");
            if ($insert_data == true) {
                header('Location: ' . $url . '/admin/api/get_database.php');
            }
        }
    } else {
        header('Location: ' . $url . '/admin/api/connect_api.php');
    }

    // // echo $response;
}
