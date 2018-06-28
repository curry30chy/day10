<?php
    include_once "../config.php";
    include_once "../function.php";

    $connect = connect();
    $sql = "select  * from  users";
    $arr = query($connect,$sql);
    $response=["code"=>0,"msg"=>"操作失败"];
    if ($arr) {
        $response['code'] = 1;
        $response['msg'] = "操作成功";
        $response['data'] = $arr;
    }
    header('content-type:application/json;charset=utf-8');
    echo json_encode($response);
?>