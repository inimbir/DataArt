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
	<link rel="icon" type="image/png" href="favicon.ico">
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
	<script type="text/javascript" src="js/jquery-1.11.3.js"></script>
	<script type="text/javascript" src="js/slider.js"></script>
	<script type="text/javascript" src="js/sharing.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDE0G3dQnsjvZCkTF_6KR48M6hcN-8HuBM&callback=startMap"></script>
</head>
<body>
	<div id="page-preloader"><span class="spinner"></span></div>

	<div id="map">
	    
	</div>
	<div id="fullPhoto"><img></div>
	<div id="list">
		<img id="closeList" src="img/closeList.png"></img>
		<br>
		<div id="placingTip"></div>
		<div id="newRestInfo"></div>
		<div id="RestInfo" style="word-wrap: break-word;"></div>
		<div class="container" style="margin-left:6em;">
			<div id='slider' style='background: rgba(255, 255, 255, 1);'>
				<ul>
				</ul>
			</div>
		</div>
		<?php
		if(isset($usertype)&&$usertype==1) echo '<button style="margin-top:5px;float:none;" id="addPhoto" class="signbutton" onclick="$callUpload()">Добавить фото</button>';
		if(isset($username)) echo '<div id="userLabel" style="width: 100%;text-align:center;"><input class="userLabelText" type="text" placeholder="Что вы думаете об этом ресторане?"><br></div>';
		else echo '<div id="userLabel" style="visibility: hidden;">0</div>'
		?>
		<br>
		<div id="RestReview"></div>
		<?php
		if(isset($usertype)&&$usertype==1) echo '<button style="margin-top:5px;float:none;" id="editReview" class="signbutton" onclick="editReview()">Изменить рецензию</button><button style="margin-top:5px;float:none;" id="saveReview" class="signbutton" onclick="saveReview()">Сохранить</button>';
		?>
		<div id="ShareDiv">
			<br>
			Поделиться рецензией:
			<a onclick="shareVK()"><img style="width: 35px;" src="img/share/logo_vk.png"></a>
			<a onclick="Share.facebook('URL','TITLE','IMG_PATH','DESC')"><img style="width: 35px;" src="img/share/logo_fb.png"> </a>
			<a onclick="shareTW()"><img style="width: 35px;" src="img/share/logo_tw.png"></i></a>
		</div>
	</div>

	<input style="width:0px;height:0px;" type="file" id="Upload" onChange="uploadPhoto()" accept="image/*" tabindex="-1">
</body>
</html>