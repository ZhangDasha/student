<?php
    include "../../db/conn.php";
    $sql=trim($_POST['sql']);
    if($sql) {
        $res=mysqli_query($conn,$sql);
        if($res){
            echo '删除成功';
        }else {
            echo '删除失败';
        }
    } else {
        echo '删除失败';
    }
?>  