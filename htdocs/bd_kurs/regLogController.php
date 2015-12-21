<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname= "bd_kurs";
	$varLogin = $_GET['Login'];
	$varPassword = $_GET['Password'];
	$conn = new mysqli($servername, $username, $password, $dbname);
	$conn->query("SET CHARACTER SET 'utf8';");

	if(isset($_GET['register'])) {
		$res = $conn->query("SELECT id FROM users WHERE username='{$varLogin}'");
		if ($res->num_rows == 0) {
			if (isset($_GET['WorkerCode'])) {
				if ($_GET['WorkerCode'] == "ZX56C") {
					$conn->query("INSERT INTO users (username, password, usertype)
						VALUES ('{$varLogin}', '" . md5($varPassword) . "','" . 1 . "')");
					session_start();
					$_SESSION['username'] = $varLogin;
					$_SESSION['logged'] = true;
					$_SESSION['usertype'] = 1;
					echo 2;
				} else echo -2;
			} else {
				$conn->query("INSERT INTO users (username, password, usertype) VALUES ('{$varLogin}', '" . md5($varPassword) . "','" . 0 . "')");
				session_start();
				$_SESSION['username'] = $varLogin;
				$_SESSION['logged'] = true;
				$_SESSION['usertype'] = 0;
				echo 1;
			}
		} else echo -1;
	}

	if(isset($_GET['signin'])) {
		$res = $conn->query("SELECT usertype FROM users WHERE username='{$varLogin}'AND password='" . md5($varPassword) . "'");
		if ($res->num_rows==1) {
			$row = $res->fetch_row();
			session_start();
			$_SESSION['username']=$varLogin;
			$_SESSION['logged']=true;
			$_SESSION['usertype']=$row[0];
			$conn->query("INSERT INTO journal (username ,text) VALUES ('{$varLogin}', ' совершил вход.')");
			echo 1;
		}
		else echo -1;
	}

	if(isset($_GET['signout'])) {
		session_start();
		$conn->query("INSERT INTO journal (username ,text) VALUES ('{$_SESSION['username']}', ' совершил выход.')");
		session_destroy();
	}
?>