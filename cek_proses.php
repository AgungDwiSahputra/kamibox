<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<?php
	?>
	<form action="cek_proses.php" method="post">
		<input type="checkbox" name="cek" value="setuju">setuju
		<input type="submit" name="submit" value="ok">
	</form>
</body>
</html>

<?php


$cek = $_POST['cek'];

if(empty($cek)){
	echo "maaf ceklist dahulu";
}else{
	echo "ok";
}

?>