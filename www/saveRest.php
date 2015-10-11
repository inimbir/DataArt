<?php
if(isset($_POST['ajax'])){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname= "restaurantmanagerbd";
	$varName = $_POST['Name'];
	$varLat = $_POST['lat'];
	$varLng = $_POST['lng'];
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	$conn->query("SET CHARACTER SET 'utf8';");
	$res = $conn->query("SELECT id FROM restaurants WHERE name='{$varName}'");
	if ($res->num_rows==0) {
		$conn->query("INSERT INTO restaurants (name, lat, lng)
					VALUES ('{$varName}', {$varLat}, {$varLng})");
		echo 1;
	}
	else echo -1;
	
} else {}
?>