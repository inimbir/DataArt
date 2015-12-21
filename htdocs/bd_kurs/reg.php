<!DOCTYPE html>
<html>
<head>
	<title>HistoryBook</title>
	<link rel="icon" type="image/png" href="img/logo1.png">
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,500italic,700,400italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css">
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</head>
<body>
<div id="popup" style="width:200px;height: 210px;">
	<div id="popuphead">
		Регистрация работника
	</div>
	<input class="regField" id="regLogin" type="text" placeholder=" Логин" style="margin-top: 8px;float:left;"><br>
	<input class="regField" id="regPassword" type="password" placeholder=" Пароль" style="margin-top: 8px; float:left;"><br>
	<input class="regField" id="regPasswordConfirm" type="password" placeholder=" Подтвердите пароль" style="margin-top: 8px; float:left;"><br>
	<input class="regField" id="regWorkerCode" type="text" placeholder=" Код работника" style="margin-top: 8px; float:left;"><br>
	<button class="confirm" id="confirm" onclick="confirmRegWorker()"> Завершить </button>
	<button class="confirm" id="cancel" onclick="window.location.assign('/bd_kurs')"> Назад </button>
</div>
</body>
</html>