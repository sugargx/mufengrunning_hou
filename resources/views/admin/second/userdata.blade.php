@extends('admin.common.template')

@section('title')
<title>个人信息</title>
@endsection
@section('page')
    <h1 class="page-header">
        用户 <small>信息查看</small>
    </h1>
@endsection
@section('content')
    <div class="row">
    <div class="col-md-5 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                用户信息
            </div>
            @foreach($data as $v)
            <table class="table-none-border-min table table-striped table-bordered table-hover" >
                <tbody>
                <tr>
                    <td >姓名</td>
                    <td >{{$v->Name}}</td>
                </tr>
                <tr>
                    <td >性别</td>
                    <td >{{$v->Sex}}</td>
                </tr>
                <tr>
                    <td >年龄</td>
                    <td >{{$v->Age}}</td>
                </tr>
                <tr>
                    <td >家庭住址</td>
                    <td ><p style="word-break: break-all;">{{$v->Province}}.{{$v->City}}.{{$v->District}}.{{$v->DetailedAddr}}</p></td>
                </tr>
                <tr>
                    <td >电话</td>
                    <td >{{$v->Tel}}</td>
                </tr>
                <tr>
                    <td >注册时间</td>
                    <td >{{$v->RegisterDate}}</td>
                </tr>
                <tr>
                    <td >所属跑团</td>
                    <td >
                        @foreach($group_data as $q)
                        <a href="{{url('admin/common')}}/{{$q->GroupID}}">{{$q->GroupName}}</a>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td >总跑量</td>
                    <td >{{$v->TotalRun}}</td>
                </tr>
                <tr>
                    <td >总积分</td>
                    <td >{{$v->TotalPoints}}</td>
                </tr>
            </tbody>
            </table>
            @endforeach
        </div>
    </div>
    <div class="col-md-7 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                月打卡跑量表
            </div>
            <div class="panel-body">
                <div id="morris-line-chart-month"></div>
            </div>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    打卡历史信息表
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" >
                            <thead>
                            <tr>
                                <th>上传图片</th>
                                <th>跑步里程(公里)</th>
                                <th>跑步时长</th>
                                <th>打卡时间</th>
                                <th>积分</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($day_data as $v)
                                <tr>
                                    <td><img src="{{$v->ImgUrl}}" alt="" style="width: 100px;max-height: 120px"></td>
                                    <td>{{$v->Distance}}</td>
                                    <td>{{(int)($v->TimeLong/3600)}}时{{(int)($v->TimeLong/60)}}分{{$v->TimeLong%60}}秒</td>
                                    <td>{{$v->Date}}</td>
                                    <td>{{$v->Point}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="float: right">
                            {{ $day_data->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    <table style="display:none" id="pic-month">
        <thead>
        <tr></tr>
        </thead>
        <tbody>
        @foreach($pic as $val)
            <tr>
            @foreach($val as $v=>$k)
                <td>{{$k}}</td>
            @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
@section('menu')
    <script src="{{asset('/admin/js/userdata.js')}}"></script>
    <script>
        $(".sidebar-nav li.user").addClass('active');
    </script>
@endsection
