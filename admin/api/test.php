<?php
require '../../connect_db.php';
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

// $curl = curl_init();
// $date = date("d/m/Y");

// curl_setopt_array($curl, array(
//   CURLOPT_URL => "$host/accurate/api/item/list.do",
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 30,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "GET",
//   CURLOPT_HTTPHEADER => array(
//     "content-type: application/x-www-form-urlencoded",
//     "Authorization: Bearer $access_token",
//     "X-Session-ID: $session_db"
//   ),
// ));

// $response = curl_exec($curl);
// $err = curl_error($curl);

// curl_close($curl);
// $decode = json_decode($response, true);
// var_dump($decode['d']['0']['id']);


$curl = curl_init();
$date = date("d/m/Y");

curl_setopt_array($curl, array(
  CURLOPT_URL => "$host/accurate/api/vendor/detail.do?id=751",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "content-type: application/x-www-form-urlencoded",
    "Authorization: Bearer $access_token",
    "X-Session-ID: $session_db"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
$json = json_decode($response, true);
var_dump($json['d']['id']);
var_dump($json);


// $query3 =  mysqli_query($conn, "SELECT * FROM barang");
// $id_barang ="";
// $nama_barang = "";
// $hpp ="";
// $harga ="";
// $data_post[]=array();
// $datano[]=array();
// $dataname[]=array();
// $dataprice[]=array();

// $no=0;
// $fields_string="";
// /*while ($row3 = mysqli_fetch_object($query3)) {
    
//     echo $datano[$no] = $row3->id_barang;
//     echo " ".$dataname[$no] = $row3->nama_barang;
//     echo " ".$dataprice[$no] = $row3->harga_barang;
//     $no++;
// }*/

// while ($row3 = mysqli_fetch_object($query3)) {
//     $datano[$no] = $row3->id_barang;
//     $dataname[$no] = $row3->nama_barang;
//     $dataprice[$no] = $row3->harga_barang;

  

// /*    $data_post=array(
//     echo    "data[".$no."].no" . '=' . $datano[$no]. '&';
//     echo    "data[".$no."].name" . '=' . $dataname[$no]. '&';
//     echo    "data[".$no."].unitPrice" . '=' . $dataprice[$no]. '&';
//     );
// */

//     $fields_string .=   "data[".$no."].no" . '=' . $datano[$no]. '&' .
//                         "data[".$no."].name" . '=' . $dataname[$no]. '&' .
//                         "data[".$no."].unitPrice" . '=' . $dataprice[$no]. '&';
//     $no++;  
  
// }

// $fieldapi = rtrim($fields_string, '&');
// print_r($fieldapi);
/*
$data_post = array(
        "data[".$no."].no" => $datano[$no],
        "data[".$no."].name" => $dataname[$no],
        "data[".$no."].unitPrice" => $dataprice[$no]
    );

foreach($data_post as $key => $val) {
  $fields_string .= $key . '=' . $val . '&';
}
rtrim($fields_string, '&');
//data[0].no=$datano[0]&data[0].name=$dataname[0]&data[0].itemType=INVENTORY&data[n].vendorUnitName =$dataunit[0]&data[0].unitPrice=$dataprice[0]



/*$data_post = array(
                "code" => $code,
                "grant_type" => "authorization_code", 
                "username" => $client_id,
                "password" => $client_secret,
                "redirect_uri" => "http://localhost/kamiboxhosting2/api/get_token.php"
                );

<?php
$arr = ['Item 1', 'Item 2', 'Item 3'];

foreach ($arr as $item) {
  var_dump($item);
}

$dict = array("key1"=>"35", "key2"=>"37", "key3"=>"43");

foreach($dict as $key => $val) {
  echo "$key = $val<br>";
}
?>

while( list( $field, $value ) = each( $_POST )) {
   echo "<p>" . $field . " = " . $value . "</p>\n";
}


foreach ($data_post as $key => $value) {
    $fields_string .= $key . '=' . $value . '&';
}

rtrim($fields_string, '&');
data[n].no
data[0].no=$datano[0]&data[0].name=$dataname[0]&data[0].itemType=INVENTORY&data[n].vendorUnitName =$dataunit[0]&data[0].unitPrice=$dataprice[0]


foreach loop in phpphp by The.White.Fang on Jun 28 2020 Donate Comment
8
1
<?php
2
$arr = ['Item 1', 'Item 2', 'Item 3'];
3
​
4
foreach ($arr as $item) {
5
  var_dump($item);
6
}
7
​
8
$dict = array("key1"=>"35", "key2"=>"37", "key3"=>"43");
9
​
10
foreach($dict as $key => $val) {
11
  echo "$key = $val<br>";
12
}
13
?>
php foreach arrayphp by Xenophobic Xenomorph Xenophobic Xenomorph        on Mar 06 2021 Comment
1
1
$arr = array(1, 2, 3);
2
foreach ($arr as $key => $value) {
3
    echo "{$key} => {$value} ";
4
}
php foreachphp by Mohammadali Mirhamed Mohammadali Mirhamed        on Apr 07 2020 Comment
11
1
<?php
2
$age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
3
​
4
foreach($age as $x => $val) {
5
  echo "$x = $val<br>";
6
}
7
?>

*/
