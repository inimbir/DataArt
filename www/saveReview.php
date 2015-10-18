<?php
header('Content-type: text/html; charset=utf-8');
$servername = "localhost";
$username = "root";
$password = "";
$dbname= "restaurantmanagerbd";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->query("SET CHARACTER SET 'utf8';");
$conn->query("UPDATE restaurants SET review =  '{$_POST['review']}' WHERE id='{$_POST['id']}'");
?>