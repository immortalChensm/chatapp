<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>传联系统登录</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset("adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css")}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset("adminlte/bower_components/font-awesome/css/font-awesome.min.css")}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset("adminlte/bower_components/Ionicons/css/ionicons.min.css")}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("adminlte/dist/css/AdminLTE.min.css")}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset("adminlte/plugins/iCheck/square/blue.css")}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page" style="max-height: 500px;">
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>传联系统登录</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">传联后台</p>

        <form action="/admin/manager/login" method="post" id="postForm">
            {{csrf_field()}}
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="account" id="account" placeholder="登录账号">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" id="password" placeholder="登录密码">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> 记住我
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    {{--<button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>--}}
                    <a class="btn btn-primary btn-block btn-flat login">登录 </a>
                </div>
                <!-- /.col -->
            </div>
        </form>

        {{--<div class="social-auth-links text-center">--}}
            {{--<p>- OR -</p>--}}
            {{--<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using--}}
                {{--Facebook</a>--}}
            {{--<a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using--}}
                {{--Google+</a>--}}
        {{--</div>--}}
        {{--<!-- /.social-auth-links -->--}}

        {{--<a href="#">I forgot my password</a><br>--}}
        {{--<a href="register.html" class="text-center">Register a new membership</a>--}}

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{asset("adminlte/bower_components/jquery/dist/jquery.min.js")}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset("adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js")}}"></script>
<!-- iCheck -->
<script src="{{asset("adminlte/plugins/iCheck/icheck.min.js")}}"></script>
<script src="{{asset("layer/layer.js")}}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });

        function loginSubmit()
        {
            if ($("#account").val().length==''){
                layer.msg("请填写登录账号");
                $("#account").focus();
                return ;
            }
            if ($("#password").val().length==''){
                layer.msg("请填写登录密码");
                $("#password").focus();
                return ;
            }
            $.ajax({
                type: 'POST',
                url: "{{url('admin/doLogin')}}",
                dataType: 'json',
                data: $('#postForm').serializeArray(),
                success: function(data){
                    if (data.code == 1){
                        layer.msg(data.message);
                        setTimeout(function () {
                            window.location = "{{url('admin/index')}}";
                        },2000);

                    }else if(data.code ==100)
                    {
                        for(var field in data.message){
                            layer.msg(data.message[field][0]);
                            return ;
                        }
                    }else{
                        layer.msg(data.message);
                    }
                },
                error:function(data){

                }
            });
        }
        $(document).keydown(function (e) {
            if(e.keyCode ==13){
                loginSubmit();
            }
        });

        $(".login").on("click",function (e) {
            loginSubmit();
        });
    });
</script>
</body>
</html>
