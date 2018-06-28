<?php
    // print_r($_FILES);
    $file=$_FILES["file"];


    $name = time().rand();
    $ext = strrchr($file['name'],'.');
    $fileName = '../static/tmp/'.$name.$ext;
    $avatar = '/static/tmp/'.$name.$ext;
    $boole = move_uploaded_file($file['tmp_name'],$fileName);

    $response=["code"=>0,"msg"=>"操作失败"];
    if ($boole) {
        $response['code']=1;
        $response['msg']="操作成功";
        $response['src']=$avatar;
    };

    header('content-type:application/json;charset=utf-8');
    echo json_encode($response);
?>