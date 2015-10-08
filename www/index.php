<?
header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html ng-app lang="en">
<head>
	<style type="text/css">
      html, body { height: 100%; margin: 0; padding: 0; }
    </style>
    <title>Я карта, я карта, я карта!</title>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDE0G3dQnsjvZCkTF_6KR48M6hcN-8HuBM&callback=initMap"></script>
	<script type="text/javascript" src="js/main.js"></script>
</head>
<body>

		<div id="map" style="height:100%;width:70%;float:left;"></div>
		<div id="list" style="height:99%;width:30%;float:right;"><br><br><p id="plist" style="text-align:center;">Я - список ресторанов.</div>


</body>
</html>