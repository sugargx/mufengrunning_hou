@extends('admin.common.template')

@section('title')
    <title>首页</title>
@endsection

@section('page')
    <h1 class="page-header">
        沐风跑步 <small>后台管理系统</small>
    </h1>
@endsection
@section('content')
    <div class="row" style="margin: 10px -15px 30px -15px">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <a class="card card-banner card-blue-light" href="{{url('admin/group')}}">
                <div class="card-body">
                    <i class="icon fa fa-list fa-4x"></i>
                    <div class="content">
                        <div class="title"> 待审核跑团</div>
                        <div class="value"><span class="sign"></span>{{$group_wait}}</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <a class="card card-banner card-green-light" href="{{url('admin/group')}}">
                <div class="card-body">
                    <i class="icon fa fa-picture-o fa-4x"></i>
                    <div class="content">
                        <div class="title"> 待审核广告位</div>
                        <div class="value"><span class="sign"></span>{{$adv_wait}}</div>
                    </div>
                </div>
            </a>
        </div>


    </div>
    <div class="row" style="margin: 10px -15px 30px -15px">
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <a class="card card-banner card-blue-light">
                <div class="card-body">
                    <i class="icon fa fa-bar-chart-o fa-4x"></i>
                    <div class="content">
                        <div class="title">普通用户</div>
                        <div class="value"><span class="sign"></span>{{$user_main}}</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <a class="card card-banner card-yellow-light">
                <div class="card-body">
                    <i class="icon fa fa-flag fa-4x"></i>
                    <div class="content">
                        <div class="title"> 跑团数量</div>
                        <div class="value"><span class="sign"></span>{{$user_captain}}</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <a class="card card-banner card-green-light">
                <div class="card-body">
                    <i class="icon fa fa-calculator fa-4x"></i>
                    <div class="content">
                        <div class="title">入驻商家</div>
                        <div class="value"><span class="sign"></span>{{$user_businessmen}}</div>
                    </div>
                </div>
            </a>
        </div>

    </div>


@endsection
@section('menu')
    <script>
        $(".sidebar-nav li.index").addClass('active');
    </script>
@endsection


