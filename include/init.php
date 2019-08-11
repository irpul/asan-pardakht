<?php 
error_reporting(0);
date_default_timezone_set('Asia/Tehran');
$dbh=mysql_connect ("$database_Host", "$database_User", "$database_Password") or die ('خطا در اتصال به دیتابیس  ممکن است مشخصات نام کاربری و کلمه رمز را اشتباه وارد کرده باشید : ' . mysql_error());
mysql_select_db ("$database_Name") or die("خطا در دسترسی به دیتابیس ممکن است مشخصات نام کاربری یا دسترسی به دیتابیس را صحیح تنظیم نکرده باشید". mysql_error());  

//initiate mysql connection for utf8 support;
mysql_query("SET NAMES 'utf8'", $dbh);

if (!function_exists('injection')) { 
	function injection($string){
		if(is_array($string)){
			$string	=array_map("injection",$string);
			return $string;
		}	
		if(get_magic_quotes_gpc()){
			$string = stripslashes($string);
		}
		if (phpversion() >= '4.3.0'){
			$string = mysql_real_escape_string($string);
		}else{
			$string = mysql_escape_string($string);
		}
		return $string;
	}
	$_POST=array_map("injection",$_POST);
	$_GET=array_map("injection",$_GET);	
}	
?>