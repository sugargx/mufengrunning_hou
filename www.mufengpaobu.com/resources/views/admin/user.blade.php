@extends('admin.common.template')

@section('title')
    <title>用户管理</title>
@endsection

@section('page')
    <h1 class="page-header">
        用户 <small>信息管理</small>
    </h1>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    用户信息表
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="max-width: 110px">昵称</th>
                                <th>姓名</th>
                                <th>性别</th>
                                <th>年龄</th>
                                <th style="width: 160px">家庭住址</th>
                                <th>电话</th>
                                <th>注册时间</th>
                                <th>总跑量(公里)</th>
                                <th>总积分</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="5"></td>
                                <td colspan="6">
                                    <form action="{{url('admin/user/create')}}" method="get">
                                        {{csrf_field()}}
                                        <div class="col-sm-5" >
                                            <input type="text" class="form-control input-sm" id="find-name" name="find-name" placeholder="请输入查找的用户姓名">
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control input-sm" id="find-city" name="find-city" placeholder="请输入查找的用户所在城市">
                                        </div>
                                        <div class="btn-group btn-group-sm col-sm-2" role="group">
                                            <button class="btn btn-warning" type="submit" name="find_name"><i class="fa fa-search" aria-hidden="true"></i> 查找</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @foreach($data as $v)
                            <tr>
                                <td>{{$v->NickName}}</td>
                                <td><a href="{{url('admin/show_user')}}/{{$v->Id}}" >{{$v->Name}}</a></td>
                                <td>{{$v->Sex}}</td>
                                <td>{{$v->Age}}</td>
                                <td class="td-adress">{{$v->Province}}.{{$v->City}}.{{$v->District}}.{{$v->DetailedAddr}}</td>
                                <td>{{$v->Tel}}</td>
                                {{--将格式为2017-05-07 15:12:00的时间转换为2017-05-07--}}
                                <td><?php $time=strtotime($v->RegisterDate); echo date('Y-m-d', $time); ?></td>
                                <td>{{$v->TotalRun}}</td>
                                <td>{{$v->TotalPoints}}</td>
                                {{--<td>--}}
                                    {{--@if($v->Type == 0 || $v->Type == 3 || $v->Type == -1)--}}
                                        {{--<button type="button" class="btn btn-info btn-sm" disabled="disabled">普通用户</button></td>--}}
                                    {{--@elseif($v->Type == 1)--}}
                                        {{--<td><button type="button" class="btn btn-success btn-sm" disabled="disabled">跑团团长</button></td>--}}
                                    {{--@elseif($v->Type == 2 || $v->Type == 5)--}}
                                        {{--<td><button type="button" class="btn btn-primary btn-sm" disabled="disabled">商家用户</button>--}}
                                    {{--@endif--}}
                                {{--</td>--}}
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-danger" href="javascript:" onclick="del_user({{$v->Id}})"><i class="fa fa-trash" aria-hidden="true"></i> 删除</a>
                                    </div>
                                </td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{--限制加入跑团--}}
                        <div>
                            <div class="form-inline" >
                                <div class="form-group" style="float: left;">
                                    <label for="group-num">当前每个用户可以加入跑团的数目：</label>&nbsp;&nbsp;
                                    <span style="width: 40px;" type="text" class="form-control input-sm" id="group-num" disabled >{{$limit->GroupLimit}}</span>&nbsp;&nbsp;
                                    {{--@if($limit->GroupLimit>=2)--}}
                                        {{--<button class="btn btn-danger btn-sm" disabled="disabled"><span class="glyphicon glyphicon-plus"></span> 添加</button>--}}
                                    {{--@else--}}
                                        {{--<button href="javascript:" onclick="add_group()" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-plus"></span> 添加</button>--}}
                                    {{--@endif--}}
                                </div>
                            </div>
                        </div>
                        <div style="float: right">
                            {{ $data->links() }}
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
        function add_group() {
            layer.confirm('您确定要增加加入跑团的限制吗？', {
                btn:['确定','取消']
            },function () {
                    window.location.href="{{url('admin/limit')}}";
                })
        }
        function del_user(Id) {
            layer.confirm('您确定要删除这个用户吗？',{
                btn:['确定','取消']
            },function() {
                $.post("{{url('admin/user')}}/"+Id,{'_method':'DELETE','_token':"{{csrf_token()}}"},function (data) {
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
        $(".sidebar-nav li.user").addClass('active');
    </script>
@endsection

