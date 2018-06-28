<?php
    // print_r($_POST);
    // print_r($_FILES);
    include_once "../config.php";
    include_once "../function.php";

    $slug = $_POST['slug'];
    $nickname = $_POST['nickname'];
    $categoryId = $_POST['categoryId'];
    $connect = connect();

    if ($_FILES['feature']['error'] == 0) {
        $file = $_FILES['feature'];
        $name = time().rand();
        $ext = strrchr($file['name'],'.');
        $fileName = '../static/uploads/'.$name.$ext;
        $avatar = '/static/uploads/'.$name.$ext;
        move_uploaded_file($file['tmp_name'],$fileName);

        unlink('..'.$_POST['src']);

        $sql = "UPDATE `users` SET `slug`='{$slug}',`nickname`='{$nickname}',`avatar`='{$avatar}',`status`='activated' WHERE (`id`='{$categoryId}')";
    } else {
        $sql = "UPDATE `users` SET `slug`='{$slug}',`nickname`='{$nickname}',`status`='activated' WHERE (`id`='{$categoryId}')";
    }

    $result = mysqli_query($connect,$sql);
    $response=["code"=>0,"msg"=>"操作失败"];

    if ($result) {
        $response['code'] = 1;
        $response['msg'] = "操作成功";

        $handle = opendir('../static/tmp');  
        while (($a=readdir($handle))) { 
            if ($a!="." && $a!="..") {
                unlink("../static/tmp/"."$a");
            }
        }
        closedir($handle); 
    };

    header("Content-Type:application/json;charset=utf-8");
    echo json_encode($response);

?>