<?php
if(isset($_POST['getName'])){
	header('Content-type: text/html; charset=utf-8');
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname= "restaurantmanagerbd";
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	$conn->query("SET CHARACTER SET 'utf8';");
	$res = $conn->query("SELECT name, review FROM restaurants WHERE id='{$_POST['id']}'");
	$row = $res->fetch_row();
	$varEcho = $row[0] . '|' . $row[1];
	echo $varEcho;
} else {}
?>