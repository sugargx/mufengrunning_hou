<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="沐风跑步,运动,跑步打卡"/>
    <link rel="shortcut icon" href="{{asset('/img/login.png')}}">
    <meta name="copyright" content="版权所有A梦工作室">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>欢迎登录沐风跑团</title>
    <link rel="stylesheet" href="{{asset('/admin/login/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/admin/login/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('/admin/login/css/form-elements.css')}}">
    <link rel="stylesheet" href="{{asset('/admin/login/css/style.css')}}">
</head>
<body>
<div class="top-content">
    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1 ><img class="img_login" src="{{asset('/img/login.png')}}"><strong>沐风跑步</strong> <small></small></h1>
                    <div class="description"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3>请登录</h3>
                            <p>请输入用户名、密码、验证码</p>
                            @if(session('msg'))
                                <p style="color: #ff4500">{{session('msg')}}</p>
                            @endif
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form role="form" action="{{url('login')}}" method="post" class="login-form">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label class="sr-only" for="form-username"></label>
                                <input type="text" name="form-username" placeholder="账号..." class="form-username form-control" id="form-username">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-password"></label>
                                <input type="password" name="form-password" placeholder="密码..." class="form-password form-control" id="form-password">
                            </div>
                            <div class="form-group has-feedback">
                                <label class="sr-only" for="form-code"></label>
                                <input type="text" name="form-code" placeholder="验证码..." class="form-code form-control" id="form-code">&nbsp;
                                <img  id="img_code" src="{{url('admin/code')}}" alt="" onclick="this.src='{{url('admin/code')}}?'+Math.random()">
                            </div>
                            <button type="submit" class="btn btn-success">登录</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('/admin/login/js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('/admin/login/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/admin/login/js/jquery.backstretch.min.js')}}"></script>
<script src="{{asset('/admin/login/js/scripts.js')}}"></script>
</body>
</html>