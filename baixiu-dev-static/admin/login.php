
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap">
      <img class="avatar" src="../static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style='display:none'>
        <strong>错误！</strong> <span id='err'></span>
      </div>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" class="form-control" placeholder="密码">
      </div>
      <span class="btn btn-primary btn-block" href="index.php" id='btn'>登 录</span>
    </form>
  </div>
</body>
</html>
<script src="../static/assets/vendors/jquery/jquery.min.js"></script>
<script>
  $(function () { 
    $('#btn').on('click',function () {   
      var email = $('#email').val();
      var password = $('#password').val();
      var email_reg = /\w+[@]\w+[.]\w+/;
      var pas_reg = /^[a-zA-Z0-9]{6,10}$/;
      if (!email_reg.test(email)) {
        $('#err').text('用户名格式错误，请重新输入！');
        $('.alert').show();
      }else{
        $('.alert').hide();
      };
      if (!pas_reg.test(password)) {
        $('#err').text('密码错误，请重新输入！');
        $('.alert').show();
      } else {
        $('.alert').hide();        
      };
      
      $.ajax({
        type: "post",
        url: "../api/_userLogin.php",
        data: {
          email:email,
          password:password
        },
        success: function (response) {
          console.log(response);
          if (response.code == 1) {
            location.href="index.php";
          };
        }
      });
    })
   })


</script>
