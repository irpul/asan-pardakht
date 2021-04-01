<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">	
<title>پنل مدیریت آسان پرداخت</title>
</head>
	<meta charset="utf-8" />
	<style>
	body{
			font-size:13px;
			color:000000;
			margin:0px;
			padding:0px;
			font-family:tahoma;
			background: url(../images/bg.jpg) #12a7d1 top center repeat-x ;	
			direction: rtl ;
		}

        td{
			font-size:13px;
			color:000000;
			margin:0px;
			padding:0px;
			font-family:tahoma;
		}
		.search td{
			padding:2px;
			background:#f3f3f3;
			color:#000000;
			border:1px solid #c9c9c9;
		}
		.search th{
			padding:2px;
			background:#B7D8D9;
			color:#000000;
			border:1px solid #c9c9c9;
			font-size:13px;
		}		
		a{text-decoration:none;}
	</style>
</head>
<body>
<div style="margin:auto;width:900px;background:#D3E1E1;border:#b4b4b4 1px solid;border-radius:5px;text-align:right;font-size:18pt;padding:10px;margin-top:10px">
آسان پرداز  <span style="margin:5px;font-size:12px;direction:rtl"><a target="_blank" href="https://irpul.ir/panel/login.php" dir="rtl">  [پنل کاربری ایرپول]  </a>

<?php if(isset($_SESSION['ASemail'])) {?><span style="margin:5px;font-size:12px;direction:rtl"><a href="logout.php" dir="rtl">  [خروج]  </a><?php } ?>
</div>
<div style="margin:auto;width:900px;background: #fff;border:#b4b4b4 1px solid;border-radius:5px;text-align:right;font-size:18pt;padding:10px;margin-top:10px">
<?php echo $out_html;?>
<br>
</div><br>
</body>
</html>