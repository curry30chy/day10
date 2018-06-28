<?php
    include_once "../config.php";
    include_once "../function.php";

    $name = $_POST['name'];
    print_r($_POST);
    
    $connect = connect();
    $CXsql = "select count(*) as  count from categories where name = '{$name}'";
    $arr = query($connect,$CXsql);
    $count=$arr[0]['count'];
    $response = ['code'=>0,'msg'=>'操作失败'];
    if ($count > 0) {
        $response['msg']='分类名称已经存在，不能重复添加';
    }else {
        //如果不存在就继续添加
        /*4.1准备sql语句*/
        /*获取表单数组*/
        // print_r($_POST);

        /*获取数组中的键*/
       /* $keys=array_keys($_POST);
        print_r($keys);*/

        /*获取数组中的值*/
        /*$values=array_values($_POST);
        print_r($values);*/

        /*$sqlAdd="INSERT INTO categories (`slug`,`name`,`classname`)  VALUES ('{$name}','{$slug}','{$classname}')";*/
        /*4.2执行新增sql语句*/
        //$addResult=mysqli_query();

        //原生写法
        // $keys=array_keys($_POST);
        // $values=array_values($_POST);
        // // $sqlAdd="insert into categories (".implode(',',$keys).") values ('".implode("','",$values)."')";
        // $keys1= implode(',',$keys);
        // $values1 = implode("','",$values);
        // $sqlAdd="insert into categories ($keys1) values ('$values1')";
        // $addResult=mysqli_query($connect,$sqlAdd);
        $addResult = insert($connect,$_POST,'categories');


        if($addResult){
            $response["code"]=1;
            $response["msg"]="操作成功";
        };
    }


    header("Content-Type:application/json;charset=utf-8");
    echo  json_encode($response);
?>