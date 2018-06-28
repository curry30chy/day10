<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
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
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select name="" class="form-control input-sm" id="category">
            <option value="all">所有分类</option>
          </select>
          <select name="" class="form-control input-sm" id="status">
            <option value="all">所有状态</option>
            <option value="drafted">草稿</option>
            <option value="published">已发布</option>
            <option value="trashed">已删除</option>
          </select>
          <input type="button" value="筛选" class="btn btn-default btn-sm" id="btn-sx">
        </form>
        <ul class="pagination pagination-sm pull-right">
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
  </div>

  <?php $current_page = "posts"; ?>

  <?php include_once "./pubilc/_aside.php" ?>


  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
<script>
  var statusData={
      drafted:"草稿",
      published:"已发布",
      trashed:"已作废"
  };
  var currentPage = 1;
  var pageSize = 20;
  var pageCount;
  var status = $('#status').val();
  var categoryId = $('#category').val();


  function makeTable(response){
    $('tbody').empty();
    $.each(response.data,function(index,val){
      var  str=`<tr>
                  <td class="text-center"><input type="checkbox"></td>
                  <td>${val['title']}</td>
                  <td>${val['nickname']}</td>
                  <td>${val['name']}</td>
                  <td class="text-center">${val['created']}</td>
                  <td class="text-center">${statusData[val['status']]}</td>
                  <td class="text-center">
                    <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
                    <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                  </td>
                </tr>`;
      $(str).appendTo('tbody');
    });
  };

  function makePageButton() {
    var html="";
    var start=currentPage - 2;
    var end=currentPage + 2;
    if (start < 1) {
      start = 1;
      end =start + 4
    };
    if (end > pageCount) {
      end = pageCount;
      start = end - 4;
    };

    if (currentPage !== 1) {
      html+='<li class="item" data-page="'+(currentPage-1)+'"><a href="javascript:;">上一页</a></li>';
    };
    for(var  i=start;i<=end;i++){
        if(i==currentPage){
            html+='<li class="item active" data-page="'+i+'"><a href="javascript:;">'+i+'</a></li>';
        }else{
            html+='<li class="item" data-page="'+i+'"><a href="javascript:;">'+i+'</a></li>';
        };
    };
    if (currentPage !== pageCount) {
      html+='<li class="item" data-page="'+(currentPage+1)+'"><a href="javascript:;">下一页</a></li>';
    };
    $(".pagination").html(html);
  };

  $(function () {
    $.ajax({
        url:"../api/_getPostsData.php",
        type:"post",
        data:{
          currentPage:currentPage,
          pageSize:pageSize,
          status:status,
          categoryId:categoryId
        },
        success:function(response){
          if(response.code==1){
            pageCount=response.pageCount;
            makePageButton();
            makeTable(response);
          }
        }
    });

    $.ajax({
      type: "post",
      url: "../api/_getCategoryData.php",
      success: function (response) {
        if(response.code==1){
          $.each(response.data,function(index,val){
              var html = `<option value="${val['id']}">${val['name']}</option>`;
              $(html).appendTo('#category');
          })
        }        
      }
    });

    $('.pagination').on('click','.item',function () {
      currentPage=parseInt($(this).attr("data-page"));
      $.ajax({
        type: "post",
        url: "../api/_getPostsData.php",
        data: {
          currentPage:currentPage,
          pageSize:pageSize,
          status:status,
          categoryId:categoryId
        },
        success: function (response) {
          if(response.code==1){
            pageCount=response.pageCount;
            makePageButton();
            makeTable(response);
          }
        }
      });
    });
    
    $('#btn-sx').on('click',function () {
        status = $('#status').val();
        categoryId = $('#category').val();
      $.ajax({
        type: "post",
        url: "../api/_getPostsData.php",
        data: {
          currentPage:currentPage,
          pageSize:pageSize,
          status:status,
          categoryId:categoryId
        },
        success: function (response) {
          if(response.code==1){
            pageCount=response.pageCount;
            makePageButton();
            makeTable(response);
          }
        }
      });
    });


  });









</script>
