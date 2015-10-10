<?
header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html ng-app lang="en">
<head>
    <title>Форма регистрации</title>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
</head>
<body>
	<input id="fieldLogin" type="text" placeholder="Логин"><br>
	<input id="fieldPassword" type="password" placeholder="Пароль"><br>
	<input id="fieldPasswordConfirm" type="password" placeholder="Подтвердите пароль"><br>
	<button id="confirm" onclick="confirmReg()"> Завершить </button>
</body>
</html>