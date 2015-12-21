<div style="font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 22px;text-align:center;top: 50px; position: relative;">
	<?php
	session_start();
	if (isset($_SESSION['usertype'])) {
		switch ($_SESSION['usertype']) {
			case 0:
				echo "Приветствую тебя, уважаемый пользователь.";
				break;
			case 1:
				echo "Приветствую Вас, уважаемый работник.";
				break;
			case 2:
				echo "Приветствую Вас, могучий администратор.";
				break;
			default:
				break;
		}
	}
	else echo "Приветствую тебя, дорогой гость.<br>Чтобы приступить к работе просто пройдите регистрацию!<br>Или же войдите в систему, если вы уже зарегистрированы.";
	?>
	<br>
	<img src="img/logo1.png" style="height: 100px;margin-top: 100px;">
	<br><br>
	<b>HistoryBook</b> - это сайт-приложение, представляющее собой <br>собрание исторических знаний самых разных эпох и народов. <br> Иными словами элетронный исторический справочник.<br>Приятного пользования!
</div>