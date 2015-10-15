<?php
if(isset($_POST['ajax'])){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname= "restaurantmanagerbd";
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	$conn->query("SET CHARACTER SET 'utf8';");
	$res = $conn->query("SELECT id, name, lat, lng FROM restaurants");
	$result = "";
	while ($row = $res->fetch_row()) $result = ($result . $row[0] . ',' . $row[1] . ',' . $row[2] . ',' . $row[3] . '|');
	echo substr($result, 0, -1);;
	
} else {}
?>