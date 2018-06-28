<?php
    include_once "../config.php";
    include_once "../function.php";

    $ids = $_POST['ids'];
    
    $aa = implode("','",$ids);
    // print_r($aa);
    $connect = connect();
    $sql = "DELETE FROM categories WHERE id in ('{$aa}')";
    // print_r($sql)
    $arr = mysqli_query($connect,$sql);

    $response = ['code'=>0,'msg'=>'操作失败'];
    if ($arr) {
        $response["code"]=1;
        $response["msg"]="操作成功";
    }
    header("Content-Type:application/json;charset=utf-8");
    echo  json_encode($response);
?>