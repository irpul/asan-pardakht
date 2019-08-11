<?php

ob_start();
include '../config.php';
include_once "../include/init.php";
include './loginchk.php';
error_reporting(1);

$res=mysql_query("select * from `order` order by id desc limit 500;");
if($res && mysql_num_rows($res)>0){
	?>
	<table cellspacing="3" width="850" dir="rtl" align="center" class="search">
	<tr><th>نام و نام خانوادگی </th>
	<th>ایمیل</th>
	<th>تلفن</th>
	<th>عنوان پرداخت</th>
	<th>مبلغ (ریال)</th>
	<th>وضعیت</th>
	<th>تراکنش بانکی</th>
	<th>تاریخ</th>
	</tr>
	<?php
	while($row=mysql_fetch_assoc($res)){
		echo "<tr>";
		echo "<td>$row[name]</td>";
		echo "<td>$row[email]</td>";		
		echo "<td>$row[tel]</td>";		
		echo "<td>$row[comment]</td>";		
		echo "<td>$row[amount]</td>";		
		if($row['status']=='y'){echo "<td style='color:#009933;'><b>موفق</b></td>";}else{echo "<td style='color:#FF0000;'>ناموفق</td>";}
		echo "<td>$row[ref]</td>";				
		echo "<td>".date("Y-m-d H:i",$row['date'])."</td>";				
		echo "</tr>";		
	}
	?>
	</table>
	<?php
}else{
	echo 'سفارشی در آسان پرداز شما ثبت نشده است.';
}
$out_html = ob_get_clean();
include_once './tmpall.php';?>