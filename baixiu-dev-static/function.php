<?php
/*1、连接数据库的封装*/
    function connect(){
        $connect=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
        return $connect;
    }
/*2、执行查询的封装*/
    function query($connect,$sql){
        $result=mysqli_query($connect,$sql);
       /* return $result;*/
       return  fetch($result);
    }
/*3、转换结果集为二维数组的封装*/
    function fetch($result){
        $arr=[];
        while($row=mysqli_fetch_assoc($result)){
            $arr[]=$row;
        }
        return  $arr;
    }

    function checkLogin() {
        session_start();
        if(!isset($_SESSION["isLogin"]) || $_SESSION["isLogin"]!=1){
            header("Location:login.php");
        }
    }

    function insert($connect,$arr,$table){
        $keys=array_keys($arr);
        $values=array_values($arr);
        // $sqlAdd="insert into categories (".implode(',',$keys).") values ('".implode("','",$values)."')";
        $keys1= implode(',',$keys);
        $values1 = implode("','",$values);
        $sqlAdd="insert into {$table} ($keys1) values ('$values1')";
        $addResult=mysqli_query($connect,$sqlAdd);
        return $addResult;
    }

    function array_remove($data, $key){  
        if(!array_key_exists($key, $data)){  
            return $data;  
        }  
        $keys = array_keys($data);  
        $index = array_search($key, $keys);  
        if($index !== FALSE){  
            array_splice($data, $index, 1);  
        }  
        return $data;  
    } ;
?>