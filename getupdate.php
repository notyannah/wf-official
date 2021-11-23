<?php
	include("connect.php");
	$id = $_GET["id"];
	$srvc = mysql_fetch_array(mysql_query("select * from appointments where id = $id"));
	echo $srvc["durationupdate"].",".$srvc["durationupdate_lat"].",".$srvc["durationupdate_lng"];
?>