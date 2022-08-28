<?php
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);
if ($mysqli->connect_error) { echo "<h1>Error Establishing database connection ...</h1>"; exit;}
mysqli_set_charset($mysqli,"utf8");

$mysqli->query("SET time_zone='+3:30'; ");

date_default_timezone_set("Asia/Tehran");

if (!function_exists('injection')) {
	function injection($string){
		global $mysqli;
		if(is_array($string)){
			$string	=array_map("injection",$string);
			return $string;
		}	
		//if(get_magic_quotes_gpc()){
			$string = stripslashes($string);
		 //}
		/*if (phpversion() >= '4.3.0'){
			$string = mysql_real_escape_string($string);
		}else{
			$string = mysql_escape_string($string);
		}*/
		$string = $mysqli->real_escape_string($string);
		return $string;
	}
	$_POST=array_map("injection",$_POST);
	$_GET=array_map("injection",$_GET);	
}

function message_exit($message) {
	include './include/back.html';
	exit();
}

function post_data($url,$params,$token) {
	ini_set('default_socket_timeout', 15);

	$headers = array(
		"Authorization: token= {$token}",
		'Content-type: application/json'
	);

	$handle = curl_init($url);
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($handle, CURLOPT_TIMEOUT, 40);
	curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($params) );
	curl_setopt($handle, CURLOPT_HTTPHEADER, $headers );

	$response = curl_exec($handle);
	//error_log('curl response1 : '. print_r($response,true));

	$msg='';
	$http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));

	$status= true;

	if ($response === false) {
		$curl_errno = curl_errno($handle);
		$curl_error = curl_error($handle);
		$msg .= "Curl error $curl_errno: $curl_error";
		$status = false;
	}

	curl_close($handle);//dont move uppder than curl_errno

	if( $http_code == 200 ){
		$msg .= "Request was successfull";
	}
	else{
		$status = false;
		if ($http_code == 400) {
			$status = true;
		}
		elseif ($http_code == 401) {
			$msg .= "Invalid access token provided";
		}
		elseif ($http_code == 502) {
			$msg .= "Bad Gateway";
		}
		elseif ($http_code >= 500) {// do not wat to DDOS server if something goes wrong
			sleep(2);
		}
	}

	$res['http_code'] 	= $http_code;
	$res['status'] 		= $status;
	$res['msg'] 		= $msg;
	$res['data'] 		= $response;

	if(!$status){
		//error_log(print_r($res,true));
	}
	return $res;
}

?>