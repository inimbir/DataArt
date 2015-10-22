<?
	header('Content-type: text/html; charset=utf-8');
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname= "restaurantmanagerbd";
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	$conn->query("SET CHARACTER SET 'utf8';");
	$res = $conn->query("SELECT COUNT(*) from restaurants");
	$row = $res->fetch_row();
	echo $row[0];
?>