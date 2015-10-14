<?
header('Content-type: text/html; charset=utf-8');
session_start();
?>
<!DOCTYPE html>
<html ng-app lang="en">
<head>
	<title>Я карта, я карта, я карта!</title>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDE0G3dQnsjvZCkTF_6KR48M6hcN-8HuBM&callback=initMap"></script>
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/register_popup.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,500italic,700,400italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="css" href="css/style.css" media="all">

</head>
<body>
<div id="popup">
	<input id="fieldLogin" type="text" placeholder="Логин" style=" margin-top: 8px;float:left; width: 100%;"><br>
	<input id="fieldPassword" type="password" placeholder="Пароль"style="margin-top: 8px; float:left; width: 100%"><br>
	<input id="fieldPasswordConfirm" type="password" placeholder="Подтвердите пароль" style="margin-top: 8px; float:left; width: 100%"><br>
	<button id="confirm" onclick="confirmReg()" style="margin-top: 8px; float:left; width: 100%"> Завершить </button>
	<a href="#" id="close_popup" style="margin-top: 8px; float:right">Отмена</a>
</div>
<div id="signup-panel">
	<img id="logo" src="img/logo.png">
	<div id="afterlogoname">#RestaurantManager</div>
	<?
	if (isset($_SESSION['username'])) {
		$file = 'logged.html';
		$file_contents = file_get_contents($file);
		$file_contents = str_replace("#username", $_SESSION['username'], $file_contents);
		echo $file_contents;
		if ($_SESSION['usertype']==1) echo '<button class="signbutton" id="addRest" tabindex="0" onclick="addRest()">Добавить</div>';
	}
	else {
		$file = 'notlogged.html';
		$file_contents = file_get_contents($file);
		echo $file_contents;
	}
	?>
</div>
<div id="map"></div>
<div id="list">
	<div id="plist" class="listElement">
		<img id="closeList" src="img/closeList.png"></img>
		<br>
		<div id="placingTip"></div>
		<div id="newRestInfo"></div>
		<div id="RestInfo"></div>
	</div>
</div>
</body>
</html>