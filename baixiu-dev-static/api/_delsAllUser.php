<?php
    include_once "../config.php";
    include_once "../function.php";

    $ids = $_POST['ids'];
    // print_r($_POST['srcs']);
    $id = implode("','",$ids);

    $connect = connect();
    $sql = "DELETE FROM users WHERE id in ('{$id}')";

    $arr = mysqli_query($connect,$sql);
    
    $response = ['code'=>0,'msg'=>'操作失败'];
    if ($arr) {
        $response["code"]=1;
        $response["msg"]="操作成功";
        foreach ($_POST['srcs'] as $key => $value) {
            unlink("..".$value);
        }
    }
    header("Content-Type:application/json;charset=utf-8");
    echo  json_encode($response);
?>