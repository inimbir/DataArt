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
	$res = $conn->query("SELECT name, lat, lng FROM restaurants");
//	$res->num_rows==0
	$result = "";
	while ($row = $res->fetch_row()) $result = ($result . $row[0] . ',' . $row[1] . ',' . $row[2] . '|');
	echo substr($result, 0, -1);;
	
} else {}
?>