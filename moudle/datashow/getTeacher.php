<?php
	include "../../db/conn.php";
	if(!empty($_POST['academy'])){
		$a=$_POST['academy'];
		$sql="select teacher_id,name from teacher where academy_id='$a'";
		$res=mysqli_query($conn,$sql);
		$result=[];
		while($row=mysqli_fetch_assoc($res)){	
			array_push($result,$row);
		}
		echo json_encode($result);
	}
?>