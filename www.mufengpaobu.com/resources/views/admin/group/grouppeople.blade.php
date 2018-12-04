@extends('admin.common.grouptemplate')

@section('title')
    <title>跑团成员</title>
@endsection
@section('page')
    <h1 class="page-header">
        跑团成员 <small>信息</small>
    </h1>
@endsection
@section('content')
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
                                <th>注册时间</th>
                                <th>电话</th>
                                <th>总跑量</th>
                                <th>总积分</th>
                                <th>类型</th>
                                <th>积分减扣</th>
                                {{--<th>操作(入团申请)</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user_data as $v)
                                <tr>
                                    <td>{{$v->Name}}</td>
                                    <td>{{$v->Sex}}</td>
                                    <td>{{$v->Age}}</td>
                                    <td><?php $time=strtotime($v->RegisterDate); echo date('Y-m-d', $time); ?></td>
                                    <td>{{$v->Tel}}</td>
                                    <td>{{$v->TotalRun}}</td>
                                    <td>{{$v->TotalPoints}}</td>
                                    <td>
                                        @if($v->Type == 0 || $v->Type == 3)
                                            <button type="button" class="btn btn-info btn-sm" disabled="disabled">普通用户</button>
                                        @elseif($v->Type == 1)
                                            <button type="button" class="btn btn-success btn-sm" disabled="disabled">跑团团长</button>
                                        @elseif($v->Type == 2)
                                            <button type="button" class="btn btn-primary btn-sm" disabled="disabled">商家用户</button>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control input-sm" id="points_down" name="points_down" placeholder="请输入减扣的积分" required>
                                        </div>
                                        <a type="submit" class=" btn btn-danger btn-sm" href="javascript:" onclick="points_down({{$v->Id}})"><i class="fa fa-minus-square-o" aria-hidden="true"></i> 减少</a>
                                    </td>
                                    {{--<td>--}}
                                        {{--@if($v->Type == 1)--}}
                                            {{--<a class="btn btn-info btn-sm"  disabled="disabled"><i class="fa fa-flag-o fa-fw"></i> 团长</a>--}}
                                        {{--@elseif($v->Type == 3 || $v->Type == 5 )--}}
                                            {{--<div class="btn-group btn-group-sm" role="group">--}}
                                                {{--<a class="btn btn-success" href="javascript:" onclick="pass({{$v->Id}})"><span class="glyphicon glyphicon-ok"></span> 同意</a>--}}
                                                {{--<a class="btn btn-danger" href="javascript:" onclick="nopass({{$v->Id}})" ><span class="glyphicon glyphicon-remove"></span> 拒绝</a>--}}
                                            {{--</div>--}}
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
@endsection
@section('menu')
    <script>
        //积分减扣
        function points_down(user_id) {
            var points = $("#points_down").val();
            if(!points){
                points=0;
            }
            layer.confirm('您确定要减扣这个用户的积分吗？',{
                btn:['确定','取消']
            },function() {
                $.post("{{url('group/groupindex/points_down')}}/"+user_id+"/"+points,{'_method':'post','_token':"{{csrf_token()}}"},function (data) {
                    if(data.status==0){

                        layer.msg(data.msg, {time:2000});setTimeout(function(){location.href=location.href;}, 2300);
                    }else {
                        layer.msg(data.msg, {time:2000});setTimeout(function(){location.href=location.href;}, 2300);
                    }
                });
            },function () {
            });
        }
        {{--//删除--}}
        {{--function del_user(user_id) {--}}
            {{--layer.confirm('您确定要将这个用户移出此跑团吗？',{--}}
                {{--btn:['确定','取消']--}}
            {{--},function() {--}}
                {{--$.post("{{url('group/groupindex/del_user')}}/"+user_id,{'_method':'post','_token':"{{csrf_token()}}"},function (data) {--}}
                    {{--if(data.status==0){--}}

                        {{--layer.msg(data.msg, {time:2000});setTimeout(function(){location.href=location.href;}, 2300);--}}
                    {{--}else {--}}
                        {{--layer.msg(data.msg, {time:2000});setTimeout(function(){location.href=location.href;}, 2300);--}}
                    {{--}--}}
                {{--});--}}
            {{--},function () {--}}
            {{--});--}}
        {{--}--}}
        {{--//同意入团--}}
        {{--function pass(user_id) {--}}
            {{--layer.confirm('您确定此用户加入跑团吗？',{--}}
                {{--btn:['确定','取消']--}}
            {{--},function() {--}}
                {{--$.post("{{url('group/groupindex/pass')}}/"+user_id,{'_method':'get','_token':"{{csrf_token()}}"},function (data) {--}}
                    {{--if(data==0){--}}
                        {{--layer.msg(data.msg, {time:2000});setTimeout(function(){location.href=location.href;}, 2300);--}}
                    {{--}else {--}}
                        {{--layer.msg(data.msg, {time:2000});setTimeout(function(){location.href=location.href;}, 2300);--}}
                    {{--}--}}

                {{--});--}}
            {{--},function () {--}}
            {{--});--}}
        {{--}--}}
        {{--//不同意入团--}}
        {{--function nopass(user_id) {--}}
            {{--layer.confirm('您确定不允许此用户加入跑团吗？',{--}}
                {{--btn:['确定','取消']--}}
            {{--},function() {--}}
                {{--$.post("{{url('group/groupindex/nopass')}}/"+user_id,{'_method':'get','_token':"{{csrf_token()}}"},function (data) {--}}
                    {{--if(data==0){--}}
                        {{--layer.msg(data.msg, {time:2000});setTimeout(function(){location.href=location.href;}, 2300);--}}
                    {{--}else {--}}
                        {{--layer.msg(data.msg, {time:2000});setTimeout(function(){location.href=location.href;}, 2300);--}}
                    {{--}--}}

                {{--});--}}
            {{--},function () {--}}
            {{--});--}}
        {{--}--}}
        $(".sidebar-nav li.group_people").addClass('active');
    </script>
@endsection



