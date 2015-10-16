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
	$res = $conn->query("SELECT type FROM users WHERE login='{$varLogin}'AND password='" . md5($varPassword) . "'");
	if ($res->num_rows==1) {
		$row = $res->fetch_row();
		session_start();
		$_SESSION['username']=$varLogin;
		$_SESSION['logged']=true;
		$_SESSION['usertype']=$row[0];
		echo 1;
	}
	else echo -1;
	
} else {}
?>