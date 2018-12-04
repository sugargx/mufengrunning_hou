@extends('admin.common.template')

@section('title')
    <title>跑团信息</title>
@endsection
@section('page')
    <h1 class="page-header">
        跑团<small>信息</small>
    </h1>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-7 col-sm-12 col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    日打卡跑量表
                </div>
                <div class="panel-body">
                    <div id="morris-line-chart-day"></div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    月打卡跑量表
                </div>
                <div class="panel-body">
                    <div id="morris-area-chart-month"></div>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    跑团信息
                </div>
                @foreach($group_data as $v)
                <table class="table-none-border-min table table-striped table-bordered table-hover">
                    <tbody>
                    <tr>
                        <td style="width: 90px;">跑团名称</td>
                        <td >{{$v->GroupName}}</td>
                    </tr>
                    <tr>
                        <td style="width: 90px;">跑团人数</td>
                        <td >{{$v->PeopleCount}}</td>
                    </tr>
                    <tr>
                        <td style="width: 90px;">跑团地址</td>
                        <td ><p style="word-break: break-all;">{{$v->Province}}.{{$v->City}}.{{$v->District}}.{{$v->DetailedAddr}}</p></td>
                    </tr>
                    <tr>
                        <td style="width: 90px;">团总跑量</td>
                        <td >{{$v->TotalDistance}}</td>
                    </tr>
                    <tr>
                        <td style="width: 90px;">建团时间</td>
                        <td >{{$v->CreateDate}}</td>
                    </tr>
                    <tr>
                        <td style="width: 90px;">跑团图片</td>
                        <td > <img src="{{$v->ImgUrl}}" alt="" style="width: 200px;max-height: 120px"></td>
                    </tr>
                    <tr>
                        <td style="width: 90px;">跑团介绍</td>
                        <td ><p style="word-break: break-all;text-indent: 2em">{{$v->Introduce}}</p></td>
                    </tr>
                    @if(!$adv_data->isEmpty())
                    <tr>
                        <td colspan="2">
                            <div class="btn-group" role="group">
                                <a href="{{url("admin/advertiselook/$v->Id")}}" class="btn btn-warning" ><span class="glyphicon glyphicon-erase"></span> 查看广告</a>
                                <a class="btn btn-danger" href="javascript:" onclick="del_adv({{$v->AdvId}})"><span class="glyphicon glyphicon-trash"></span> 删除广告</a>
                            </div>
                        </td>
                    </tr>
                    @endif
                    </tbody>
                </table>
                @endforeach

            </div>
        </div>

    </div>
     <!-- /. ROW  -->

    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    跑团成员信息表
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>姓名</th>
                                <th>性别</th>
                                <th>年龄</th>
                                <th>家庭住址</th>
                                <th>电话</th>
                                <th>注册时间</th>
                                <th>总跑量</th>
                                <th>总积分</th>
                                <th>类型</th>
                                {{--<th>操作</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user_data as $v)
                                <tr>
                                    <td><a href="{{url('admin/show_user')}}/{{$v->UserMainID}}">{{$v->Name}}</a></td>
                                    <td>{{$v->Sex}}</td>
                                    <td>{{$v->Age}}</td>
                                    <td style="max-width: 420px">{{$v->Province}}.{{$v->City}}.{{$v->District}}.{{$v->DetailedAddr}}</td>
                                    <td>{{$v->Tel}}</td>
                                    {{--将格式为2017-05-07 15:12:00的时间转换为2017-05-07--}}
                                    <td><?php $time=strtotime($v->RegisterDate); echo date('Y-m-d', $time); ?></td>
                                    <td>{{$v->TotalRun}}</td>
                                    <td>{{$v->TotalPoints}}</td>
                                    <td>
                                        @if($v->Type == 1)
                                            <button type="button" class="btn btn-success btn-sm" disabled="disabled">跑团团长</button>
                                        @elseif($v->Type == 2)
                                            <button type="button" class="btn btn-primary btn-sm" disabled="disabled">商家用户</button>
                                        @else
                                            <button type="button" class="btn btn-info btn-sm" disabled="disabled">普通用户</button>
                                        @endif
                                    </td>
                                    {{--<td>--}}
                                        {{--@if($v->Type == 1)--}}
                                            {{--<a class="btn btn-info btn-sm"  disabled="disabled"><i class="fa fa-flag-o fa-fw"></i> 团长</a>--}}
                                        {{--@else--}}
                                            {{--<a class="btn btn-danger btn-sm" href="javascript:" onclick="del_user({{$v->Id}})"><span class="glyphicon glyphicon-trash"></span> 删除</a>--}}
                                        {{--@endif--}}
                                    {{--</td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="float: right">
                            {{ $user_data->links() }}
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
        @foreach($pic_month as $val)
            <tr>
                @foreach($val as $v=>$k)
                    <td>{{$k}}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
    <table style="display:none" id="pic-day">
        <thead>
        <tr></tr>
        </thead>
        <tbody>
        @foreach($pic_day as $val)
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
    <script src="{{asset('/admin/js/groupdata.js')}}"></script>
    <script>
        //删除
        {{--function del_user(user_id) {--}}
            {{--layer.confirm('您确定要将这个用户移出此跑团吗？',{--}}
                {{--btn:['确定','取消']--}}
            {{--},function() {--}}
                {{--$.post("{{url('admin/group/del_user')}}/"+user_id,{'_method':'post','_token':"{{csrf_token()}}"},function (data) {--}}
                    {{--if(data.status==0){--}}

                        {{--layer.msg(data.msg, {time:2000});--}}
                        {{--setTimeout(function(){location.href=location.href;}, 2300);--}}
                    {{--}else {--}}
                        {{--layer.msg(data.msg, {time:2000});--}}
                        {{--setTimeout(function(){location.href=location.href;}, 2300);--}}
                    {{--}--}}
                {{--});--}}
            {{--},function () {--}}
            {{--});--}}
        {{--}--}}
        function del_adv(adv_id) {
            layer.confirm('您确定要删除广告吗？',{
                btn:['确定','取消']
            },function() {
                $.post("{{url('admin/group/del_adv')}}/"+adv_id,{'_method':'post','_token':"{{csrf_token()}}"},function (data) {
                    if(data.status==0){

                        layer.msg(data.msg, {time:2000});
                        setTimeout(function(){location.href=location.href;}, 2300);
                    }else {
                        layer.msg(data.msg, {time:2000});
                        setTimeout(function(){location.href=location.href;}, 2300);
                    }
                });
            },function () {

            });
        }
        $(".sidebar-nav li.group").addClass('active');
    </script>
@endsection
