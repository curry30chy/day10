<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
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
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none;">
        <strong>错误！</strong><span id="msg"></span>
      </div>
      <form class="row" id="data-form">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容"></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <!-- <p class="help-block">https://zce.me/post/<strong>slug</strong></p> -->
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none">
            <input id="feature" class="form-control" name="feature" type="file" >
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category_id">
              <!-- <option value="1">未分类</option>
              <option value="2">潮生活</option> -->
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
              <option value="published">已发布</option>
            </select>
          </div>
          <div class="form-group">
            <input type="button" value="保存" class="btn btn-primary" id="btn-save">
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php $current_page = "post_add"; ?>

  <?php include_once "./pubilc/_aside.php" ?>


  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../static/assets/vendors/ckeditor/ckeditor.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
<script>
  $(function () {
    var src;
    var file;

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

    $('#feature').on('change',function () {
      var formData = new FormData();
      file = this.files[0];
      formData.append("file",file);

      $.ajax({
        type: "post",
        url: "../api/_updataFiles.php",
        data:formData,
        contentType:false,
        processData:false,
        success: function (response) {
          // console.log(response);
          if (response.code == 1) {
            $(".help-block").attr("src",response.src).show();
            src = response.src;
          }
        }
      });
    });

    CKEDITOR.replace("content");
    $('#btn-save').on('click',function () {
      CKEDITOR.instances.content.updateElement();
      var formData = new FormData();
      var data = $("#data-form").serialize();
      // 中文编码问题
      data = decodeURIComponent(data,true);
      var userId = $('.profile h3').attr("userId");
      formData.append("file",file);
      formData.append("user_id",userId);
      formData.append("data",data);
      $.ajax({
        type: "post",
        url: "../api/_addPost.php",
        data: formData,
        dataType: "json",
        contentType:false,
        processData:false,
        success: function (response) {
          if (response.code == 1) {
            $('#msg').text(response.msg);
            $('.alert>strong').hide();
            $('.alert').show();
            setTimeout(() => {
              location.reload();
            }, 2000);
          }else{
            $('#msg').text(response.msg);
            $('.alert').show();
          }
        }
      });
      
      
    });
  })


</script>
