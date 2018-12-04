<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="沐风跑步,运动,跑步打卡"/>
    <link rel="shortcut icon" href="{{asset('/img/login.png')}}">
    <meta name="copyright" content="版权所有A梦工作室">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/vendor.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/flat-admin.css')}}">
    <link href="{{asset('/admin/js/morris/morris-0.4.3.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/theme/blue-sky.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/theme/blue.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/theme/red.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/theme/yellow.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/theme/jcDate.css')}}">
 
    @yield('title')
</head>
<body>
<div class="app app-default">
    <aside class="app-sidebar" id="sidebar">
        @foreach($group_data as $v)
            <div class="sidebar-header">
                <a class="sidebar-brand" href="{{url("group/groupindex/$v->Id")}}" style="text-decoration: none;"><span class="highlight">沐风跑步</span> 跑团</a>
                <button type="button" class="sidebar-toggle">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="sidebar-menu">
                <ul class="sidebar-nav">
                    <li class="group_index">
                        <a href="{{url("group/groupindex/$v->Id")}}">
                            <div class="icon">
                                <i class="fa fa-home fa-fw" aria-hidden="true"></i>
                            </div>
                            <div class="title">跑团信息</div>
                        </a>
                    </li>
                    <li class="group_people">
                        <a href="{{url("group/groupindex/group_user/$v->Id")}}">
                            <div class="icon">
                                <i class="fa fa-users fa-fw"></i>
                            </div>
                            <div class="title">跑团成员</div>
                        </a>
                    </li>
                    <li class="group_runs">
                        <a href="{{url("group/groupindex/group_runs/$v->Id")}}">
                            <div class="icon">
                                <i class="fa fa-list-ol fa-fw" aria-hidden="true"></i>
                            </div>
                            <div class="title">成员打卡</div>
                        </a>
                    </li>
                    @if($v->AdvState == 0)
                        <li class="group_adv">
                            <a href="{{url("group/groupindex/group_adv/$v->Id")}}">
                                <div class="icon">
                                    <i class="fa fa-picture-o fa-fw" aria-hidden="true"></i>
                                </div>
                                <div class="title">广告位编辑</div>
                            </a>
                        </li>
                    @else
                    @endif
                </ul>
            </div>
            <div class="sidebar-footer">
                <ul class="menu">
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-cogs" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
        @endforeach
    </aside>
    <script type="text/ng-template" id="sidebar-dropdown.tpl.html">
        <div class="dropdown-background">
            <div class="bg"></div>
        </div>
    </script>
    <div class="app-container">
        <nav class="navbar navbar-default" id="navbar">
            <div class="container-fluid">
                <div class="navbar-collapse collapse in">
                    <ul class="nav navbar-nav navbar-mobile">
                        <li>
                            <button type="button" class="sidebar-toggle">
                                <i class="fa fa-bars"></i>
                            </button>
                        </li>
                        <li class="logo">
                            <a class="navbar-brand" href="#"><span class="highlight">沐风跑步</span>系统</a>
                        </li>
                        <li>
                            <img class="profile-img" src="{{asset('/img/login.png')}}">
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-left">
                        <li class="navbar-search hidden-sm">
                            <img class="page_img" src="{{asset('/img/logmain.png')}}">
                        </li>
                        <li class="navbar-title">@yield('page')</li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown notification warning">
                            <a class="dropdown-toggle " href="#" >
                                <div class="icon"><i class="fa fa-user fa-fw" aria-hidden="true"></i></div>
                            </a>
                            <div class="dropdown-menu">
                                <div class="profile-info">
                                    <h4 class="username">基本操作</h4>
                                </div>
                                <ul class="action">
                                    @foreach($group_data as $v)
                                        <li><a href="{{url("group/groupindex/group_pass/$v->Id")}}"><i class="fa fa-pencil fa-fw"></i> 修改密码</a></li>
                                    @endforeach
                                    <li><a href="{{url('group/groupindex/create')}}"><i class="fa fa-sign-out fa-fw"></i> 退出登录</a></li>
                                    <li><a href="#"> </a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
        <footer class="app-footer">
            <div class="row">
                <div class="col-xs-12">
                    <div class="footer-copyright">
                        Copyright © 2017 Company 萌芽科技.
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script type="text/javascript" src="{{asset('/admin/js/vendor.js')}}"></script>
<script type="text/javascript" src="{{asset('/admin/js/jquery.min(1).js')}}"></script>
<script type="text/javascript" src="{{asset('/admin/js/jQuery-jcDate.js')}}"></script>
<script type="text/javascript" src="{{asset('/admin/js/app.js')}}"></script>
<script type="text/javascript" src="{{asset('/admin/js/morris/raphael-2.1.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/admin/js/morris/morris.js')}}"></script>
<script type="text/javascript" src="{{asset('/org/layui/layui.all.js')}}"></script>
@yield('menu')
</body>
</html>
