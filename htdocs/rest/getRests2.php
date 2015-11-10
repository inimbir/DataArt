<?php
	header('Content-type: text/html; charset=utf-8');
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname= "restaurantmanagerbd";
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	$conn->query("SET CHARACTER SET 'utf8';");
	$res = $conn->query("SELECT name, review FROM restaurants WHERE id='" . $_POST['id'] . "'");
	$row = $res->fetch_row();
	$file=file_get_contents('rest-example.html');
	$file=str_replace('#NAME', $row[0], $file);
	$file=str_replace('#ID', $_POST['id'], $file);
	$file=str_replace('#REVIEW', $row[1], $file);
	echo $file;
?>