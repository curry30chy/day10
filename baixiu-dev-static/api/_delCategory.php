<?php
    include_once "../config.php";
    include_once "../function.php";

    $id=$_POST['id'];

    $connect = connect();
    $sql = "DELETE FROM categories WHERE id = {$id}";
    $arr = mysqli_query($connect,$sql);
    $response = ['code'=>0,'msg'=>'操作失败'];
    if ($arr) {
        $response['code']=1;
        $response['msg']="操作成功";
    }

    header('content-type:application/json;charset=utf-8');
    echo json_encode($response);
?>