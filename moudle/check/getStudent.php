<?php
	include "../../db/conn.php";
	$academy=trim($_POST['academy']);
	$teacher=trim($_POST['teacher']);
	
	$sql="select table_name from teacher where academy_id='$academy' and teacher_id='$teacher'";
	$res=mysqli_query($conn,$sql);	
	$row=mysqli_fetch_assoc($res);
	$table_name=$row['table_name'];

	$sql1="select * from $table_name";
	$res1=mysqli_query($conn,$sql1);	
	
	$arr=array();
	while($row1=mysqli_fetch_assoc($res1)){
		array_push($arr,$row1);
	}
	echo json_encode($arr);
?>