<?php
    include_once "../config.php";
    include_once '../function.php';

    // print_r($_POST);
    // print_r($_SERVER);
    // print_r($_FILES);
    $email=$_POST['email'];
    
    $connect=connect();
    $sql_c="SELECT count(*) as count FROM users WHERE email = '{$email}'";
    $arr = query($connect,$sql_c);
    $count=$arr[0]['count'];
    $response = ['code'=>0];

    if (!$count==0) {
        $response['msg']='邮箱已经存在';
    }else {
        if (!empty($_FILES) && $_FILES['feature']['error'] == 0) {
            $file = $_FILES['feature'];
            $name = time().rand();
            $ext = strrchr($file['name'],'.');
            $fileName = '../static/uploads/'.$name.$ext;
            $avatar = '/static/uploads/'.$name.$ext;
            move_uploaded_file($file['tmp_name'],$fileName);

            $keys=array_keys($_POST);
            array_push($keys,"avatar");
            array_push($keys,"status");
            $values=array_values($_POST);
            array_push($values,$avatar);
            array_push($values,"unactivated");

            $sql_add="insert into users (".implode(',',$keys).") values ('".implode("','",$values)."')";
            $addResult=mysqli_query($connect,$sql_add);
            if ($addResult) {
                $response['code']='1';
                $response['msg']='操作成功';
            }else {
                $response['msg']='操作失败，请重试！';
            }

        } else {
            $response['msg']='文件上传失败';
        }
    }

    $handle = opendir('../static/tmp');  
    while (($a=readdir($handle))) { 
        if ($a!="." && $a!="..") {
            unlink("../static/tmp/"."$a");
        }
    }
    closedir($handle); 
    
    header("Content-Type:application/json;charset=utf-8");
    echo  json_encode($response);
    // print_r($keys);
    // print_r($values);
?>