<!DOCTYPE html>
<html>
<head>
    <title>HistoryBook</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,500italic,700,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
</head>
<body>
    <div style="background:#212121; width: 100%; height: 40px;">
        <img src="img/logo.png" style="height: 35px; float:left;margin-left: 5px;margin-top: 2px;">
        <div style="font-family: 'Roboto', sans-serif;font-weight:450;float:left;margin-top: 8px;margin-left: 10px; font-size: 20px;color: #E0E0E0;">
            HistoryBook
        </div>
        <?php
        session_start();
        if (isset($_SESSION['username'])) echo '<header>
            <button style="float:right;" onclick="signOut()" id="signout" class="lbuttons">Выйти</button>
            <div style="font-family:\'Roboto\', sans-serif; float:right;font-size: 17px;margin-right: 10px;margin-top:2px;color: #E0E0E0;">Вы вошли как: <b>' . $_SESSION['username'] . '.</b></div>
        </header>';
        else echo '<header>
            <input class="rlfields" id="fieldLogin" type="text" placeholder=" Логин">
            <input class="rlfields" id="fieldPassword" type="password" placeholder=" Пароль">
            <button id="signin" class="lbuttons" onclick="signIn()">Войти</button>
            <button id="signup" class="lbuttons">Регистрация</button>
        </header>';
        ?>
    </div>

    <div id="popup" style="display: none;">
        <div id="popuphead">
            Регистрация
            <a href="#" id="close_popup" style="color: #000; float:right;text-decoration:none;">X</a>
            <a href="reg.php" style="color: #000; float:right;text-decoration:none;margin-top:-2px;margin-right: 10px;">&#128274;</a>
        </div>
        <input class="regField" id="regLogin" type="text" placeholder=" Логин" style="margin-top: 8px;float:left;"><br>
        <input class="regField" id="regPassword" type="password" placeholder=" Пароль" style="margin-top: 8px; float:left;"><br>
        <input class="regField" id="regPasswordConfirm" type="password" placeholder=" Подтвердите пароль" style="margin-top: 8px; float:left;"><br>
        <button class="confirm" id="confirm" onclick="confirmReg()"> Завершить </button>
    </div>

    <div id="menu">
        <button id="mainButton" class="menuButton" onclick="pushMenu(1)">Главная</button>
        <?php
            if (isset($_SESSION['usertype'])) echo '
            <button id="statesButton" class="menuButton" onclick="pushMenu(2)">Страны</button>
            <button id="governmentButton" class="menuButton" onclick="pushMenu(3)">Правители</button>
            <button id="personsButton" class="menuButton" onclick="pushMenu(4)">Исторические личности</button>
            <button id="eventsButton" class="menuButton" onclick="pushMenu(5)">Исторические события</button>
            <button id="battlesButton" class="menuButton" onclick="pushMenu(6)">Битвы</button>';
            if (isset($_SESSION['usertype'])&&$_SESSION['usertype']>0) echo'
            <button id="eventPartButton" class="menuButton" onclick="pushMenu(7)">Участники событий</button>
            <button id="battlePartButton" class="menuButton" onclick="pushMenu(8)">Участники битв</button>';
            if (isset($_SESSION['usertype'])) echo '
            <button class="menuButton" onclick="pushMenu(9)">Запросы</button>';
            if (isset($_SESSION['usertype'])&&$_SESSION['usertype']==2) echo '<button class="menuButton" onclick="pushMenu(10)">Журнал</button>';
        ?>
        <div id="author">Выполнил Емельянов Сергей</div>
    </div>
    <div id="content" style="overflow: scroll;overflow-x: hidden; margin-bottom: 10px;">
    </div>

</body>
</html>