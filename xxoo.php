<?php 

	session_start();$_SESSION["ADMIN_ID"]=1;
	$url = "http://". $_SERVER['HTTP_HOST']."/Admin/Index/index";
	header("location:$url");

?>