<?php
// Edited By Ali Samiee - shop.kadeh@yahoo.com
include_once './config.php';
include_once './include/init.php';

	if(!is_numeric($_POST['TxtPrice'])) {
		die("مبلغ پرداختی را به ریال و فقط با اعداد وارد نمائید.");
	}
	
	$price			= intval($_POST['TxtPrice']);
	$email			= $_POST['TxtEmail'];
	$mobile			= $_POST['TxtMobile'];
	$payer_name		= $_POST['TxtName'];
	$product		= $_POST['TxtTitle'];
	$date			= time();;
	
	mysql_query("INSERT INTO `order` (`email` ,`tel` ,`name`,`comment` ,`amount` ,`status` ,`ref` ,`date`) VALUES ('{$email}', '{$mobile}','{$payer_name}','{$product}','{$price}', 'n', '','$date') ");
	echo mysql_error();
	$id=mysql_insert_id();
	if($id<=0){echo 'خطا در ایجاد سفارش .';exit;}
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" >
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	    <title>در حال اتصال ...</title>
	    <style type="text/css">
	        body{font-family:Arial;font-size:12pt;font-weight:bold;direction:rtl;color:#0079D5;}
	        .messageBox{margin:200px auto; width:300px;padding:30px; border:solid 2px #A4CFEF;background-color:#E8F5FF; text-align:center; line-height:2em;}
	    </style>
<?php
	$parameters = array
	(
		'plugin'		=> 'AsanPardakht',
		'webgate_id' 	=> $api_id,
		'order_id'		=> $id,
		'product'		=> $product,
		'payer_name'	=> $payer_name,
		'phone' 		=> '',
		'mobile' 		=> $mobile,
		'email' 		=> $email,
		'amount' 		=> $price,
		'callback_url' 	=> $site_url.'/back.php',
		'address' 		=> '',
		'description' 	=> '',
	);
	try {
		$client = new SoapClient('https://irpul.ir/webservice.php?wsdl' , array('soap_version'=>'SOAP_1_2','cache_wsdl'=>WSDL_CACHE_NONE ,'encoding'=>'UTF-8'));
		$result = $client->Payment($parameters);
	}catch (Exception $e) { echo 'Error'. $e->getMessage();  }
	
	if ($result['res_code'] === 1 && is_numeric($result['res_code'])){
		$go = $result['url'];
		header("Location: {$go}");	
	}else{
		//-- نمایش خطا
		$data[message] = '<font color="red">در ارتباط با درگاه irpul.ir مشکلی به وجود آمده است. لطفا مطمئن شوید شناسه درگاه خود را به درستی در قسمت مدیریت وارد کرده اید.</font> شماره خطا: '.$result['res_code'].'<br />';
		if($result['res_code']=='-1'){
			$data[message] .='<br> شناسه درگاه مشخص نشده است';
		}
		elseif($result['res_code']=='-2'){
			$data[message] .='<br> شناسه درگاه صحیح نمی باشد';
		}
		elseif($result['res_code']=='-3'){
			$data[message] .='<br> شما حساب کاربری خود را در ایرپول تایید نکرده اید';
		}
		elseif($result['res_code']=='-4'){
			$data[message] .='<br> مبلغ قابل پرداخت تعیین نشده است';
		}
		elseif($result['res_code']=='-5'){
			$data[message] .='<br> مبلغ قابل پرداخت صحیح نمی باشد';
		}
		elseif($result['res_code']=='-6'){
			$data[message] .='<br> شناسه تراکنش صحیح نمی باشد';
		}
		elseif($result['res_code']=='-7'){
			$data[message] .='<br> آدرس بازگشت مشخص نشده است';
		}
		elseif($result['res_code']=='-8'){
			$data[message] .='<br> آدرس بازگشت صحیح نمی باشد';
		}
		elseif($result['res_code']=='-9'){
			$data[message] .='<br> آدرس ایمیل وارد شده صحیح نمی باشد';
		}
		elseif($result['res_code']=='-10'){
			$data[message] .='<br> شماره تلفن وارد شده صحیح نمی باشد';
		}
		elseif($result['res_code']=='-12'){
			$data[message] .='<br> نام پلاگین (Plugin) مشخص نشده است';
		}
		elseif($result['res_code']=='-13'){
			$data[message] .='<br> نام پلاگین (Plugin) صحیح نیست';
		}
		else{
			$data[message] .='<br>پاسخی دریافت نشد لطفا مجدد تلاش کنید';
		}
		$code=$data['message'];
	}	

?>
	<body>
		<?php echo $code;?>
		<?php if(isset($go)){?>
			<div class="messageBox">در حال اتصال به <br />سرور پرداخت الکترونیک <br /></div>
		<?php }?>
	</body>
	</html>