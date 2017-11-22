<?php
header("Content-type:text/html;charset=utf-8");
$conn=mysqli_connect("localhost","root","root") or die("mysqli连接数据库失败");
mysqli_select_db($conn,"students") or die("未找到数据库");

//指定数据库字符集utf8
mysqli_query($conn,"set names utf8");

//设置时区为中国时区，默认为伦敦时区，差了八小时
date_default_timezone_set("PRC");

//设置锁雾报告提示，取消警告提示
error_reporting("E_ALL" & ~E_NOTICE);


 ?>