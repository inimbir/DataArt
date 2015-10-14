<?php
if(isset($_POST['ajax'])){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname= "restaurantmanagerbd";
	$varID=$_POST['id'];
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	$conn->query("SET CHARACTER SET 'utf8';");
	$res = $conn->query("SELECT filename FROM photos WHERE idR={$varID}");
	$result = "";
	while ($row = $res->fetch_row()) $result = ($result . $row[0] . '|');
	echo substr($result, 0, -1);;
	
} else {}
?>