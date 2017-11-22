<?php
    include "../../db/conn.php";
    $sql=trim($_POST['sql']);
    if($sql) {
        $res=mysqli_query($conn,$sql);
        if($res){
            echo '更新成功';
        }else {
            echo '更新失败';
        }
    } else {
        echo '更新失败';
    }
?>