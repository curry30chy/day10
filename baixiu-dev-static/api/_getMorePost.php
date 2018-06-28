<?php
//     require_once "../config.php";
//     require_once "../function.php";


//     /*
//      * 1、获取分类的id，第几次获取数据，一共要获取多少条
//      * 2、到数据库中查找对应的数据
//      * 3、把数据返回给前台，让其生成结构
//      *
//      * */

//  //    1、获取必要的参数
//     $categoryId = $_POST["categoryId"];
//     $currentPage = $_POST["currentPage"];
//     $pageSize= $_POST["pageSize"];
//         /*1.2  计算出要从哪里开始获取*/
//     $offset=($currentPage-1)*$pageSize;
// //    2、查询数据库
//         /*2.1 连接数据库*/
//     $connect = connect();
//         /*2.2 sql语句*/
//     $sql = "SELECT p.id, p.title,p.feature,p.created,p.content,p.views,p.likes,c.`name`,u.`nickname`,
//             (SELECT COUNT(id) FROM comments WHERE comments.post_id=p.`id`) AS  commentCount
//             FROM posts p
//             LEFT JOIN  categories c ON  c.`id`=p.`category_id`
//             LEFT JOIN  users u ON  u.`id`=p.`user_id`
//             WHERE p.`category_id`={$categoryId}
//             LIMIT {$offset},{$pageSize}";
//         /* 2.3 执行查询*/
//     $postArr = query($connect,$sql);

// //    3、计算点击更多 文章总共可以获取多少次，返回给前台让其判断加载更多是否应该显示给用户
//         /*3.1   准备sql语句，计算文章总的数量*/
//     $sqlCount="select count(id) as postCount from posts where category_id={$categoryId}";
//         /*3.2   执行语句*/
//     $countArr=query($connect,$sqlCount);
//     //print_r($countArr);
//         /*Array
//         (
//             [0] => Array
//             (
//                 [postCount] => 371
//             )
//         )*/
//         /*3.3   查询结果是二维数组，需从二维数组中获取总共能获取的数量*/
//     $pageCount=$countArr[0]["postCount"];  /*获取总的条数*/
// //    4、返回数据
//     $response=["code"=>0,"msg"=>"操作失败"];

//     if($postArr){
//         $response["code"]=1;
//         $response["msg"]="操作成功";
//         $response["pageCount"]=$pageCount;  /*总的条数返回给前台*/
//         $response["data"]=$postArr;
//     };

//     header("Content-Type:application/json;charset=utf-8");
//     echo json_encode($response);


?>

<?php
    include_once '../config.php';
    include_once '../function.php';
    sleep(5);
    $categoryId = $_POST["categoryId"];
    $currentPage = $_POST["currentPage"];
    $pageSize= $_POST["pageSize"];
    $offset=($currentPage-1)*$pageSize;
    $connect = connect();
    $sql = "SELECT p.id, p.title,p.feature,p.created,p.content,p.views,p.likes,c.`name`,u.`nickname`,
            (SELECT COUNT(id) FROM comments WHERE comments.post_id=p.`id`) AS  commentCount
            FROM posts p
            LEFT JOIN  categories c ON  c.`id`=p.`category_id`
            LEFT JOIN  users u ON  u.`id`=p.`user_id`
            WHERE p.`category_id`={$categoryId}
            LIMIT {$offset},{$pageSize}";
    $postArr = query($connect,$sql);
    $sqlCount="select count(id) as postCount from posts where category_id={$categoryId}";
    $countArr=query($connect,$sqlCount);
    $pageCount=$countArr[0]["postCount"];  
    $response=["code"=>0,"msg"=>"操作失败"];
    if($postArr){
        $response["code"]=1;
        $response["msg"]="操作成功";
        $response["pageCount"]=$pageCount;
        $response["data"]=$postArr;
    };
    header("Content-Type:application/json;charset=utf-8");
    echo json_encode($response);  
?>