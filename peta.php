<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Geowaste Kamibox</title>
 	<link rel="shortcut icon" type="image/png" href="assets/images/favicon.png">
 	<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/>
	<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
	
	<style>
	 	*{
		    margin: 0;
		    padding: 0;
		    box-sizing: border-box;
		    font-family: "Poppins", sans-serif;
		}

		body {
            padding: 0;
            margin: 0;
            overflow: hidden;
        }

        html, body {
            height: 100%;
            font: 10pt "Poppins", sans-serif;
         
        }
        .sidebar{
			position: fixed;
			top: 0;
			left: 0;
			bottom: 0;
			height: 100%;
			width: 300px;
			background: #08AC4D;
			padding: 6px 14px;
		}

		.sidebar .logo_content .logo{
			color: #fff;
			display: flex;
			height: 50px;
			width: 100%;
			align-items: center;
			gap: 10px;
			margin-top: 20px;
		}

		.logo_content .logo image{
			margin-right: 8px;
		}

		.logo_content .logo .logo_name{
			font-size: 20px;
			font-weight: 600;	
		}

		.sidebar #btn{
			position: absolute;
			color: #fff;
			left: 90%;
			top: 6px;
			font-size: 20px;
			height: 50px;
			width: 50px;
			text-align: center;
			line-height: 50px;
			transform: translateX(-50%);
		}

		.sidebar ul{
			margin-top: 20px;
		}

		.sidebar ul li{
			position: relative;
			height: 50px;
			width: 100%;
			margin: 0 5px;
			list-style: none;
			line-height: 50px;
		}



		.sidebar ul li a{
			color: #FFF;
			display: flex;
			align-items: center;
			text-decoration: none;
			transition: all 0.4s ease;
			border-radius: 12px;
		}

		.sidebar ul li a:hover{
			color: #08AC4D;
			background: #fff;
		}

		.sidebar ul li a i{
			height: 50px;
			min-width: 50px;
			border-radius: 12px;
			line-height: 50px;
			text-align: center;
		}


		.maps_content{
			position: absolute;
			height: 100%;
			width: calc(100% - 300px);
			left: 300px;
		}

		
		.logopict{
			width: 30px;
			height: 30px;
		}

		#mapid{
			height: 100%;
			width: 100%;
		}
		input{
		  display: none;
		}
		label{
			cursor: pointer;
		}

		
	 </style>
</head>
<body>
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

	<div class="sidebar">
		<div class="logo_content">
			<div class="logo">
				<img class="logopict" src="assets/logo.png">
				<div class="logo_name">Geo Waste Bank Sampah Kamibox</div>
			</div>
			
		</div>

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

		<ul class="nav_list_exit">
			<li><a href="index.php"><i class='bx bxs-exit' ></i> Kembali ke Kamibox</a></li>
		</ul>
	</div>

	<div class="maps_content">
		<div id="mapid"></div>
	</div>

	<script type="assets/leaflet.ajax.min.js"></script>

<script>
	var data = <?= json_encode($data) ?>;
	var dataA = <?= json_encode($data1A) ?>;
	var dataB = <?= json_encode($data1B) ?>;
	var data2 = <?= json_encode($data2) ?>;
	var data3 = <?= json_encode($data3) ?>;
	
	var map = L.map('mapid',{zoomControl: false}).setView({lat: -6.28106, lon: 106.72391 },11);

	L.control.zoom({
					    position: 'topleft'
					}).addTo(map);

	function onEachFeature(feature, layer)
	{
		layer.bindPopup("<b>Nama Gudang :</b> " + feature.properties.nama + "<br/>" +  "<b>Alamat: </b>" + feature.properties.alamat +" <br/>"+"<b>No HP: </b>" + feature.properties.no_hp+"<br/>"+"<b>Operasi : </b>"+feature.properties.jam_operasi+"<br/>" + "<a href='"+feature.properties.link+"'>Link Gmaps</a>");
	}
	function style(feature){
			return{
				weight : 2,
				opacity : 1,
				color : 'white',
				dashArray : '3',
				fillOpacity : 0.5,
				fillColor : 'green',
			}
	}
	function onEachFeatureAB(feature, layer)
		{
			layer.bindPopup("<b>Kecamatan :</b> <B>" + feature.properties.KECAMATAN+"</B><br/>"+"Wilayah Administrasi : "+ feature.properties.KOTAKAB+"<br/>"+"Provinsi : "+ feature.properties.PROV);
		}


	function onEachFeature2(feature, layer)
		{
			layer.bindPopup("<b>Nama Bank Sampah : </b>"+ feature.properties.nama_bank_sampah + "<br/>" + "<b>Wilayah Administrasi : </b>"+ feature.properties.wilayah_administrasi + "<br/>" + "<b>Kecamatan : </b>"+ feature.properties.kecamatan + "<br/>" + "<b>Nama Pengurus : </b>"+ feature.properties.nama_pengurus + "<br/>" + "<b>Nomor HP : </b>"+ feature.properties.no_hp + "<br/>" + "<a href='"+feature.properties.link+"'>Link Gmaps</a>");
		}

	function style3(feature){
			return{
				weight : 2,
				opacity : 1,
				color : 'white',
				dashArray : '3',
				fillOpacity : 0.5,
				fillColor : feature.properties.fill,
			}
		}
	function onEachFeature3(feature, layer)
		{
			layer.bindPopup("<b>Nama Kecamatan : </b>"+ feature.properties.Kecamatan + "<br/>" + "<b>Wilayah Administrasi : </b>"+ "Tangerang Selatan" + "<br/>" );
		}
	
	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			    maxZoom: 15,
			    attribution: '© OpenStreetMap'
			}).addTo(map);

	var geojson = L.geoJson(data,{
			onEachFeature : onEachFeature
		}).addTo(map);
	geojson.addLayer(L.geoJson(dataA,{
			style : style,
			onEachFeature : onEachFeatureAB
		}).addTo(map));
	geojson.addLayer(L.geoJson(dataB,{
			style : style,
			onEachFeature : onEachFeatureAB
		}).addTo(map));



	var geojson2 = L.geoJson(data2,{
			onEachFeature : onEachFeature2
		}).addTo(map);
	geojson2.addLayer(L.geoJson(data3,{
			style : style3,
			onEachFeature : onEachFeature3
		}).addTo(map));

	document.getElementById("dataid1").addEventListener("change", function(){
    	if (document.getElementById(this.id).checked == true){
			geojson.addTo(map);
			map.removeLayer(geojson2);
		} else {
			geojson.remove(map);
			map.removeLayer(geojson2);
		}
	});

	document.getElementById("dataid2").addEventListener("change", function(){
    	if (document.getElementById(this.id).checked == true){
			geojson2.addTo(map);
			map.removeLayer(geojson);
		} else {
			geojson2.remove(map);
			map.removeLayer(geojson);
		}
	});

</script>

</body>
</html>