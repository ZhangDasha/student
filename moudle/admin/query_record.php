<?php
    include "../../db/conn.php";
    $sql="select * from record";
	$res=mysqli_query($conn,$sql);		
	$arr=array();
	$arr["data"]=[];
	while($row=mysqli_fetch_assoc($res)){
	    array_push($arr["data"],$row);
	}
    echo json_encode($arr);
?>