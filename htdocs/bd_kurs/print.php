<?php
if(isset($_GET['id'])) echo "<script>var id={$_GET['id']};</script>";
?>
<html>
<head>
	<title>HistoryBook</title>
	<link rel="icon" type="image/png" href="img/logo.png">
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,500italic,700,400italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css">
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<style>
		html,body {
			height:100%;
			width:100%;
			background: #FFFFFF;
		}
	</style>
	<script>
		$( window ).load(function() {
			d = new Date();
			document.getElementById('date').innerHTML = 'Дата: ' + d.getDate() + '.' + (d.getMonth()+1) + '.' + d.getFullYear();
			switch(id) {
				case 9:
					$('#request-text').append("Тема: «В скольких исторических событиях принимала участие каждая историческая личность.»");
					break;
				case 10:
					$('#request-text').append("Тема: «В скольких боях принимала участие каждая страна.»");
					break;
				case 13:
					$('#request-text').append("Тема: «Для каждой войны определить битву в которой участвовало наибольшее число войск.»");
					break;
				case 14:
					$('#request-text').append("Тема: «Для каждой исторической личности определить первое историческое событие в котором она принимала участие.»");
					break;
				case 17:
					$('#request-text').append("Тема: «Страна принявшая участие в наибольшем/наименьшем количестве боёв.»");
					break;
				case 18:
					$('#request-text').append("Тема: «Историческая личность принимавшая участие в наибольшем/наименьшем количестве исторических событий.»");
					break;
			}
			$.ajax({
				method: 'get',
				url: 'requestsController.php?get'+id,
				success: function(data) {
					if (data==-1) document.getElementById('request-result').innerHTML = "Результатов нет.";
					else {
						var s = data.toString();
						if (id==9||id==10||id==13||id==14) s = s.substr(0, s.length - 1);
						document.getElementById('request-result').innerHTML = "<br><b>Результат:</b><br> " + s + ".";
						setTimeout('window.print()', 1000);
					}
				}
			});
		});
	</script>
</head>
<body>
	<h1 style="text-align:center;margin-top:30px;font-family: 'Roboto', sans-serif;font-weight:450; font-size: 40px;">HistoryBook<br><br>Отчёт</h1>
	<div style="text-align:center;margin-top:30px;font-family: 'Roboto', sans-serif;font-weight:500; font-size: 25px;" id="request-text"></div>
	<div style="line-height:2;text-align:center;margin-top:30px;font-family: 'Roboto', sans-serif;font-weight:450; font-size: 20px;" id="request-result"></div>
	<div style="position:absolute;bottom:20px;right: 30px;text-align:center;margin-top:30px;font-family: 'Roboto', sans-serif;font-weight:450; font-size: 20px;" id="date"></div>
</body>
</html>