<?php
header('Content-Type: text/html; charset=utf-8');
include_once "./config.php";
include_once "./include/init.php";
function message_exit($message) {
	include './include/back.html';
	exit();
}

function url_decrypt($string){
	$counter = 0;
	$data = str_replace(array('-','_','.'),array('+','/','='),$string);
	$mod4 = strlen($data) % 4;
	if ($mod4) {
	$data .= substr('====', $mod4);
	}
	$decrypted = base64_decode($data);
	
	$check = array('tran_id','order_id','amount','refcode','status');
	foreach($check as $str){
		str_replace($str,'',$decrypted,$count);
		if($count > 0){
			$counter++;
		}
	}
	if($counter === 5){
		return array('data'=>$decrypted , 'status'=>true);
	}else{
		return array('data'=>'' , 'status'=>false);
	}
}

$irpul_token 	= $_GET['irpul_token'];
$decrypted 		= url_decrypt( $irpul_token );
if($decrypted['status']){
	parse_str($decrypted['data'], $ir_output);
	$tran_id 	= $ir_output['tran_id'];
	$res_num 	= $ir_output['order_id'];
	$amount 	= $ir_output['amount'];
	$refcode	= $ir_output['refcode'];
	$status 	= $ir_output['status'];
	
	if($status == 'paid')	
	{
		if (!$res_num) {
			message_exit("خطا در انجام عملیات بانکی ، شناسه سفارش موجود نمی باشد<br/><a href='$site_url'>بازگشت</a>");
		}
		if (!$tran_id) {
			message_exit("خطا در انجام عملیات بانکی ، شناسه تراکنش موجود نمی باشد<br/><a href='$site_url'>بازگشت</a>");
		}
		if (mysql_num_rows(mysql_query("SELECT * FROM `order` WHERE `ref` = '$tran_id'"))>0) 
			message_exit("این پرداخت یکبار انجام شده است و درخواست تکراری می باشد.<br/><a href='$site_url'>بازگشت</a>");
		$resalbum=mysql_query("SELECT `amount` FROM `order` where `id`='$res_num'");
		if(mysql_num_rows($resalbum)>0){
			list($price)=mysql_fetch_array($resalbum);
		}else{
			message_exit("سفارش در سایت موجود نمی باشد.<br/><a href='$site_url'>بازگشت</a>");
		}
		$parameters = array(
			'webgate_id'	=> $api_id,
			'tran_id' 		=> $tran_id,
			'amount'	 	=> $price,
		);
		try {
			$client = new SoapClient('https://irpul.ir/webservice.php?wsdl' , array('soap_version'=>'SOAP_1_2','cache_wsdl'=>WSDL_CACHE_NONE ,'encoding'=>'UTF-8'));
			$result = $client->PaymentVerification($parameters);
		}catch (Exception $e) { echo 'Error'. $e->getMessage();  }
		$res=intval($result);
		if( $res <= 0 ) {
			message_exit("خطا در عملیات بانکی پرداخت تائید نگردید.<br/><a href='$site_url'>بازگشت</a>");
		} 
		elseif ($res=='1'){
			mysql_query("update `order` set `status`='y',`ref`='$tran_id' where `id`='$res_num' limit 1");
		$msg="<p align='center'><font color='#1B7B71'><b>عملیات خرید با موفقیت به پایان رسید</b></font></p>
		مشخصات پرداخت شما:
		<br>کد پیگیری سفارش: $res_num 
		<br> مبلغ پرداختی: $price ریال 
		<br> تراکنش بانک: $tran_id  
		<br> از خرید شما متشکریم<br>";
			message_exit($msg);
		}
	}else{
		message_exit("فاکتور پرداخت نشده است <br/><a href='$site_url'>بازگشت</a>");	
	}
}


?>