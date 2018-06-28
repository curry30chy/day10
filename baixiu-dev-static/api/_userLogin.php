<?php
    include_once '../config.php';
    include_once '../function.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $connect = connect();
    $sql = "select * from users where email='{$email}' and password='{$password}' and status='activated'";
    $arr = query($connect,$sql);
    $response=["code"=>0,"msg"=>"登录失败"];
    if($arr){
        session_start();
        $_SESSION['isLogin']=1;
        $_SESSION["user_id"]=$arr[0]['id'];/*保存用户的id*/

        $response["code"]=1;
        $response["msg"]="登录成功";
    };
    header("Content-Type:application/json;charset=utf-8");
    echo json_encode($response);  
?>