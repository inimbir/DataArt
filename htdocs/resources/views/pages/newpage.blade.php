<html>
    <head>
        <title>Рейтинг ресторанов</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- Latest compiled and minified CSS -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
        <!-- Optional theme -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous"> -->
        <link rel="stylesheet" href="css/bootstrap.min.css" type=text/css>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" type=text/css>
        <link rel="stylesheet" href="css/newrate.css" type=text/css>
        <link rel="icon" type="image/png" href="favicon.ico">
        <!-- Latest compiled and minified JavaScript -->
        <script>
            var admin=0;
            var moveTo;
            if(window.location.hash) {
                moveTo=window.location.hash.substr(1, window.location.hash.length);
            }
            else {
                moveTo=-1;
            }
            <?php
                if(isset($usertype)) echo 'admin = ' . $usertype . ';';
            ?>
        </script>
        <script type="text/javascript" src="js/jquery-1.11.3.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/newrating.js"></script>
    </head>
    <body>
        <div id="popup-back"></div>
        <div id="popup">
            <div class="popup-buttons">
                <div class="button active-button" data-name="reg">Регистрация</div>
                <div class="clearfix"></div>
            </div>
            <div  class="content" id="reg">
                <input class="regField" id="regLogin" type="text" placeholder="Логин">
                <input class="regField" id="regPassword" type="password" placeholder="Пароль">
                <input class="regField" id="regPasswordConfirm" type="password" placeholder="Повторите пароль">
                <button class="confirm" onclick="confirmReg()"> Завершить </button>
            </div>
        </div>
           
            <div class="container-fluid header pull-left">
                    <div class="logo pull-left">
                        <img src="img/logo-rating.png" class="img-responsive">
                    </div>
                    <div class="switch pull-left">
                        <span class="active" id="mapSwitch" onclick="setMap()" style="border-right: 2px solid white;">Карта</span><span id="ratingSwitch" onclick="setRating()">Рейтинг</span>
                    </div>
                    <div class="signup">
                        <?php
                            if (isset($username)) {
                                $file = 'loggedrate.html';
                                $file_contents = file_get_contents($file);
                                $file_contents = str_replace("#username", $username, $file_contents);
                                echo $file_contents;
                                if ($usertype==1) {
				                    echo '<button class="btn btn-default" id="addRest" tabindex="0" onclick="addRest()" style="margin-top: 0.5em; float:right;">Добавить</div>';
			                     }
                            }
                            else {
                                $file = 'notloggedrate.html';
                                $file_contents = file_get_contents($file);
                                echo $file_contents;
                            }
                        ?>
                    </div>    
            </div>
        <div class="container-fluid wrap">
            <div id="mapBlock" class="container-fluid wrap">
            </div>
            <div id="ratingBlock" class="container-fluid wrap">
            </div>
        </div>
    </body>
</html>