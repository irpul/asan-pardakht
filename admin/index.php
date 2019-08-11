<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">	
<title>پنل مدیریت آسان پرداخت</title>
</head>
<?php
error_reporting(1);
ob_start();
session_start();
if( isset($_SESSION['ASemail'])){
		session_destroy();
}
?>
<body onload="form1.email.focus();"><div align="center"> 
                  <form name="form1" method="post" action="login.php">
                    <table border="0" cellpadding="0" cellspacing="0" style="border:1px solid #a9a9a9;border-radius:5px;">
                      <tr height="20"> 
                        <td height="20"><div align="center">
						<b>ورود مدیر</b></div></td>
                      </tr>
                      <tr> 
                        <td><table width="100%" border="0" cellspacing="5" cellpadding="3" dir="rtl">
						<tr> 
				                              <td class="small6">نام کاربري:</td>
				                              <td class="small6"><input  dir="ltr" name="username" type="text" id="username" size="15" value=""></td>
						</tr>
						<tr> 
					                         <td class="small6">کلمه رمز:</td>
							<td class="small6"><input  dir="ltr" name="password" type="password"  id="password2" size="15" value=""></td>
						</tr>
						<tr>
							<td colspan="2" class="small6"><div align="center"> 
                                  <input type="submit" name="Submit" value="ورود" style="font-family:tahoma">
		</td>
						</tr>
					</table>
					<?php if($_GET['err']==1){?>نام کاربری یا کلمه رمز اشتباه است<?php }?>
	</td></tr></table></div>
	<script>form1.username.focus();</script>
<?php
$out_html = ob_get_clean();
include_once './tmpall.php';
?>