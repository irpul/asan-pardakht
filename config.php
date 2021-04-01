<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Tehran');
header('Content-Type: text/html; charset=utf-8');

//database information
$db_host 		= 'localhost';
$db_name 		= 'asan_pardakht';//نام دیتابیس
$db_username 	= 'root';//نام کاربری دیتابیس
$db_password 	= '';//کلمه رمز دیتابیس

//admin username & password
$admin_user = 'admin';//نام کاربری بخش مدیریت
$admin_pass = 'admin';//کلمه رمز بخش مدیریت


//site url without / at end of address
$site_url   = 'http://127.0.0.1/asan-pardakht';//آدرس محل نصب بدون اسلش اخر
$token      = '';// توکن درگاه ایرپول
?>