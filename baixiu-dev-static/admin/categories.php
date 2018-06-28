<?php 
  require_once '../config.php';
  require_once "../function.php";

  checkLogin();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style='display:none;'>
        <strong>错误！</strong><span id="msg"></span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id="form">
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            </div>
            <div class="form-group">
              <label for="classname">类名</label>
              <input id="classname" class="form-control" name="classname" type="text" placeholder="类名">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="button" id="btn-add">添加</button>
              <button class="btn btn-primary" type="button" id="btn-edit" style="display: none;">编辑完成</button>
              <button class="btn btn-primary" type="button" id="btn-cancel" style="display: none;">取消编辑</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none" id="dels">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th>类名</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php $current_page = "categories"; ?>
  <?php include_once "./pubilc/_aside.php" ?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
<script>
  $(function () {
    $.ajax({
      type: "post",
      url: "../api/_getCategoryData.php",
      data: {},
      dataType: "json",
      success: function (response) {
        // console.log(response);
        if (response.code == 1) {
          $.each(response.data,function (index,val){
            var str = `<tr data-category-id="${val['id']}">
                        <td class="text-center"><input type="checkbox"></td>
                        <td>${val['name']}</td>
                        <td>${val['slug']}</td>
                        <td>${val['classname']}</td>
                        <td class="text-center">
                          <a href="javascript:;" class="btn btn-info btn-xs edit" data-category-id="${val['id']}">编辑</a>
                          <a href="javascript:;" class="btn btn-danger btn-xs del" data-category-id="${val['id']}">删除</a>
                        </td>
                      </tr>`;
            $(str).appendTo($('tbody'));   
          })
        }
      }
    });

    $('#btn-add').on('click',function () {
      var name=$("#name").val();
      var slug=$("#slug").val();
      var classname=$("#classname").val(); 

      if(name==''){
        $('#msg').text("分类的名称不能为空");
        $('.alert').show();
        return;
      }else{
        $('.alert').hide();
      };
      if(slug==''){
        $('#msg').text("分类的别名不能为空");
        $('.alert').show();
        return;
      }else{
        $('.alert').hide();
      };
      if(classname==''){
        $('#msg').text("分类的类名不能为空");
        $('.alert').show();
        return;
      }else{
        $('.alert').hide();
      };

      $.ajax({
        type: "post",
        url: "../api/_addCategory.php",
        data:$('#form').serialize(),
        dataType: "json",
        success: function (response) {
          if(response.code==1){
            location.reload()
          }
        }
      })
    });

    $('tbody').on('click','.edit',function () {

      var categoryId=$(this).data("categoryId");
      $('#btn-edit').attr("data-category-id",categoryId);
      console.log(categoryId);
      

      $('#btn-add').hide();
      $('#btn-edit').show();
      $('#btn-cancel').show();
      var name=$(this).parents("tr").children().eq(1).text();
      var slug=$(this).parents("tr").children().eq(2).text();
      var classname=$(this).parents("tr").children().eq(3).text();
      $('#name').val(name);
      $('#slug').val(slug);
      $('#classname').val(classname);
    });

    $('#btn-edit').on('click',function () {
      // var categoryId=$(this).attr("data-category-id");
      var categoryId=$(this).data("categoryId");

      var name=$('#name').val();
      var slug=$('#slug').val();
      var classname=$('#classname').val();

      if(name==''){
        $('#msg').text("分类的名称不能为空");
        $('.alert').show();
        return;
      }else{
        $('.alert').hide();
      };
      if(slug==''){
        $('#msg').text("分类的别名不能为空");
        $('.alert').show();
        return;
      }else{
        $('.alert').hide();
      };
      if(classname==''){
        $('#msg').text("分类的类名不能为空");
        $('.alert').show();
        return;
      }else{
        $('.alert').hide();
      };

      $.ajax({
        type: "post",
        url: "../api/_updateCategory.php",
        data: {
          id:categoryId,
          name:name,
          slug:slug,
          classname:classname
        },
        success: function (res) {     
          if(res.code==1){
            location.reload(true);
          }
        }
      });
    });

    $('#btn-cancel').on('click',function () {
      $('#btn-add').show();
      $('#btn-edit').hide();
      $('#btn-cancel').hide();

      $('#name').val('');
      $('#slug').val('');
      $('#classname').val('');
    });

    $('tbody').on('click','.del',function () {
      var row = $(this).parents('tr');
      // console.log(row);
      var categoryId=$(this).data("categoryId");
      // console.log(categoryId);
      $.ajax({
        type: "post",
        url: "../api/_delCategory.php",
        data: {
          id:categoryId
        },
        dataType: "json",
        success: function (response) {
          // location.reload();
          row.remove();
        }
      });
      
    });

    $('thead input[type=checkbox]').on('change',function () {
      var status = $(this).prop('checked');
      // console.log(status);
      $('tbody input').prop('checked',status);

      if (status) {
        $('#dels').show();
      }else{
        $('#dels').hide();
      };
    });

    $('tbody').on('click','input[type=checkbox]',function () {
      var all = $('thead input[type=checkbox]');
      var cks = $('tbody input[type=checkbox]');
      
      all.prop('checked',cks.size()==$('tbody input:checked').size());

      if ($('tbody input:checked').size() >= 2) {
        $('#dels').show();
      }else{
        $('#dels').hide();
      }
    });

    $('#dels').on('click',function () {
      var cks = $('tbody input:checked');
      var ids = [];
      $.each(cks,function (index,val) {
        var id = $(val).parents('tr').data("categoryId");
        ids.push(id);
      });
      
      $.ajax({
        type: "post",
        url: "../api/_delsAllCategory.php",
        data: {
          ids:ids
        },
        dataType: "json",
        success: function (response) {
          console.log(response);
          if (response) {
            $.each(cks,function (index,val) {
              $(val).parents('tr').remove();
            })
          }
        }
      });
      
      
    });

    
  })


</script>
