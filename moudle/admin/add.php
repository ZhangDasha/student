<?php
    include "../../db/conn.php";
    $sql=trim($_POST['sql']);
    if($sql) {
        $res=mysqli_query($conn,$sql);
        if($res){
            echo '添加成功';
        }else {
            echo '添加失败';
        }
    } else {
        echo '添加失败';
    }
?>