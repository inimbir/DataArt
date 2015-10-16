<?php
if(isset($_POST['ajax'])){
	header('Content-type: text/html; charset=utf-8');
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname= "restaurantmanagerbd";
	$varLogin = $_POST['Login'];
	$varPassword = $_POST['Password'];
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	$conn->query("SET CHARACTER SET 'utf8';");
	$res = $conn->query("SELECT id FROM users WHERE login='{$varLogin}'");
	if ($res->num_rows==0) {
		$conn->query("INSERT INTO users (login, password, type)
					VALUES ('{$varLogin}', '" . md5($varPassword) . "','" . 0 . "')");
		session_start();
		$_SESSION['username']=$varLogin;
		$_SESSION['logged']=true;
		$_SESSION['usertype']=0;
		echo 1;
	}
	else echo -1;
	
} else {}
?>