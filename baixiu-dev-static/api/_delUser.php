<?php
    include_once "../config.php";
    include_once "../function.php";

    $id=$_POST['id'];

    

    $connect = connect();
    $sql = "DELETE FROM users WHERE id = {$id}";
    $arr = mysqli_query($connect,$sql);
    $response = ['code'=>0,'msg'=>'操作失败'];
    if ($arr) {
        $response['code']=1;
        $response['msg']="操作成功";
        unlink("..".$_POST['src']);
    }

    header('content-type:application/json;charset=utf-8');
    echo json_encode($response);
?>