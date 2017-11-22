<?php
	include "../../db/conn.php";
	$academy=trim($_POST['academy']);
	$teacher=trim($_POST['teacher']);
//	$academy=1;$teacher=1;
	$sql="select * from teacher where academy_id='$academy' and teacher_id='$teacher' ";
	$res=mysqli_query($conn,$sql);	
	$row=mysqli_fetch_assoc($res);
	$table_name=$row['table_name'];//获得所需要查询的表名
	
	
	$str="select * from $table_name where F8 like '%较差%'";
	$result=mysqli_query($conn,$str);	
	$one = mysqli_num_rows($result);//较差的人数
	
	$str="select * from $table_name where F8 like '%一般%'";
	$result=mysqli_query($conn,$str);	
	$two = mysqli_num_rows($result);	//一般的人数
	
	$str="select * from $table_name where F8 like '%优秀%'";
	$result=mysqli_query($conn,$str);	
	$three = mysqli_num_rows($result);//优秀的人数
		
	$arr=array();
	$t1=["较差",$one];
	$t2=["一般",$two];
	$t3=["优秀",$three];
	
	array_push($arr,$t1);
	array_push($arr,$t2);
	array_push($arr,$t3);

	echo json_encode($arr);
	
?>