<?php
    header("Content-Type: text/html;charset=utf-8"); 
    include_once "../config.php";
    include_once "../function.php";

    /* 传过来的值是这样的
    Array(
        [user_id] => 5
        [data] => title=%E5%8E%BB&content=%3Cp%3E%E5%8E%BB%3C%2Fp%3E&slug=qqq&category=2&created=2018-06-19T12%3A02&status=drafted
    )*/
    $tmp = explode("&", $_POST['data']);
    $newArr = array();  
    foreach($tmp as $v) {  
        $t = explode('=',$v);  
        $newArr[$t[0]] = $t[1];  
    } ;
    $_POST=array_merge($_POST,$newArr);
    $_POST = array_remove($_POST,"data");
    
    /*
    处理后是这样的
    Array(
        [user_id] => 5
        [title] => %E5%8E%BB
        [content] => %3Cp%3E%E5%8E%BB%3C%2Fp%3E
        [slug] => qqq
        [category_id] => 2
        [created] => 2018-06-19T12%3A02
        [status] => drafted
    )
    */ 

    // print_r($_POST);
    $file=$_FILES["file"];
    $name = time().rand();
    $ext = strrchr($file['name'],'.');
    $fileName = '../static/uploads/'.$name.$ext;
    $avatar = '/static/uploads/'.$name.$ext;
    $boole = move_uploaded_file($file['tmp_name'],$fileName);
    
    $_POST['feature']=$avatar;
    /*
    处理后是这样的
    Array(
        [user_id] => 5
        [feature] => /static/uploads/1529344248735258046.jpeg
        [title] => %E5%8E%BB
        [content] => %3Cp%3E%E5%8E%BB%3C%2Fp%3E
        [slug] => qqq
        [category_id] => 2
        [created] => 2018-06-19T12%3A02
        [status] => drafted
    )
    */ 

    $connect = connect();
    $addResult = insert($connect,$_POST,'posts');
    
    $response = ['code'=>0,'msg'=>'操作失败'];
    if($addResult && $boole){
        $response["code"]=1;
        $response["msg"]="操作成功";
    };

    $handle = opendir('../static/tmp');  
    while (($a=readdir($handle))) { 
        if ($a!="." && $a!="..") {
            unlink("../static/tmp/"."$a");
        }
    }
    closedir($handle); 

    header("Content-Type:application/json;charset=utf-8");
    echo  json_encode($response);



?>