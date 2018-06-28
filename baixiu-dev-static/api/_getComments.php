<?php
    include_once "../config.php";
    include_once "../function.php";

    $currentPage=$_POST["currentPage"];
    $pageSize=$_POST["pageSize"];
    $pageCount=($currentPage-1)*$pageSize;

    $connect=connect();
    $sql="SELECT  c.id,c.author,c.created,c.content,c.status,p.title FROM comments c
    LEFT JOIN posts p ON p.id=c.`post_id`
    LIMIT $pageCount,$pageSize";
    $queryResult=query($connect,$sql);

    $sqlCount="select count(id) as count from comments";
    $countArr=query($connect,$sqlCount);
    $count=$countArr[0]["count"];  /*获取总的条数*/
    $pageCount=ceil($count/$pageSize);  /*获取总的页数*/

    $response=["code"=>0,"msg"=>"操作失败"];
    if($queryResult){
        $response["code"]=1;
        $response["msg"]="操作成功";
        $response["pageCount"]=$pageCount;
        $response["data"]=$queryResult;
    };

    header("Content-Type:application/json;charset=utf-8");
    echo json_encode($response);
?>