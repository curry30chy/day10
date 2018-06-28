<?php
    include_once "../config.php";
    include_once "../function.php";

    session_start();
    $user_id=$_SESSION['user_id'];
    $connect =connect();

    $sql="select  *  from  users  where  id= {$user_id}";

    $queryResult=query($connect,$sql);

    $response=["code"=>0,"msg"=>"操作失败"];
    if($queryResult){
        $response["code"]=1;
        $response["msg"]="操作成功";
        $response['id']=$user_id;
        $response["avatar"]=$queryResult[0]['avatar'];
        $response["nickname"]=$queryResult[0]['nickname'];
    };

    header("Content-Type:application/json;charset=utf-8");
    echo json_encode($response);
?>