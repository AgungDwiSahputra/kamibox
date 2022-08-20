<?php error_reporting(0); ?>


<?php

session_start();
include '../connect_db.php';
include 'session_timeout.php';
include 'hari_indo.php';

//cek status login user di session 
$status_login = $_SESSION['login'];
$id_user      = $_SESSION['id_user'];
$email        = $_SESSION['email_user'];
$avatar       = $_SESSION['avatar_user'];
$nama         = $_SESSION['nama_user'];
$telp         = $_SESSION['notelp_user'];
$level        = $_SESSION['level_user'];
$status_user  = $_SESSION['status_user'];

if (($status_login !== true) && empty($email)) {
    header("location:login.php");
}

//pastikan hanya pemasok yg boleh akses halaman ini
if ($level !== '3') {
    header("location:index.php");
}

//cek login
if ($status_login === true and !empty($email) and $level == '3') {
    //echo "pemasok page. <a href='logout.php'>Logout</a>";

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Description Web -->
        <meta name="keywords" content="kamibox">
        <meta name="description" content="">
        <meta name="author" content="Agung Dwi Sahputra">
        <link rel="shortcut icon" type="image/png" href="../assets/icon.png">

        <title>Dashboard Pemasok | Pemasok Kamibox</title>

        <!-- Link Swiper's CSS -->
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

        <!-- Custom CSS -->
        <link href="css/style.css" rel="stylesheet">

        <style type="text/css">
            /* ================================= */
            /* CONTENT LEFT RIGHT GRAFIK*/
            /* ================================= */
            html,body{
                box-sizing: border-box;
            }
            .dashboard-wrapper {
                margin: auto;
                display: flex;

            }

            .row2 {
                margin-left: 150px;
                margin-top: 30px;
            }

            .row3 {
                margin-right: 250px;
                margin-top: 40px;
            }

            .row4 {
                margin-right: 250px;
                margin-top: 30px;
            }

            .card-grafik {
                width: 500px;
                box-shadow: 0px 1px 20px 0px rgba(0, 0, 0, 0.3);
                transition: 0.3s;
                border-radius: 30px;
                background-color: #FFF;

            }

        .card-artikel {
            display: flex;
            gap: 20px;
            z-index: -1;
        }

        .swiper {
            width: 350px;
            height: 320px;
            z-index: -1;
        }

        .swiper-slide {

            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
            z-index: -1;
        }


        .segmen-artikel {
            width: 200px;
            height: 250px;
            box-shadow: 0px 1px 8px 0px rgba(0, 0, 0, 0.3);
            transition: 0.3s;
            border-radius: 30px;
            background-color: #FFF;
            z-index: -1;
        }

        .img-artikel {
            position: absolute;
            width: 200px;
            height: 250px;
            border-radius: 30px;
        }

        .segmen-content-blogs {
            position: absolute;
            width: 200px;
            height: 180px;
            border-radius: 30px;
            background-color: rgba(255, 255, 255, 0.8);
            margin-top: 70px;
        }

        .segmen-isi-blog {
            padding: 0 30px;
            font-size: 0.7rem;
        }

        .segmen-content-blogs .segmen-button-blog {
            margin-top: 5px;
            text-align: center;
        }

        .segmen-isi-blog .judul-blog {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .segmen-button-blog .btn-blog {
            font-weight: 500;
            color: #069B45;
            background-color: #FFF;
            margin: 40px 0;
            padding: 8px 20px;
            border-radius: 50px;
            font-family: var(--main-font);
            border: 1px solid green;
            font-size: 0.7rem;
        }

        .card-transaksi,
        .card-harga {
            width: 400px;
            box-shadow: 0px 1px 20px 0px rgba(0, 0, 0, 0.3);
            transition: 0.3s;
            border-radius: 30px;
            background-color: #FFF;

        }

        .heading-grafik,
        .heading-transaksi,
        .heading-harga {
            padding-top: 5px;
            padding-left: 30px;

        }

        .content-grafik {
            margin: 0 30px;
        }

        .content-transaksi,
        .content-harga {
            display: flex;
            gap: 80px;
            margin: 0 30px;
            font-size: 0.8rem;
        }

        .tanggal {
            font-weight: 99;
        }

        .total,
        .harga,
        .produk {
            font-weight: 700;
        }

        .harga,
        .produk {
            font-weight: 600;
        }

        .produk,
        .harga {
            line-height: 65%;
        }

        .tanggal,
        .total {
            line-height: 85%;
        }

        .btn-transaksi,
        .btn-harga {
            text-align: center;
            padding: 15px;
        }

        .btn-selengkapnya {
            font-weight: 500;
            color: #069B45;
            background-color: #FFF;
            margin: 40px 0;
            padding: 8px 20px;
            border-radius: 50px;
            font-family: var(--main-font);
            border: 1px solid var(--main-color);
            outline: none;
            font-size: 0.85rem;
        }

        ::-webkit-scrollbar {
            width: 10px;
        }
         
        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);     
            background: #666;    
        }
         
        ::-webkit-scrollbar-thumb {
            background: #232323;
        }

        @media screen and (max-width: 1200px) {
            .row3, .row4 {
                margin-right: 50px;
            }
        }

        @media screen and (max-width: 1050px) {
            .dashboard-wrapper .cards{
                margin: auto;
                display: inline-flex;
                flex-direction: column;
                flex-wrap: wrap;
                justify-content: center;
                align-content: center;
            }

            .row2,.row3,.row4{
                margin-right: 0;
            }
        }

        @media screen and (max-width: 750px) {
            .navigation{
                width: 70px;
            }

            .dashboard-wrapper .cards{
                margin: auto;
                display: inline-flex;
                flex-direction: column;
                flex-wrap: nowrap;
                justify-content: center;
                align-content: center;
            }

            .row2,.row3,.row4{
                margin: 20px auto;
            } 

            .container{
                margin-left: 30px;
            }

            .card-grafik {
                width: 100%;
                box-shadow: 0px 1px 8px 0px rgba(0, 0, 0, 0.3);
                border-radius: 30px;
                overflow: scroll;
            }  
            
        }

         @media screen and (max-width: 550px) {
            .navigation{
                width: 60px;
                top: 10px;
                left: 1px;
                bottom: 10px;
            }

            .navigation-top ul{
                padding: 0 8px;
            }

            .navigation-top ul li a .user{
                width: 25px;
            }
            .navigation-top ul li a .bell{
                width: 18px;
            }


            .dashboard-wrapper .cards{
                margin: auto;
                display: inline-flex;
                flex-direction: column;
                flex-wrap: nowrap;
                justify-content: left;
                align-content: left;
                margin: 10px;
            }

            .row2,.row3,.row4{
                margin: 0px auto;
            } 

            .card-grafik {
                width: 75%;
                border-radius: 2px;
                margin-left: 40px;
                margin-top: 30px;
            }  

            .card-transaksi,
            .card-harga {
                width: 100%;
                border-radius: 2px;
                overflow: scroll;
                margin-left: 40px;
            }

            .swiper {
                margin-left: 40px;   
            }

            .content-transaksi,
            .content-harga {
                display: flex;
                margin: 0 8px;
                font-size: 0.8rem;

            }
            .container{
                text-align:left;
            }
        }

        @media screen and (max-width: 450px) {
            .navigation ul li .icon img.putih,
            .navigation ul li .icon img.hijau{
                width: 25px;
            }

            .navigation-top ul li.nav-left{
                margin-left: 80px;
                margin-top: 15px;
                font-size: 12px;
            }

            .container{
                font-size: 12px;
            }

            .card-grafik {
                width: 60%;
                margin-left: 40px;
                margin-top: 20px;
            } 
            
            .swiper {
                margin-left: 40px;
                width: 300px;
                overflow: scroll;   
            }

            .card-transaksi,
            .card-harga {
                width: 300px;
                border-radius: 2px;
                margin-left: 40px;
                overflow: hidden;
            }               

            .content-transaksi,
            .content-harga {
                display: flex;
                gap: 20px;
                margin: 20px;
                font-size: 0.75rem;
                width: 300px;
                overflow: scroll;                
            }

            .toggle img.close{
                width: 25px;
                margin-left: 5px;
            }


        }

       
    </style>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 

    <script type="text/javascript">

    	google.charts.load('current', {'packages':['corechart']}); 
        google.charts.setOnLoadCallback(drawChart3); 

           function drawChart3()  { 

                var data = google.visualization.arrayToDataTable([ 

                          ['Nama Barang', 'Total'],

                          <?php 

                          		$query1 = mysqli_query($conn, "select * from barang");
           
        						//$datep = $_GET['ke'];// + " 23:59";    
                          		
                          		//jika date tidak diinputkan
                            if(isset($_GET['ke'])){
                                $datep = $_GET['ke'];                                
                            }else{
                                $datep = date('Y-m-d');         
                            }

                          		while ($row1 = mysqli_fetch_array($query1)) {
                                     
	        						$barang_id = $row1['id_barang'];
	    	
	    							//jumlah seluruh barang
							    	$query2 = mysqli_query($conn, "select count(transaksi_barang.id_barang) as jml from transaksi_pembelian inner join transaksi_barang ON transaksi_pembelian.pemasok_id = transaksi_barang.pemasok_id where transaksi_pembelian.pemasok_id=$id_user and transaksi_barang.id_barang = $barang_id and transaksi_pembelian.date_grafik between '$datep 00:00' and '$datep 23:59' ");

								    	while ($row2 = mysqli_fetch_array($query2)) {
											
											//jumlah berat barang 
											$query3= mysqli_query($conn, "select * from transaksi_barang where id_barang = $barang_id and pemasok_id=$id_user");
											$no=0;
											$tampung_berat="";
											$data_berat[]=array();

											while($row3=mysqli_fetch_array($query3)){
											

													$data_berat[$no]=$row3['berat'];
													$tampung_berat .= $data_berat[$no].",";  
					
													$no++;
											}

											$tampung_berat=rtrim($tampung_berat, ',');

											$tampung_berat = explode(',',$tampung_berat);
				

											$total_berat = 0;
											foreach($tampung_berat as $beratn){
												$total_berat = $total_berat + $beratn; 
											}

											echo "['".$row1["nama_barang"]."', ".$total_berat."],";
								        }

								    }
                          ?> 

                     ]);

                var options = {
	                title: ' ',
	                pieHole: 0.8,
	                pieSliceTextStyle: {
	                    color: 'black',
	                },
	            }; 

                var chart = new google.visualization.PieChart(document.getElementById('piechart3')); 
                chart.draw(data, options); 

           }

    </script>

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
                <li class="list active">
                    <b></b>
                    <b></b>
                    <a href="index.php">
                        <span class="icon">
                            <img src="../assets/Icon/home_p.png" alt="Beranda" class="putih">
                            <img src="../assets/Icon/home_h.png" alt="Beranda" class="hijau">
                        </span>
                        <span class="title">Beranda</span>
                    </a>
                </li>
                <li class="list">
                    <b></b>
                    <b></b>
                    <a href="riwayat_transaksi.php">
                        <span class="icon">
                            <img src="../assets/Icon/transaction_p.png" alt="Riwayat Transaksi" class="putih">
                            <img src="../assets/Icon/transaction_h.png" alt="Riwayat Transaksi" class="hijau">
                        </span>
                        <span class="title">Riwayat Transaksi</span>
                    </a>
                </li>
                <li class="list">
                    <b></b>
                    <b></b>
                    <a href="daftar_harga.php">
                        <span class="icon">
                            <img src="../assets/Icon/input_p.png" alt="Input Data" class="putih">
                            <img src="../assets/Icon/input_h.png" alt="Input Data" class="hijau">
                        </span>
                        <span class="title">Harga Barang</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ====================================== -->
        <!-- ISI CONTENT -->
        <!-- ====================================== -->
        <div class="container">
            <div class="dashboard-wrapper">
                <!-- card grafik -->
                <div class="cards">
                    <div class="row2 card-grafik">
                        <div class="heading-grafik">
                            <h4>Grafik Terkini</h4>
                        </div>
                        <div class="content-grafik">
<?php

//grafik periode

//jika date tidak diinputkan
                            if(isset($_GET['ke'])){
                                $dateprd = $_GET['ke'];                                
                            }else{
                                $dateprd = date('Y-m-d');         
                            }

	    echo "<form action='index.php' method='get'>
          		<label>Pilih Tanggal</label>
				<input type='date' name='ke' value='".$dateprd."'>
				<input type='submit' value='cari'>
            </form>";

        $date = $dateprd;
        $date1 = date_create($date);
        $date2 = date_format($date1, 'l');
        $tgl   = date_format($date1, 'd');
        $year  = date_format($date1, 'Y');
        $date3 = hariIndo($date2);
        $month = date_format($date1, 'm');
        $month2 = bulanIndo($month);

        echo "<div style='margin-top:10px;color:green;font-size:0.9rem;'>".$date3 . ", " . $tgl . " " . $month2 . " " . $year."</div>";

            																
        //echo "<div style='margin-top:10px;color:green;font-size:0.9rem;'>Tanggal ".date("d-m-Y",strtotime($dateprd))."</div>";

   	$cekqueryjmlbrgprd = mysqli_query($conn, "select count(no_invoice) as jml from transaksi_pembelian where pemasok_id=$id_user and date_grafik between '$dateprd 00:00' and '$dateprd 23:59' ");

	$rowjmlprd = mysqli_fetch_assoc($cekqueryjmlbrgprd);

	if($rowjmlprd['jml']==0){

		echo "<div style='color:orangered; width: 400px; height: 200px;margin-top:20px;' > Belum ada transaksi barang </div>";

	}else{

		echo "<div id='piechart3' style='width: 400px; height: 200px;'></div>";

	}


?>

</div>
                        <?php

                        $query3 = mysqli_query($conn, "SELECT sum(`total_harga`)as total_harga FROM `transaksi_pembelian` WHERE pemasok_id=$id_user and date_grafik BETWEEN '$dateprd 00:00' and '$dateprd 23:59'");
                        
                        $data3 = mysqli_fetch_assoc($query3);
                        $total = $data3['total_harga'];
                        $total2 = number_format($total, 2, ",", ".");                        

                        ?>
                        <p style="margin-left:30px;padding-bottom: 10px;font-size: 0.85rem;">Total Penjualan : <span style="font-weight: 700;margin-left: 30px;">Rp <?php echo $total2; ?></span> </p>
                    </div>
                </div>
                <!-- end card grafik -->

                <div class="cards">
                    <!-- Swiper -->
                    <div class="row3 swiper mySwiper">
                        <div class="swiper-wrapper">

                            <?php
                            $query2 = mysqli_query($conn, "select * from blog");
                            while ($row = mysqli_fetch_array($query2)) {
                            ?>

                                <div class="swiper-slide">
                                    <div class="segmen-artikel">
                                        <div class="post-img">
                                            <img class="img-artikel" src="../<?php echo $row['img']; ?>">
                                        </div>
                                        <div class="segmen-content-blogs">
                                            <img class="img-bg-content-blog" src="">
                                            <div class="segmen-isi-blog">
                                                <p class="judul-blog"><?php echo $row['judul']; ?></p>
                                                <p class="isi-blog"><?php echo $row['isi']; ?></p>
                                            </div>
                                            <div class="segmen-button-blog">
                                                <a href='#' class='btn-blog'>selengkapnya</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>

                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>

                </div>

            </div>

        </div>

        <div class="container">
            <div class="dashboard-wrapper">

                <div class="cards">
                    <div class="row2 card-transaksi">
                        <div class="heading-transaksi">
                            <h4>Riwayat Transaksi</h4>
                        </div>
                        <div class="content-transaksi">
                            <?php
                            $query5 = mysqli_query($conn, "select * from transaksi_pembelian where pemasok_id=$id_user ORDER BY date_grafik DESC limit 6");

                            //cek ketersediaan transaksi pembelian di pemasok
                            $cekjmltr = mysqli_num_rows($query5);
                            if ($cekjmltr == 0) {
                                echo "<div style='color:red'>Belum ada transaksi pembelian</div>";
                            } else {

                            ?>

                                <div class="ct tanggal">
                                    <?php
                                    while ($row5 = mysqli_fetch_array($query5)) {

                                        $date = $row5['date_grafik'];
                                        $date1 = date_create($date);
                                        $date2 = date_format($date1, 'l');
                                        $tgl   = date_format($date1, 'd');
                                        $year  = date_format($date1, 'Y');
                                        $date3 = hariIndo($date2);
                                        $month = date_format($date1, 'm');
                                        $month2 = bulanIndo($month);
                                    ?>
                                        <p><?php echo $date3 . ", " . $tgl . " " . $month2 . " " . $year; ?></p>
                                    <?php } ?>
                                </div>

                                <div class="ct total">
                                    <?php $query6 = mysqli_query($conn, "select * from transaksi_pembelian where pemasok_id=$id_user ORDER BY date_grafik DESC limit 6");

                                    while ($row6 = mysqli_fetch_array($query6)) {
                                    ?>
                                        <p><?php
                                            $harga = $row6['total_harga'];
                                            $harga2 = number_format($harga, 2, ",", ".");
                                            echo "Rp " . $harga2;
                                            ?></p>
                                    <?php } ?>
                                </div>

                            <?php } ?>

                        </div>
                        <div class="btn-transaksi">
                            <a href='riwayat_transaksi.php' class='btn-selengkapnya'>selengkapnya</a>
                        </div>
                    </div>

                </div>
                <div class="cards">
                    <div class="row4 card-harga">
                        <div class="heading-harga">
                            <h4>Daftar Harga</h4>
                        </div>
                        <div class="content-harga">

                            <div class="ct produk">
                                <?php
                                $query7 = mysqli_query($conn, "select * from barang limit 6");
                                while ($row7 = mysqli_fetch_array($query7)) {
                                ?>
                                    <p><?php echo $row7['nama_barang']; ?></p>
                                <?php } ?>

                            </div>

                            <div class="ct harga">
                                <?php
                                $query8 = mysqli_query($conn, "select * from barang limit 6");

                                while ($row8 = mysqli_fetch_array($query8)) {
                                ?>
                                    <p><?php
                                        $harga = $row8['harga_barang'];
                                        $harga2 = number_format($harga, 2, ",", ".");
                                        echo "Rp " . $harga2;
                                        ?></p>
                                <?php } ?>
                            </div>

                        </div>
                        <div class="btn-harga">
                            <a href='daftar_harga.php' class='btn-selengkapnya'>selengkapnya</a>
                        </div>
                    </div>
                </div>

            </div><br /><br />


        </div>

        </div>


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

        <!-- Swiper JS -->
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

        <!-- Initialize Swiper -->
        <script>
            var swiper = new Swiper(".mySwiper", {
                spaceBetween: 30,
                slidesPreview: "auto",
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                pagination: {
                    el: ".swiper-pagination",
                },
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
            });
        </script>

        <script>
            var url = 'https://wati-integration-service.clare.ai/ShopifyWidget/shopifyWidget.js?73829';
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = url;
            var options = {
                "enabled": true,
                "chatButtonSetting": {
                    "backgroundColor": "#4dc247",
                    "ctaText": "Chat Kamibox",
                    "borderRadius": "20",
                    "marginLeft": "150",
                    "marginBottom": "30",
                    "marginRight": "0",
                    "position": "left"
                },
                "brandSetting": {
                    "brandName": "Kamibox",
                    "brandSubTitle": "",
                    "brandImg": "",
                    "welcomeText": "Hai, \nAda yang bisa kami bantu?",
                    "messageText": "Saya ada pertanyaan tentang {{page_link}}",
                    "backgroundColor": "#0a5f54",
                    "ctaText": "Start Chat",
                    "borderRadius": "20",
                    "autoShow": false,
                    "phoneNumber": "6282125422121"
                }
            };
            s.onload = function() {
                CreateWhatsappChatWidget(options);
            };
            var x = document.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
        </script>



    </body>

    </html>

<?php } ?>