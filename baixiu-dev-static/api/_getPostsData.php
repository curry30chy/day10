<?php
    require_once "../config.php";
    require_once "../function.php";

    $currentPage = $_POST['currentPage'];
    $pageSize = $_POST['pageSize'];
    $status = $_POST['status'];
    $categoryId = $_POST["categoryId"];



    $where = " where 1 = 1 ";
    if ($status != "all") {
        $where.=" and P.`status` = '{$status}'";
    };
    if ($categoryId != "all") {
        $where.=" and P.`category_id` = '{$categoryId}'";
    };


    $offset = ($currentPage-1)*$pageSize;


    $connect=connect();

    $sql="SELECT  p.id,p.title,p.created,p.status,u.nickname,c.name FROM posts p
        LEFT JOIN users u ON u.`id`=p.`user_id`
        LEFT JOIN categories c ON c.`id`=p.`category_id`" . $where . "limit {$offset},{$pageSize}";

    $result=query($connect,$sql);


    $countSql="SELECT  count(*) as count FROM posts p
        LEFT JOIN users u ON u.`id`=p.`user_id`
        LEFT JOIN categories c ON c.`id`=p.`category_id`" . $where . "";
    $countArr=query($connect,$countSql);
    $postCount=$countArr[0]["count"];
    $pageCount=ceil($postCount/$pageSize);


    $response=["code"=>0,"msg"=>"操作失败"];
    if($result){
        $response["code"]=1;
        $response["msg"]="操作成功";
        $response["data"]=$result;
        $response["pageCount"]=$pageCount;
    };

    header("Content-Type:application/json;charset=utf-8");
    echo json_encode($response);
?>