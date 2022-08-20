<?php error_reporting(0); ?>
<?php
include 'unset_validasi.php';
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Kamibox | 2022</title>
	<link rel="shortcut icon" type="image/png" href="assets/images/favicon.png">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<!-- menu toggle icon -->
	<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
	<!-- Link Swiper's CSS -->
	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
	<!-- Link Font Awesome's CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="https://unpkg.com/aos@next/dist/aos.css">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
	<link rel="stylesheet" href="assets/css/L.Control.SlideMenu.css" />
	<style type="text/css">
		body {
			background: url(assets/images/bg-landingpage.png) no-repeat;
			background-size: cover;
		}

		.footer {
			background: url(assets/images/bgfooter.png);
			margin-top: 0px;
		}

		#mapid {
			height: 400px;
			width: 1000px;
			margin-left: 10%;
			margin-right: 10%;
			margin-top: 10px;
			transition: all 0.4s ease;
		}

		.leaflet-menu {
			position: absolute;
			background-color: white;
			overflow: auto;
			cursor: default;
			z-index: 9999;
			box-shadow: #222 -1px -1px 20px 0px;
		}

		.header {
			font-size: 20px;
			font-weight: 700;
			color: #000;
		}

		.content ul {
			margin-top: 20px;
		}

		.content ul li {
			position: relative;
			height: 50px;
			width: 100%;
			margin: 0 5px;
			list-style: none;
			line-height: 50px;
		}

		.content ul li a {
			color: #08AC4D;
			display: flex;
			align-items: center;
			text-decoration: none;
			transition: all 0.4s ease;
			border-radius: 12px;
		}

		.content ul li a:hover {
			color: #fff;
			background: #08AC4D;
		}

		.content ul li i {
			height: 50px;
			min-width: 50px;
			border-radius: 12px;
			line-height: 50px;
			text-align: center;
		}

		input {
			display: none;
		}

		label {
			cursor: pointer;
		}

		@media screen and (max-width: 850px) {
			body {
				background: white;
			}
		}

		@media screen and (max-width: 850px) {
			#mapid {
				height: 350px;
				width: 100%;
				margin: 0;
				margin-top: 10px;
			}
		}

		@media screen and (max-width: 768px) {
			#mapid {
				height: 350px;
				width: 100%;
				margin: 0;
				margin-top: 10px;
			}

		}

		@media screen and (max-width: 480px) {
			#mapid {
				height: 250px;
				width: 100%;
				margin: 0;
				margin-top: 10px;
			}
		}

		@media screen and (max-width: 400px) {
			#mapid {
				width: 100%;
				margin: 0;
				height: 250px;
				margin-top: 10px;
			}

			.container.peta-wrapper {
				margin-top: 160px;
			}
		}
	</style>
</head>

<body>
	<header>
		<?php include 'navbar.php'; ?>
	</header>

	<!-- home-->
	<section class="home">
		<div class="container home-wrapper ">
			<div class="content-left" data-aos="fade-right">
				<h2 class="heading">Daur Ulang Semua <p>Jenis <span style="color:#069B45">Sampah</span></p>
				</h2>
				<p class="subheading"><span style="color: lightslategrey;"><span style="color:orangered;">Solusi</span> Sampah Bertanggung Jawab</span></p>
				<p class="gabung"><a href="daftar.php" class="btn-gabung">Gabung</a></p>
			</div>
			<div class="content-right" data-aos="fade-left">
				<div class="img-wrapper ">
					<img src="assets/images/design-1b.png">
				</div>
			</div>
		</div>
	</section>

	<!-- layanan-->
	<section class="layanan">
		<div class="container layanan-wrapper">
			<div class="row1">
				<!--LAYANAN KAMIBOX-->
				<h3 class="heading1">Layanan Kamibox</h3>
				<p class="heading2"><img src="assets/images/Icon/garis.png"></p>
			</div>

			<div class="row2">
				<!--swiper-->
				<div class="swiper mySwiperLayanan">
					<div class="swiper-wrapper">
						<!--swiper slide-->

						<div class="swiper-slide box-layanan">
							<img class="img-box-lyn" src="assets/images/Icon/iconL1.png">
							<h3 class="judul-lyn">Penerimaan Sampah Daur Ulang</h3>
							<div class="btn-layanan">
								<p class="sub-btn">Kamibox menyediakan layanan penerimaan dan penjemputan sampah</p>
								<p><a class="btn-slkp" href="layanan.php#1">Selengkapnya<i class='bx bx-right-arrow-alt'></i></a></p>
							</div>
						</div>
						<div class="swiper-slide box-layanan">
							<img class="img-box-lyn" src="assets/images/Icon/iconL2.png">
							<h3 class="judul-lyn">Pemusnahan Arsip</h3>
							<div class="btn-layanan">
								<p class="sub-btn">Pemusnahan arsip diperuntukkan untuk menjaga kerahasiaan data perusahaan</p>
								<p><a class="btn-slkp" href="layanan.php#2">Selengkapnya<i class='bx bx-right-arrow-alt'></i></a></p>
							</div>
						</div>
						<div class="swiper-slide box-layanan">
							<img class="img-box-lyn" src="assets/images/Icon/iconL3.png">
							<h3 class="judul-lyn">Kemitraan Bank Sampah</h3>
							<div class="btn-layanan">
								<p class="sub-btn">Kami memiliki layanan kemitraan dengan Bank Sampah untuk bisa melakukan penjualan sampah ke Kamibox</p>
								<p><a class="btn-slkp" href="layanan.php#3">Selengkapnya<i class='bx bx-right-arrow-alt'></i></a></p>
							</div>
						</div>
						<div class="swiper-slide box-layanan">
							<img class="img-box-lyn" src="assets/images/Icon/iconL4.png">
							<h3 class="judul-lyn">Extended Producer Responsibility</h3>
							<div class="btn-layanan">
								<p class="sub-btn">Produsen dapat bertanggung jawab dengan produk kemasan yang dihasilkan Kamibox</p>
								<p><a class="btn-slkp" href="layanan.php#4">Selengkapnya<i class='bx bx-right-arrow-alt'></i></a></p>
							</div>
						</div>
						<div class="swiper-slide box-layanan">
							<img src="assets/images/Icon/iconL5.png" class="img-box-lyn">
							<h3 class="judul-lyn">Zero Waste to Landfill</h3>
							<div class="btn-layanan">
								<p class="sub-btn">Pengelolaan sampah secara bertanggung jawab agar tidak dibuang ke TPA</p>
								<p><a class="btn-slkp" href="layanan.php#5">Selengkapnya<i class='bx bx-right-arrow-alt'></i></a></p>
							</div>
						</div>

						<!--swiper slide end-->

					</div>
					<!--swiper wrapper end-->
					<div class="swiper-pagination"></div>
				</div>
				<!--swiper end-->

			</div>
		</div>
	</section>


	<!-- produk-->
	<section class="produk">
		<div class="container produk-wrapper">
			<div class="row1">
				<h2 class="heading-produk">Jenis Sampah Daur Ulang</h2>
				<div class="toggle-slider" style="margin:50px;">
					<i class="bx bxs-chevron-left-circle" style="color:#FFF;text-shadow: 2px 2px lightslategrey;"></i>
					<i class="bx bxs-chevron-right-circle" style="color:#FFF;text-shadow: 2px 2px lightslategrey;"></i>
				</div>
			</div>

			<div class="row2">
				<!--swiper-->
				<div class="swiper mySwiperProduk">
					<div class="swiper-wrapper">
						<!--swiper slide-->
						<div class="swiper-slide card-produk">
							<img src="assets/images/Icon/produk-arsip.png">
							<p class="nama-produk">Kertas</p>
							<div><a href="https://api.whatsapp.com/send?phone=6282125422121&text=Berapa%20harga%20produk%20daur%20ulang%20jenis%20Kertas%20saat%20ini?" class="btn-produk">cek harga</a></div>
						</div>
						<div class="swiper-slide card-produk">
							<img src="assets/images/Icon/produk-plastik.png">
							<p class="nama-produk">Plastik</p>
							<div><a href="https://api.whatsapp.com/send?phone=6282125422121&text=Berapa%20harga%20produk%20daur%20ulang%20jenis%20Plastik%20saat%20ini?" class="btn-produk">cek harga</a></div>
						</div>
						<div class="swiper-slide card-produk">
							<img src="assets/images/Icon/produk-logam.png">
							<p class="nama-produk">Logam</p>
							<div><a href="https://api.whatsapp.com/send?phone=6282125422121&text=Berapa%20harga%20produk%20daur%20ulang%20jenis%20Logam%20saat%20ini?" class="btn-produk">cek harga</a></div>
						</div>
						<div class="swiper-slide card-produk">
							<img src="assets/images/Icon/produk-kaca.png">
							<p class="nama-produk">Kaca</p>
							<div><a href="https://api.whatsapp.com/send?phone=6282125422121&text=Berapa%20harga%20daur%20ulang%20jenis%20Kaca%20saat%20ini?" class="btn-produk">cek harga</a></div>
						</div>
						<div class="swiper-slide card-produk">
							<img src="assets/images/Icon/produk-minyak.png">
							<p class="nama-produk">Minyak Jelantah</p>
							<div><a href="https://api.whatsapp.com/send?phone=6282125422121&text=Berapa%20harga%20daur%20ulang%20jenis%20Minyak%20Jelantah%20saat%20ini?" class="btn-produk">cek harga</a></div>
						</div>
						<!--swiper slide end-->

					</div>
				</div>
				<!--swiper end-->
			</div>
		</div>
	</section>


	<!-- Report Sampah terkelola-->
	<section class="report">
		<div class="container report-wrapper">
			<div class="bg-report">
				<div class="report-kb-left">
					<div class="img-report-kamibox">
						<img src="assets/images/design-2.png">
					</div>
				</div>

				<div class="report-kb-right">
					<h2 class="heading-report">Pengguna Kamibox</h2>
					<div class="content-report">
						<div class="segmen">
							<p class="heading-ct-report" style="text-shadow: 2px 2px lightyellow;">Jumlah Pengguna</p>
							<p class="subheading-ct-report">3490</p>
						</div>
						<img class="garis-tr" src="assets/images/Icon/garis2.png">
						<div class="segmen">
							<p class="heading-ct-report" style="text-shadow: 2px 2px lightyellow;">Sampah Terkelola</p>
							<p class="subheading-ct-report" style="text-shadow: 2px 2px lightyellow;">290 <span class="kg">kg</span></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<!-- Testimoni-->
	<section class="testimoni">
		<div class="container testi-wrapper">

			<div class="testi-left">
				<h2 class="heading-testi">Testimoni</h2>
				<p class="subheading-testi">Pengalaman customer mengenai Kamibox</p>
			</div>
			<div class="testi-right">
				<!--swiper-->
				<div class="swiper mySwiperTesti">
					<div class="swiper-wrapper">
						<!--swiper slide-->
						<div class="swiper-slide card-testi">
							<img class="ft-ctm2" src="assets/images/Icon/testi2.png">
							<div class="text-testi">
								<div class="testi"><i class="bx bxs-quote-left"></i></div>
								<p class="isi-testi">Saya merasa sangat terbantu dengan adanya Kamibox. Kita dapat dengan mudah mengelola sampah tanpa repot.</p>
								<div class="testi"><i class="bx bxs-quote-right"></i></div>
							</div>
							<p class="user-testi">Kartini</p>
							<p class="status-user-testi" style="margin-bottom: 20px;">Ibu Rumah Tangga</p>
							<p><a href="" style="color:#09CC6E;background: #FFF;padding:10px 15px;font-size: 0.7rem;font-weight: 600;border-radius: 20px;">selengkapnya</a></p>
						</div>
						<!--swiper slide-->
						<div class="swiper-slide card-testi">
							<img class="ft-ctm2" src="assets/images/Icon/testi1.png">
							<div class="text-testi">
								<div class="testi"><i class="bx bxs-quote-left"></i></div>
								<p class="isi-testi">Kamibox terbaik dalam pelayanannya. Saya merasa puas! Sampah di rumah bisa menghasilkan uang.</p>
								<div class="testi"><i class="bx bxs-quote-right"></i></div>
							</div>
							<p class="user-testi">Herman</p>
							<p class="status-user-testi" style="margin-bottom:20px;">Karyawan</p>
							<p><a href="" style="color:#09CC6E;background: #FFF;padding:10px 15px;font-size: 0.7rem;font-weight: 600;border-radius: 20px;">selengkapnya</a></p>
						</div>
						<!--swiper slide end-->
					</div>
					<div class="swiper-pagination"></div>
				</div>
				<!--swiper end-->
			</div>
		</div>
	</section>

	<!-- MAPS-->
	<?php

	$filename = "assets/maps/titikgudangkamibox.geojson";
	$file = file_get_contents($filename);
	$file = json_decode($file);
	$features = $file->features;
	$data = $features;

	$filename1A = "assets/maps/cisauk.geojson";
	$file1A = file_get_contents($filename1A);
	$file1A = json_decode($file1A);
	$features1A = $file1A->features;
	$data1A = $features1A;

	$filename1B = "assets/maps/kembangan.geojson";
	$file1B = file_get_contents($filename1B);
	$file1B = json_decode($file1B);
	$features1B = $file1B->features;
	$data1B = $features1B;

	$filename2 = "assets/maps/titikbanksampah.geojson";
	$file2 = file_get_contents($filename2);
	$file2 = json_decode($file2);
	$features2 = $file2->features;
	$data2 = $features2;

	$filename3 = "assets/maps/kecamatantangsel.geojson";
	$file3 = file_get_contents($filename3);
	$file3 = json_decode($file3);
	$features3 = $file3->features;
	$data3 = $features3;
	?>

	<section class="peta">
		<div class="container peta-wrapper">
			<div class="heading-lokasikmb">
				<h2 class="heading-lokasi">Lokasi Kamibox</h2>
			</div>
			<div class="peta-kamibox">

				<div id="mapid"></div>

			</div>
			<p style="text-align:center;padding: 2px 4px;"><a href="peta.php" style="color:white"><i class='bx bx-chevrons-right'></i>Lihat peta secara penuh</a></p>
		</div>
	</section>

	<!-- footer-->
	<section class="footer">
		<div class="containfooter footer-wrapper">
			<div class="contact-footer">
				<div class="left-footer">
					<p class="heading-left-footer">Contact Us</p>
					<p class="subheading-left-footer"><a style="color: white;" href="https://api.whatsapp.com/send?phone=6282125422121"><i class="fa fa-whatsapp" class="icon-sosmed"></i>Whatsapp</a></p>
					<p class="subheading-left-footer"><a style="color: white;" href="https://t.me/62811808508/"><i class="fa fa-telegram" class="icon-sosmed"></i>Telegram</a></p>
					<p class="subheading-left-footer"><a style="color: white;" href="https://www.instagram.com/kamibox.id/"><i class="fa fa-instagram" class="icon-sosmed"></i>Instagram</a></p>
					<p class="heading-left-footer" style="margin-top:30px"><a style="color: white;" href="tentang.php">About Us</a></p>
				</div>
				<div class="right-footer">
					<div class="img-logo-kamibox-putih">
						<p class="im-log"><img src="assets/images/LogoKamiboxPutih.png"></p>
					</div>
				</div>
			</div>
		</div>
	</section>


	<!-- lisensi decreativeart-->
	<footer>
		<div class="heading-footer">
			<p id="heading" style="font-family: var(--main-font2);">Copyright <span class="subheading-footer">Kamibox.id</span> | This website is made by <span class="subheading-footer">Team De Creative Agency</span></p>
		</div>
	</footer>






	<script src="assets/js/jquery3.6.0.min.js"></script>
	<script src="assets/js/main.js"></script>

	<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
	<script>
		AOS.init();
	</script>

	<!-- Swiper JS -->
	<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
	<script type="text/javascript">
		var swiper = new Swiper(".mySwiperLayanan", {
			grabCursor: true,
			centeredSlides: false,
			spaceBetween: 20,
			slidesPerView: "auto",
			coverflowEffect: {
				rotate: 0,
				stretch: 0,
				depth: 0,
				modifier: 1,
				slideShadows: true,
			},
			pagination: {
				el: ".swiper-pagination",
				clickable: true,
			},

			autoplay: {
				delay: 2100,
				disableOnInteraction: false,
			},
		});

		var swiper = new Swiper(".mySwiperProduk", {
			grabCursor: true,
			centeredSlides: false,
			spaceBetween: 20,
			slidesPerView: "auto",
			coverflowEffect: {
				rotate: 0,
				stretch: 0,
				depth: 0,
				modifier: 1,
				slideShadows: true,
			},
			navigation: {
				nextEl: ".bxs-chevron-right-circle",
				prevEl: ".bxs-chevron-left-circle",
			},
			autoplay: {
				delay: 2000,
				disableOnInteraction: false,
			},
		});

		var swiper = new Swiper(".mySwiperTesti", {
			grabCursor: true,
			centeredSlides: false,
			spaceBetween: 20,
			slidesPerView: "auto",
			coverflowEffect: {
				rotate: 0,
				stretch: 0,
				depth: 0,
				modifier: 1,
				slideShadows: true,
			},

			pagination: {
				el: ".swiper-pagination",
				clickable: true,
			},
			autoplay: {
				delay: 2500,
				disableOnInteraction: false,
			},
		});
	</script>

	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

	<script src="assets/js/L.Control.SlideMenu2.js"></script>


	<script type="text/javascript">
		var data = <?= json_encode($data) ?>;
		var dataA = <?= json_encode($data1A) ?>;
		var dataB = <?= json_encode($data1B) ?>;
		var data2 = <?= json_encode($data2) ?>;
		var data3 = <?= json_encode($data3) ?>;

		var map = L.map('mapid', {
			zoomControl: false
		}).setView({
			lat: -6.2810,
			lon: 106.7239
		}, 11);

		L.control.zoom({
			position: 'topright'
		}).addTo(map);

		function onEachFeature(feature, layer) {
			layer.bindPopup("<b>Nama Gudang :</b> " + feature.properties.nama + "<br/>" + "<b>Alamat: </b>" + feature.properties.alamat + " <br/>" + "<b>No HP: </b>" + feature.properties.no_hp + "<br/>" + "<b>Operasi : </b>" + feature.properties.jam_operasi + "<br/>" + "<a href='" + feature.properties.link + "'>Link Gmaps</a>");
		}

		function style(feature) {
			return {
				weight: 2,
				opacity: 1,
				color: 'white',
				dashArray: '3',
				fillOpacity: 0.5,
				fillColor: 'green',
			}
		}

		function onEachFeatureAB(feature, layer) {
			layer.bindPopup("<b>Kecamatan :</b> <B>" + feature.properties.KECAMATAN + "</B><br/>" + "Wilayah Administrasi : " + feature.properties.KOTAKAB + "<br/>" + "Provinsi : " + feature.properties.PROV);
		}


		function onEachFeature2(feature, layer) {
			layer.bindPopup("<b>Nama Bank Sampah : </b>" + feature.properties.nama_bank_sampah + "<br/>" + "<b>Wilayah Administrasi : </b>" + feature.properties.wilayah_administrasi + "<br/>" + "<b>Kecamatan : </b>" + feature.properties.kecamatan + "<br/>" + "<b>Nama Pengurus : </b>" + feature.properties.nama_pengurus + "<br/>" + "<b>Nomor HP : </b>" + feature.properties.no_hp + "<br/>" + "<a href='" + feature.properties.link + "'>Link Gmaps</a>");
		}

		function style3(feature) {
			return {
				weight: 2,
				opacity: 1,
				color: 'white',
				dashArray: '3',
				fillOpacity: 0.5,
				fillColor: feature.properties.fill,
			}
		}

		function onEachFeature3(feature, layer) {
			layer.bindPopup("<b>Nama Kecamatan : </b>" + feature.properties.Kecamatan + "<br/>" + "<b>Wilayah Administrasi : </b>" + "Tangerang Selatan" + "<br/>");
		}

		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 15,
			attribution: '© OpenStreetMap'
		}).addTo(map);

		var geojson = L.geoJson(data, {
			onEachFeature: onEachFeature
		}).addTo(map);
		geojson.addLayer(L.geoJson(dataA, {
			style: style,
			onEachFeature: onEachFeatureAB
		}).addTo(map));
		geojson.addLayer(L.geoJson(dataB, {
			style: style,
			onEachFeature: onEachFeatureAB
		}).addTo(map));



		var geojson2 = L.geoJson(data2, {
			onEachFeature: onEachFeature2
		}).addTo(map);
		geojson2.addLayer(L.geoJson(data3, {
			style: style3,
			onEachFeature: onEachFeature3
		}).addTo(map));


		document.getElementById("dataid1").addEventListener("change", function() {
			if (document.getElementById(this.id).checked == true) {
				geojson.addTo(map);
				map.removeLayer(geojson2);
			} else {
				geojson.remove(map);
				map.removeLayer(geojson2);
			}
		});

		document.getElementById("dataid2").addEventListener("change", function() {
			if (document.getElementById(this.id).checked == true) {
				geojson2.addTo(map);
				map.removeLayer(geojson);
			} else {
				geojson2.remove(map);
				map.removeLayer(geojson);
			}
		});


		const left = '<div class="header">Geo Waste Kamibox</div>';
		let contents = `
            <div class="content">

	            <ul class="nav_list">
							<li>
								<a href="#">
									<input type="radio" name="lok" id="dataid1" >
									<label for="dataid1">
										<i class='bx bxs-map'></i>
										<span class="links_name">Layer Gudang Kamibox</span>
									</label>
								</a>

							</li>
							<li>
								<a href="#">
									<input type="radio" name="lok" id="dataid2">
									<label for="dataid2">
										<i class='bx bxs-map'></i>
										<span class="links_name">Layer Bank Sampah</span>
									</label>
								</a>

							</li>
						</ul>
      
            </div>
           `;

		/* left */
		L.control.slideMenu(left + contents).addTo(map);
	</script>



</body>

</html>