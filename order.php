<?php
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

	$mysqli->query("INSERT INTO `order` (`email` ,`tel` ,`name`,`comment` ,`amount` ,`status` ,`ref` ,`date`) VALUES ('{$email}', '{$mobile}','{$payer_name}','{$product}','{$price}', 'n', '','$date') ");
	$id	= $mysqli->insert_id;

	if($id<=0){
		echo 'خطا در ایجاد سفارش .';exit;
	}
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
	$parameters = array(
		//'plugin'		=> 'AsanPardakht',
		//'webgate_id' 	=> $api_id,
		'method'		=> 'payment',
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
		'test_mode' 	=> false,
	);

	$result 	= post_data('https://irpul.ir/ws.php', $parameters, $token );

	if( isset($result['http_code']) ){
		$data =  json_decode($result['data'],true);

		if( isset($data['code']) && $data['code'] === 1){
			header("Location: " . $data['url']);
			exit;
		}
		else{
			$data[message] = '<font color="red">در ارتباط با درگاه irpul.ir مشکلی به وجود آمده است. لطفا مطمئن شوید شناسه درگاه خود را به درستی در قسمت مدیریت وارد کرده اید.</font> شماره خطا: '.$data['code'].'<br /> متن خطا ' . $data['status'] ;
		}
	}else{
		$data[message] = 'پاسخی از سرویس دهنده دریافت نشد. لطفا دوباره تلاش نمائید';
	}

	$code=$data['message'];
?>
	<body>
		<?php echo $code;?>
		<?php if(isset($go)){?>
			<div class="messageBox">در حال اتصال به <br />سرور پرداخت الکترونیک <br /></div>
		<?php }?>
	</body>
	</html>