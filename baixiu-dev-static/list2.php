<?php
    require_once "./config.php";
    require_once "./function.php";
    /*根据id对文章进行查询
        1、获取id值
        2、根据id值查询数据库
        3、动态生成结构
    */
/*1、获取id*/
    $categoryId=$_GET['id'];
/*2.根据id查询*/
    /*2.1连接数据库*/
    $conn=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
    /*2.2 sql语句*/
    $sql="SELECT p.id,p.title,p.feature,p.created,p.content,p.views,p.likes,c.`name`,u.`nickname`,
        (SELECT COUNT(id) FROM comments WHERE comments.post_id=p.`id`) AS  commentCount
        FROM posts p
        LEFT JOIN  categories c ON  c.`id`=p.`category_id`
        LEFT JOIN  users u ON  u.`id`=p.`user_id`
        WHERE p.`category_id`={$categoryId}
        LIMIT 20";
    /*2.3执行查询语句*/
    header("Content-Type:text/html;charset=utf-8");
    $postArr=query($conn,$sql);
    // print_r($postArr);

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
      <?php include_once "public/_header.php";?>
      <?php include_once "public/_aside.php";?>
    <div class="content">
      <div class="panel new">
        <h3><?php echo $postArr[0]['name'] ?></h3>
          <?php foreach($postArr as $key=>$value){?>
              <div class="entry">
                  <div class="head">
                      <a href="detail.php?postId=<?php echo $value['id']; ?>"><?php echo $value['title']; ?></a>
                  </div>
                  <div class="main">
                      <p class="info"><?php echo $value['nickname'] ?> 发表于 <?php echo $value['created'] ?></p>
                      <p class="brief"><?php echo $value['content'] ?></p>
                      <p class="extra">
                          <span class="reading">阅读(<?php echo $value['views'] ?>)</span>
                          <span class="comment">评论(<?php echo $value['commentCount'] ?>)</span>
                          <a href="javascript:;" class="like">
                              <i class="fa fa-thumbs-up"></i>
                              <span>赞(<?php echo $value['likes'] ?>)</span>
                          </a>
                          <a href="javascript:;" class="tags">
                              分类：<span><?php echo $value['name'] ?></span>
                          </a>
                      </p>
                      <a href="javascript:;" class="thumb">
                          <img src="<?php echo $value['feature'] ?>" alt="">
                      </a>
                  </div>
              </div>
<?php }; ?>

          <!--点击加载更多按钮-->
          <div class="loadmore" >
              <span class="btn1" style="border: 1px solid #ccc;border-radius: 7px;padding: 10px 20px;cursor: pointer;">加载更多</span>
          </div>
      </div>
    </div>
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
  <script src="static/assets/vendors/jquery/jquery.min.js"></script>
  <!-- <script>
      $(function(){
          var currentPage=1;
            $(".loadmore .btn1").on('click',function(){
              
                var categoryId=location.search.split("=")[1]; /*分割之后返回的是一个数组[categoryId,4]*/
                currentPage++;
                $.ajax({
                    type:"post",
                    url:"api/_getMorePost.php",
                    data:{
                        categoryId:categoryId,
                        currentPage:currentPage,
                        pageSize:20
                    },
                    success:function(res){
                        console.log(res);
                        if(res.code==1){
                            var data=res.data;
                            $.each(data,function(index,val){
                                var str = '';
                                str += `<div class="entry">
                                              <div class="head">
                                                 <a href="detail.php?postId=${val.id}">${val.title}</a>
                                              </div>
                                              <div class="main">
                                                  <p class="info">${val['nickname']} 发表于${val['created']} </p>
                                                  <p class="brief">${val['nickname']}</p>
                                                  <p class="extra">
                                                      <span class="reading">阅读(${val['nickname']})</span>
                                                      <span class="comment">评论(${val['commentCount']})</span>
                                                      <a href="javascript:;" class="like">
                                                          <i class="fa fa-thumbs-up"></i>
                                                         <span>赞(${val['likes']})</span>
                                                      </a>
                                                      <a href="javascript:;" class="tags">
                                                          分类：<span>${val['likes']}</span>
                                                      </a>
                                                  </p>
                                                  <a href="javascript:;" class="thumb">
                                                      <img src="${val['feature']}" alt="">
                                                  </a>
                                              </div>
                                          </div>`
                                var entry=$(str);

                                entry.insertBefore('.loadmore');

                                var maxPage=Math.ceil(res.pageCount/20);
                                if(currentPage==maxPage){
                                   $('.loadmore .btn').hide();
                                }

                            })
                        }
                    }
                })
            })
      })
  </script> -->
    <script>
        $(function () {
            var currentPage=1;            
            $(".loadmore").on('click',".btn1",function () {
                var categoryId = location.search.split("=")[1];
                currentPage++;
                var aa = $(".loadmore").html();
                $.ajax({
                    type: "post",
                    url: "./api/_getMorePost.php",
                    data: {                        
                        categoryId:categoryId,
                        currentPage:currentPage,
                        pageSize:20
                    },
                    beforeSend:function () {
                        $(".loadmore").html('<img src = "./5-121204193R0-50.gif" style="height:100px;width:100px;margin: 0 auto;">');
                        // console.log(111);
                        
                    },
                    success: function (response) {
                        if (response.code == 1) {
                            // console.log(response);
                            $.each(response.data,function (index,val) {
                                var str = "";
                                str = `<div class="entry">
                                            <div class="head">
                                                <a href="detail.php?postId=${val.id}">${val.title}</a>
                                            </div>
                                            <div class="main">
                                                <p class="info">${val['nickname']} 发表于${val['created']} </p>
                                                <p class="brief">${val['nickname']}</p>
                                                <p class="extra">
                                                    <span class="reading">阅读(${val['nickname']})</span>
                                                    <span class="comment">评论(${val['commentCount']})</span>
                                                    <a href="javascript:;" class="like">
                                                        <i class="fa fa-thumbs-up"></i>
                                                        <span>赞(${val['likes']})</span>
                                                    </a>
                                                    <a href="javascript:;" class="tags">
                                                        分类：<span>${val['likes']}</span>
                                                    </a>
                                                </p>
                                                <a href="javascript:;" class="thumb">
                                                    <img src="${val['feature']}" alt="">
                                                </a>
                                            </div>
                                        </div>`;
                                $(str).insertBefore('.loadmore');
                                var max = Math.ceil(response.pageCount/20);
                                if (currentPage == max) {
                                   $('.loadmore .btn1').hide();                                    
                                }
                                $(".loadmore").html(aa);
                            })
                        }
                    },

                });
            })
        })
  
  </script>
</body>
</html>