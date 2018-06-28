<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include_once "./pubilc/_navbar.php" ?>

    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
        <ul class="pagination pagination-sm pull-right">
        <!-- <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li> -->
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
      <!-- <tr class="danger">
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>未批准</td>
            <td class="text-center">
              <a href="post-add.php" class="btn btn-info btn-xs">批准</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>已批准</td>
            <td class="text-center">
              <a href="post-add.php" class="btn btn-warning btn-xs">驳回</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>已批准</td>
            <td class="text-center">
              <a href="post-add.php" class="btn btn-warning btn-xs">驳回</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr> -->
        </tbody>
      </table>
    </div>
  </div>

  <?php $current_page = "comments"; ?>

  <?php include_once "./pubilc/_aside.php" ?>


  <!-- <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script> -->
  <script>NProgress.done()</script>
  <!-- <script src="../static/assets/vendors/twbs-pagination/jquery.twbsPagination.js"></script>
  <script src="../static/assets/vendors/art-template/template-web.js"></script> -->
  <script type="text/art-template" id="template">
    {{each $data value}}
      <tr>
          <td class="text-center"><input type="checkbox"></td>
          <td>{{value.author}}</td>
          <td style="width:400px">{{value.content}}</td>
          <td>{{value.title}}</td>
          <td>{{value.created}}</td>
          <td>
              {{if value.status == "held"}}
                未审核
              {{else if value.status == "approved"}}
                已准许
              {{else if value.status == "rejected"}}
                已拒绝
              {{else if value.status == "trashed"}}
                已删除
              {{/if}}
          </td>
          <td class="text-center">
              <a href="post-add.php" class="btn btn-warning btn-xs">驳回</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
          </td>
      </tr>
    {{/each}}
  </script>

  <!-- <script>
    $(function () {
      var currentPage=1;
      var pageSize=10;
      var pageCount;

      getCommentsData();

      function getCommentsData() {
        $.ajax({
          type: "post",
          url: "../api/_getComments.php",
          data: {
            currentPage:currentPage,
            pageSize:pageSize
          },
          success: function (response) {
            if(response.code==1){
                pageCount=response.pageCount;
                var html = template("template",response.data);
                $("tbody").html(html);  

              $('.pagination').twbsPagination({
                  totalPages: pageCount,
                  visiblePages: 11,
                  onPageClick: function (event, page) {
                      currentPage=page;
                      getCommentsData();
                  }
              });              
            };
          }
        })
      };


    })
  </script> -->

  <script src="../static/assets/vendors/require/require.js" data-main="../static/assets/js/coon.js"></script>
</body>
</html>
