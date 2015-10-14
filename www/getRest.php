<?php
if(isset($_POST['getName'])){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname= "restaurantmanagerbd";
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	$conn->query("SET CHARACTER SET 'utf8';");
	$res = $conn->query("SELECT name FROM restaurants WHERE id='{$_POST['id']}'");
	$row = $res->fetch_row();
	echo $row[0];
} else {}
?>