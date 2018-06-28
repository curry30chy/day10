<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Users &laquo; Admin</title>
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
        <h1>用户</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none;">
        <strong>错误！</strong><span id="msg"></span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id="form">
            <h2>添加新用户</h2>
            <div class="form-group">
              <label for="email">邮箱</label>
              <input id="email" class="form-control" name="email" type="email" placeholder="邮箱">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" class="form-control" name="password" type="text" placeholder="密码">
            </div>
            <div class="form-group">
              <label for="feature">个性头像</label>
              <img class="help-block thumbnail" style="display: none">
              <input id="feature" class="form-control" name="feature" type="file">
            </div>
          </form>
          <button class="btn btn-primary" type="botton" id="btn-add">添加</button>
          <button class="btn btn-primary" type="button" id="btn-edit" style="display: none;">确认激活</button>
          <button class="btn btn-primary" type="button" id="btn-cancel" style="display: none;">取消激活</button>
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
                <th class="text-center" width="80">头像</th>
                <th>邮箱</th>
                <th>别名</th>
                <th>昵称</th>
                <th>状态</th>
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
  
  <?php $current_page = "users"; ?>

  <?php include_once "./pubilc/_aside.php" ?>


  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
<script>
  $(function () {
    var e = false;
    var p = false;
    $.ajax({
      type: "post",
      url: "../api/_getUser.php",
      data: {},
      dataType: "json",
      success: function (response) {
        // console.log(response);
        if (response.code == 1) {
          $.each(response.data,function (index,val){
            var str = `<tr data-id="${val['id']}">
                        <td class="text-center"><input type="checkbox"></td>
                        <td class="text-center"><img class="avatar" src="${val['avatar']}"></td>
                        <td>${val['email']}</td>
                        <td>${val['slug']}</td>
                        <td>${val['nickname']}</td>
                        <td> ${val['status']=="activated"?"激活":'未激活'} </td>
                        <td class="text-center">
                          <a href="javascript:;" class="btn btn-default btn-xs edit" data-id="${val['id']}">编辑</a>
                          <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
                        </td>
                      </tr>`;
            $(str).appendTo($('tbody'));
          })
        }
      }
    });

    $('#email').on('blur',function () {
      var email = $('#email').val();
      var email_reg = /\w+[@]\w+[.]\w+/;
      if (!email_reg.test(email)) {
        $('#msg').text('用户名格式错误，请重新输入！');
        $('.alert').show();
        setTimeout(() => {
          $('.alert').hide();
        }, 5000);
      }else{
        $('.alert').hide();
        e = true;
      };
    });

    $('#password').on('blur',function () {
      var password = $('#password').val();
      var pas_reg = /^[a-zA-Z0-9]{6,10}$/;
      if (!pas_reg.test(password)) {
        $('#msg').text('密码格式错误，请重新输入！密码格式为6-9位数字，字母。');
        $('.alert').show();
        setTimeout(() => {
          $('.alert').hide();
        }, 5000);
      } else {
        $('.alert').hide(); 
        p = true;
      };
    });

    $('#btn-add').on('click',function () {
      if (p == true && e == true) {
        var slug=$("#slug").val();
        var nickname=$("#nickname").val(); 

        if(slug==''){
          $('#msg').text("别名不能为空");
          $('.alert').show();
          return;
        }else{
          $('.alert').hide();
        };
        if(nickname==''){
          $('#msg').text("昵称不能为空");
          $('.alert').show();
          return;
        }else{
          $('.alert').hide();
        };


        var formData = new FormData(document.getElementById("form"));

        
        $.ajax({
          type: "post",
          url: "../api/_addUser.php",
          data: formData,
          processData:false,
          contentType:false,
          success: function (response) {
            // console.log(response);
            if (response.code == 0) {
              $('#msg').text(response.msg);
              $('.alert').show();
            }else if(response.code == 1){
              // console.log(response);
              location.reload();
            }
          }
        });
      }else{
        $('#msg').text('邮箱和密码不能为空');
        $('.alert').show();
      }
    });

    $('tbody').on('click','.del',function () {
      var row = $(this).parents('tr');
      var id = $(this).parents('tr').data('id');
      var src = $(this).parents("tr").find('img').attr("src");
      $.ajax({
        type: "post",
        url: "../api/_delUser.php",
        data: {
          id:id,
          src:src
        },
        success: function (response) {
          row.remove();
        }
      });
      
    });

    $('thead input').on('click',function () {
      var status = $(this).prop('checked');
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
      var ids = [];
      var cks = $('tbody input:checked');
      $.each(cks,function (indes,val) {
        var id = $(val).parents('tr').data('id');
        ids.push(id);
      });
      var srcs = [];
      $.each(cks,function (indes,val) {
        var src = $(val).parents('tr').find('img').attr("src");
        srcs.push(src);
      });

      
      var rows = cks.parents('tr');

      $.ajax({
        type: "post",
        url: "../api/_delsAllUser.php",
        data: {
          ids:ids,
          srcs:srcs
        },
        success: function (response) {
          rows.remove()
        }
      });
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

    $('tbody').on('click','.edit',function () {
      var categoryId=$(this).data("id");
      $('#btn-edit').attr("data-category-id",categoryId);
      // console.log(categoryId);
      var src = $(this).parents("tr").find('img').attr("src");
      $('#btn-edit').attr("data-src",src);

      $("#password").parent('div').hide();
      $("#email").attr("readOnly","true");
      $(".help-block").attr("src",src).show();

      $('#btn-add').hide();
      $('#btn-edit').show();
      $('#btn-cancel').show();
      var email=$(this).parents("tr").children().eq(2).text();
      var slug=$(this).parents("tr").children().eq(3).text();
      var nickname=$(this).parents("tr").children().eq(4).text();

      $('#email').val(email);
      $('#slug').val(slug);
      $('#nickname').val(nickname); 
    });

    $('#btn-edit').on('click',function () {
      var formData = new FormData(document.getElementById("form"));
      var categoryId = $(this).data("categoryId");
      var src = $(this).data("src");
      // console.log(categoryId);
      formData.append("categoryId",categoryId);
      formData.append("src",src);

      console.log(formData);
      

      $.ajax({
        type: "post",
        url: "../api/_updataUser.php",
        data: formData,
        processData:false,
        contentType:false,
        success: function (response) {
          location.reload();
        }
      });
    });

    $('#btn-cancel').on('click',function () {
      location.reload();
    })


  })

</script>
