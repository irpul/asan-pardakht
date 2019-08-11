<?php 
include_once '../config.php';
include_once "../include/init.php";
session_start();
global $admin_user,$admin_pass;
if( isset($_SESSION['ASemail']) ){
	header("Location: index.php");exit;
}else{
	if ($_SESSION["ASuser"]!=$admin_user or $_SESSION["ASpass"]!=$admin_pass){ 
	echo $admin_user;echo $admin_pass;	print_r($_SESSION);exit;
		
		session_destroy();header("Location: index.php?err=1");exit;		
	}
}
?>