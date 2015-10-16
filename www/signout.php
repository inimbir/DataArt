<?php
if(isset($_POST['ajax'])){
	header('Content-type: text/html; charset=utf-8');
	session_start();
	session_unset();
} else {}
?>