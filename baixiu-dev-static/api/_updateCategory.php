<?php



include_once "../config.php";
include_once "../function.php";

$id = $_POST['id'];
$slug = $_POST['slug'];
$name = $_POST['name'];
$classname = $_POST['classname'];


$connect = connect();

$sql = "UPDATE categories SET slug='{$slug}',name='{$name}',classname='{$classname}'  WHERE id = {$id}";
$arr = mysqli_query($connect,$sql);

$response=['code'=>0,'msg'=>"编辑失败"];
if ($arr) {
    $response['code']=1;
    $response['msg']="编辑完成";
};
header('content-type:application/json;charset=utf-8');
echo json_encode($response);
?>
