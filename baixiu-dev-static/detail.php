<?php
  include_once './config.php';
  include_once './function.php';

  $postId = $_GET['postId'];
  // print_r($postId);
  $connect = connect();

  $sql = "SELECT p.title,p.feature,p.created,p.content,p.views,p.likes,u.nickname,c.`name` FROM posts p
          LEFT JOIN users u ON u.id = p.user_id
          LEFT JOIN categories c ON c.id = p.category_id
          WHERE p.id = {$postId}";

  $postArr = query($connect,$sql)[0];
  print_r($postArr)
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>阿里百秀-发现生活，发现美!</title>
  <link rel="stylesheet" href="static/assets/css/style.css">
  <link rel="stylesheet" href="static/assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
  <div class="wrapper">
    <div class="topnav">
      <ul>
        <li><a href="javascript:;"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="javascript:;"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="javascript:;"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="javascript:;"><i class="fa fa-gift"></i>美奇迹</a></li>
      </ul>
    </div>
    <?php include_once 'public/_header.php' ?>
    <?php include_once 'public/_aside.php' ?>
    <div class="content">
      <div class="article">
        <div class="breadcrumb">
          <dl>
            <dt>当前位置：</dt>
            <dd><a href="javascript:;"><?php echo $postArr['name'] ?></a></dd>
            <dd><?php echo $postArr['title'] ?></dd>
          </dl>
        </div>
        <h2 class="title">
          <a href="javascript:;"><?php echo $postArr['title'] ?></a>
        </h2>
        <div class="meta">
          <span><?php echo $postArr['nickname'] ?> 发布于 <?php echo $postArr['created'] ?></span>
          <span>分类: <a href="javascript:;"><?php echo $postArr['name'] ?></a></span>
          <span>阅读: (<?php echo $postArr['views'] ?>)</span>
          <span>点赞: (<?php echo $postArr['likes'] ?>)</span>
        </div>
        <div class="contentdetail" style="  padding: 10px;text-indent: 2em;line-height: 35px;font-size: 16px;"><?php echo $postArr['content'] ?></div>
      </div>
      <div class="panel hots">
        <h3>热门推荐</h3>
        <ul>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/hots_2.jpg" alt="">
              <span>星球大战:原力觉醒视频演示 电影票68</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/hots_3.jpg" alt="">
              <span>你敢骑吗？全球第一辆全功能3D打印摩托车亮相</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/hots_4.jpg" alt="">
              <span>又现酒窝夹笔盖新技能 城里人是不让人活了！</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/hots_5.jpg" alt="">
              <span>实在太邪恶！照亮妹纸绝对领域与私处</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
</body>
</html>
