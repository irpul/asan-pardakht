<?php
error_reporting(0);
include '../config.php';
include_once "../include/init.php";

global $admin_user,$admin_pass;
$userpass=$_POST['password'];
$username=$_POST['username'];
if ($userpass=="" or $username=="" ){
	header("Location: index.php?err=1");
}
if ($username==$admin_user && $userpass==$admin_pass){ 
	session_start();
	session_destroy(); 
	session_start();
	$_SESSION["ASpass"] = $admin_pass; 
	$_SESSION["ASuser"] = $admin_user; 	
	header("Location: ./search.php");
} else {
	session_start();
	session_destroy(); 
	header("Location:index.php?err=1");	
}
?>