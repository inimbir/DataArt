<?
header('Content-type: text/html; charset=utf-8');
session_start();
?>
<!DOCTYPE html>
<html ng-app lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
		background: url('/img/loading.gif') no-repeat;
		background-size: contain;
	}
    #slides {
      display: none;
    }

    #slides .slidesjs-navigation {
      margin-top:3px;
    }

    #slides .slidesjs-previous {
      margin-right: 5px;
      float: left;
    }

    #slides .slidesjs-next {
      margin-right: 5px;
      float: left;
    }

    .slidesjs-pagination {
      margin: 6px 0 0;
      float: right;
      list-style: none;
    }

    .slidesjs-pagination li {
      float: left;
      margin: 0 1px;
    }

    .slidesjs-pagination li a {
      display: block;
      width: 13px;
      height: 0;
      padding-top: 13px;
      background-image: url(img/pagination.png);
      background-position: 0 0;
      float: left;
      overflow: hidden;
    }

    .slidesjs-pagination li a.active,
    .slidesjs-pagination li a:hover.active {
      background-position: 0 -13px
    }

    .slidesjs-pagination li a:hover {
      background-position: 0 -26px
    }

    #slides a:link,
    #slides a:visited {
      color: #333
    }

    #slides a:hover,
    #slides a:active {
      color: #9e2020
    }

    .navbar {
      overflow: hidden
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
		<?
		if (isset($_SESSION['username'])) {
			$admin=false;
			$file = 'logged.html';
			$file_contents = file_get_contents($file);
			$file_contents = str_replace("#username", $_SESSION['username'], $file_contents);
			echo $file_contents;
			if ($_SESSION['usertype']==1) {
				echo '<button class="signbutton" id="addRest" tabindex="0" onclick="addRest()">Добавить</div>';
				$admin=true;
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
	
	<div id="list">
		<div id="plist" class="listElement">
			<img id="closeList" src="img/closeList.png"></img>
			<br>
			<div id="placingTip"></div>
			<div id="newRestInfo"></div>
			<div id="RestInfo"></div>
			<div class="container">
				<div id="slides" style="margin-top:5px;">
				</div>
			</div>
			<?
			if($admin) echo '<button style="margin-top:5px;float:none;" class="signbutton" onclick="$callUpload()">Добавить фото</button>';
			?>
		</div>
	</div>
	
	<input style="width:0px;height:0px;" type="file" id="Upload" onChange="uploadPhoto()" accept="image/*" tabindex="-1">
</body>
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script src="js/jquery.slides.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script id="gmap" async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDE0G3dQnsjvZCkTF_6KR48M6hcN-8HuBM&callback=initMap"></script>
</html>