﻿<?php
header('Content-Type: text/html; charset=utf-8');
include_once "./config.php";
include_once "./include/init.php";

if( isset($_GET['irpul_token']) ){
	if( isset($_POST['trans_id']) && isset($_POST['order_id']) && isset($_POST['amount']) && isset($_POST['refcode']) && isset($_POST['status']) ){
		$trans_id 	= $_POST['trans_id'];
		$order_id 	= $_POST['order_id'];
		$amount 	= $_POST['amount'];
		$refcode	= $_POST['refcode'];
		$status 	= $_POST['status'];

		if($status == 'paid'){
			if (!$order_id){
				message_exit("خطا در انجام عملیات بانکی ، شناسه سفارش موجود نمی باشد<br/><a href='$site_url'>بازگشت</a>");
			}

			if (!$trans_id) {
				message_exit("خطا در انجام عملیات بانکی ، شناسه تراکنش موجود نمی باشد<br/><a href='$site_url'>بازگشت</a>");
			}

			$check_row = $mysqli->query("SELECT * FROM `order` WHERE `ref` = '$refcode'")->fetch_assoc();
			if(isset($check_row['id']) ){
				message_exit("این پرداخت یکبار انجام شده است و درخواست تکراری می باشد.<br/><a href='$site_url'>بازگشت</a>");
			}

			$check_row2 = $mysqli->query("SELECT * FROM `order` WHERE `id` = '$order_id'")->fetch_assoc();
			if( !isset($check_row2['id']) ){
				message_exit("شماره سفارش در دیتابیس یافت نشد<br/><a href='$site_url'>بازگشت</a>");
			}
			else{
				$amount = $check_row2['amount'];
				$parameters = array(
					'method' 		=> 'verify',
					'trans_id' 		=> $trans_id,
					'amount'	 	=> $amount,
				);

				$result =  post_data('https://irpul.ir/ws.php', $parameters, $token );
				if( isset($result['http_code']) ){
					$data =  json_decode($result['data'],true);

					if( isset($data['code']) && $data['code'] === 1){
						$irpul_amount  = $data['amount'];

						if($amount == $irpul_amount){
							//paid
							$mysqli->query("update `order` set `status`='y',`ref`='$refcode' where `id`='$order_id' limit 1");

							$msg="<p align='center'><font color='#1B7B71'><b>عملیات خرید با موفقیت به پایان رسید</b></font></p>
							مشخصات پرداخت شما:
							<br>شماره سفارش: $order_id
							<br> مبلغ پرداختی: $amount ریال
							<br> شناسه تراکنش: $trans_id
							<br> شماره پیگیری: $refcode
							<br> از خرید شما متشکریم<br>";

							message_exit($msg);
						}
						else{
							message_exit('مبلغ تراکنش در ایرپول (' . number_format($irpul_amount) . ' تومان) تومان با مبلغ تراکنش در سیمانت (' . number_format($amount) . ' تومان) برابر نیست');
						}
					}
					else{
						message_exit("'خطا در پرداخت. کد خط: " . $data['code'] . '<br/> ' . $data['status'] ."<br/><a href='$site_url'>بازگشت</a>");
					}
				}else{
					message_exit("پاسخی از سرویس دهنده دریافت نشد. لطفا دوباره تلاش نمائید.<br/><a href='$site_url'>بازگشت</a>");
				}
			}
		}else{
			message_exit("فاکتور پرداخت نشده است <br/><a href='$site_url'>بازگشت</a>");
		}
	}
	else{
		message_exit("undefined callback parameters");
	}

}else{
	echo 'درخواست نامشخص';
}


?>