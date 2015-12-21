<?php
session_start();
if($_SESSION['usertype']>=1) echo '<script>var admin=true;</script>';
else echo '<script>var admin=false;</script>';
if(isset($_GET['id'])) echo "<script>var id={$_GET['id']};</script>";
?>
<html>
<head>
	<title>HistoryBook</title>
	<link rel="icon" type="image/png" href="img/logo.png">
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,500italic,700,400italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css">
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/request.js"></script>
	<style>
		html,body {
			background: #E0E0E0;
		}
		.backbutton {
			position: absolute;
			top: 0;
			left: 0;
			width: 80px;
			font-size: 14px;
			font-weight: 450;
			background-color:#212121;
			color:#E0E0E0;
			border-style:none;
			height: 50px;
		}

		.backbutton:hover {
			background-color:#B0BEC5;
			color:#000000;
		}

		.backbutton:active {
			background-color:#212121;
			color:#E0E0E0;
		}
		.obuttons:hover {
			background-color:#B0BEC5;
		}
		.obuttons:active {
			background-color:#212121;
			color:#E0E0E0;
		}
	</style>
</head>
<body>
	<button id="exit" class="backbutton" onclick="window.location = 'http://localhost/bd_kurs/'"><< Назад</button>
	<div id="request-text" style="text-align:center;margin-top:30px;font-family: 'Roboto', sans-serif;font-weight:450;"></div>
	<div id="request-result" style="text-align:center;margin-top:30px;font-family: 'Roboto', sans-serif;font-weight:450;"></div>
	<div style="text-align:center;" id="print"></div>
	<script>
		if (admin==true)
			if(id==9||id==10||id==13||id==14||id==17||id==18) document.getElementById('print').innerHTML='<button style="margin-top:20px;" onclick="window.open(\'print.php?id=' + id + '\')" class="obuttons">Печать</button>';
	</script>
</body>
</html>