<?php
	include("../connect.php");
	$lat = $_GET["lat"];
	$lng = $_GET["lng"];
	$id = $_GET["id"];
	$srvc = mysql_fetch_array(mysql_query("select a.*, b.latitude, b.longitude from appointments a left join services b on a.serviceid=b.id where a.id = $id"));
	$user = mysql_fetch_array(mysql_query("select * from clients where id = $srvc[clientid]"));
	$km = distance($srvc["latitude"], $srvc["longitude"], $user["latitude"], $user["longitude"]);
	$mins = round($km/60);
	$duration = convertToHoursMins($mins);
	mysql_query("update appointments set durationupdate = '$duration',durationupdate_lat = '$lat',durationupdate_lng = '$lng' where id=$id");
?>