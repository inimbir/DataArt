<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>#RestaurantManager</title>
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,500italic,700,400italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" media="all">
	<link rel="stylesheet" href="css/slider.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
	<style>
	#page-preloader {
		position: absolute;
		width: 100%;
		height: 100%;
		z-index: 100500;
		background: rgba(255, 255, 255, .5);
	}

	#page-preloader .spinner {
		height: 10%; 
		width: 10%; 
		position: absolute;
		left: 49%;
		top: 47%;
		background: url('img/loading.gif') no-repeat;
		background-size: contain;
	}
	</style>
</head>
<body>
	<div id="page-preloader"><span class="spinner"></span></div>
	
	<div id="popup">
		<input class="regField" id="regLogin" type="text" placeholder="Логин" style=" margin-top: 8px;float:left;"><br>
		<input class="regField" id="regPassword" type="password" placeholder="Пароль"style="margin-top: 8px; float:left;"><br>
		<input class="regField" id="regPasswordConfirm" type="password" placeholder="Подтвердите пароль" style="margin-top: 8px; float:left;"><br>
		<button id="confirm" onclick="confirmReg()"> Завершить </button>
		<a href="#" id="close_popup" style="margin-top:8px; float:right;color: #000;">Отмена</a>
	</div>
	
	<div id="signup-panel">
		<img id="logo" src="img/logo.png">
		<div id="afterlogoname">#RestaurantManager</div>
		<?php
		if (isset($username)) {
			$file = 'logged.html';
			$file_contents = file_get_contents($file);
			$file_contents = str_replace("#username", $username, $file_contents);
			echo $file_contents;
			if ($usertype==1) {
				echo '<button class="signbutton" id="addRest" tabindex="0" onclick="addRest()">Добавить</div>';
			}
		}
		else {
			$file = 'notlogged.html';
			$file_contents = file_get_contents($file);
			echo $file_contents;
		}
		?>
	</div>
	
	<div id="map"></div>
	<div id="fullPhoto"><img></div>
	<div id="list">
		<img id="closeList" src="img/closeList.png"></img>
		<br>
		<div id="placingTip"></div>
		<div id="newRestInfo"></div>
		<div id="RestInfo" style="word-wrap: break-word;"></div>
		<div class="container">
			<div id='slider' style='margin-top:5px;background: rgba(255, 255, 255, 1);'>
				<ul>
				</ul>
			</div>
		</div>
		<div>
		<a onclick="shareVK()"> <img src="img/share/logo_vk.png"></a>
		<a onclick="Share.facebook('URL','TITLE','IMG_PATH','DESC')"><img src="img/share/logo_fb.png"> </a>
		<a onclick="shareTW()"><img src="img/share/logo_tw.png"></i></a>
		</div>
		<?php
		if(isset($usertype)&&$usertype==1) echo '<button style="margin-top:5px;float:none;" id="addPhoto" class="signbutton" onclick="$callUpload()">Добавить фото</button>';
		?>
		<br>
		<div id="RestReview"></div>
		<?php
		if(isset($usertype)&&$usertype==1) echo '<button style="margin-top:5px;float:none;" id="editReview" class="signbutton" onclick="editReview()">Изменить рецензию</button><button style="margin-top:5px;float:none;" id="saveReview" class="signbutton" onclick="saveReview()">Сохранить</button>';
		?>
	</div>
	
	<input style="width:0px;height:0px;" type="file" id="Upload" onChange="uploadPhoto()" accept="image/*" tabindex="-1">
</body>
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/slider.js"></script>
	<script type="text/javascript" src="js/sharing.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script id="gmap" async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDE0G3dQnsjvZCkTF_6KR48M6hcN-8HuBM&callback=initMap"></script>
</html>