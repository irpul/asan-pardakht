<?php
include_once 'config.php';
include_once './include/init.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="script" content="http://www.maker.ir"/>
	<meta name="copyright" content="Ali Karimabadi - akarimabadi@gmail.com"/>
	<title>آسان پرداز</title>
	<style media="all" type="text/css">
        <!--
        body {
            background: url(images/bg.jpg) #12a7d1 top center repeat-x;
            direction: rtl;
            padding: 40px 0px 0px 0px;
        }

        .div {
            background: url('images/pay.png') center no-repeat;
            width: 969px;
            height: 453px;
        }

        .login {
            padding: 110px 10px 0px 0px;
            font-family: Tahoma;
            font-size: 12px;
            color: #fff;
            width: 300px;
        }

        input {
            border-radius: 3px;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border: 1px solid #fff;
            background: transparent;
            font-family: Tahoma;
            font-size: 12px;
            width: 175px;
            height: 18px;
            line-height: 17px;
            color: #fff;
        }

        input[type="submit"] {
            width: 80px;
            height: 22px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: #27a5c9;
            color: #b4daff;
        }

        input[type="button"] {
            width: 80px;
            height: 22px;
            cursor: pointer;
        }

        input[type="button"]:hover {
            background: #27a5c9;
            color: #b4daff;
        }

        a {
            text-decoration: none
        }

        -->
	</style>
</head>
<body>
<div align="center">
	<div class="div" align="right">
		<div class="login">
			<form action="./order.php" method="post">
				<table width="400px" align="right" cellpadding="2" cellspacing="2">
					<tbody>
					<tr>
						<td width="150px">نام و نام خانوادگی :</td>
						<td width="250px"><input name="TxtName" type="text"></td>
					</tr>
					<tr>
						<td width="150px">ایمیل :</td>
						<td width="250px"><input name="TxtEmail" type="text"></td>
					</tr>
					<tr>
						<td width="150px">موبایل :</td>
						<td width="250px"><input name="TxtMobile" type="text"></td>
					</tr>
					<tr>
						<td width="150px">عنوان پرداخت :</td>
						<td width="250px"><input name="TxtTitle" type="text"></td>
					</tr>
					<tr>
						<td>میزان وجه پرداختی :</td>
						<td><input dir="ltr" name="TxtPrice" type="text"> ریال</td>
					</tr>
					<tr>
						<td></td>
						<td><input name="submit" value="پرداخت" type="submit">&nbsp;</td>
					</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
</div>
</body>
</html>
<p style="text-align: center;">قدرت گرفته از سامانه پرداخت الکترونیک
	<a href="https://irpul.ir" target="_blank">ایرپول</a></p>