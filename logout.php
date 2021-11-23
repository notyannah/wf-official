<?php
	mysql_connect("localhost","root","");
	mysql_select_db("dbwefix");
	session_start();
	unset($_SESSION['id']);
	echo "<script>window.location = 'index.php?pg=main';</script>";
?>