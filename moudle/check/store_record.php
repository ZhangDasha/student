<?php
    include "../../db/conn.php";
	$academy=trim($_POST['academy']);
    $teacher=trim($_POST['teacher']);
    $record=trim($_POST['record']);
    $score=trim($_POST['score']);
    if($academy&&$teacher&&$record){
        $re="insert into record(academy_id,teacher_id,record,score) values('".$academy."','".$teacher."','".$record."','".$score."')";
        $result=mysqli_query($conn,$re);
        if($result){
            echo '插入成功';
        }else {
            echo '插入失败';
        }
    }
?>