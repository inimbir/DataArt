<?php
if(isset($_POST['ajax'])){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname= "restaurantmanagerbd";
	$varLogin = $_POST['Login'];
	$varPassword = $_POST['Password'];
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	$conn->query("SET CHARACTER SET 'utf8';");
	$res = $conn->query("SELECT id FROM users WHERE login='{$varLogin}'AND password='" . md5($varPassword) . "'");
	if ($res->num_rows==1) {
		session_start();
		$_SESSION['username']=$varLogin;
		$_SESSION['logged']=true;
		$_SESSION['usertype']=0;
		echo 1;
	}
	else echo -1;
	
} else {}
?>