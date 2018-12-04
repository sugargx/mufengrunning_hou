@extends('admin.common.template')

@section('title')
    <title>跑团管理</title>
@endsection

@section('page')
    <h1 class="page-header">
        跑团 <small>信息管理</small>
    </h1>
@endsection
@section('content')


    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    跑团信息表
                    <div style="float: right;margin: -3px 5px 0px 0px;">
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{url('admin/advertiselook/0')}}" class="btn btn-info"><i class="fa fa-pencil-square-o fa-fw"></i> 查看默认广告位</a>
                            <a href="{{url('admin/advertiseindex/0')}}" class="btn btn-warning"><i class="fa fa-pencil-square-o fa-fw"></i> 修改默认广告位</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        {{--{{$data->links()}} 控制分页--}}
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>名称</th>
                                <th style="width: 160px">地址</th>
                                <th>图片</th>
                                <th>人数</th>
                                <th>总跑量</th>
                                <th>建团时间</th>
                                <th>跑团状态</th>
                                <th>广告位</th>
                                <th style="width: 160px">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="6">
                                    <form action="{{url('admin/find')}}" method="get">
                                    {{csrf_field()}}
                                        <div class="col-sm-5" >
                                            <input type="text" class="form-control input-sm" id="find-name" name="find-name" placeholder="请输入查找的跑团名">
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control input-sm" id="find-city" name="find-city" placeholder="请输入查找的跑团所在城市">
                                        </div>
                                        <div class="btn-group btn-group-sm col-sm-2" role="group">
                                            <button class="btn btn-warning" type="submit" name="find_name"><i class="fa fa-search" aria-hidden="true"></i> 查找</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @foreach($data as $v)
                                <tr>
                                    <td><a href="{{url('admin/common')}}/{{$v->Id}}"> {{$v->GroupName}}</a></td>
                                    <td class="td-adress">{{$v->Province}}.{{$v->City}}.{{$v->District}}.{{$v->DetailedAddr}}</td>
                                    <td><img src="{{$v->ImgUrl}}" alt="" style="width: 100px;max-height: 60px"></td>
                                    <td>{{$v->PeopleCount}}</td>
                                    <td>{{$v->TotalDistance}}</td>
                                    {{--将格式为2017-05-07 15:12:00的时间转换为2017-05-07--}}
                                    <td><?php $time=strtotime($v->CreateDate); echo date('Y-m-d', $time); ?></td>
                                    <td>
                                        @if($v->State == 0)
                                            <button class="btn-sm btn-warning btn" disabled="disabled"><i class="fa fa-spinner" aria-hidden="true"></i> 待审核</button>
                                        @elseif($v->State == 1)
                                            <button class="btn-sm btn-success btn" disabled="disabled"><i class="fa fa-smile-o" aria-hidden="true"></i> 审核通过</button>
                                        @elseif($v->State == 2)
                                            <a class="btn-sm btn-info btn" href="javascript:" onclick="use({{$v->Id}})"><i class="fa fa-check-square-o" aria-hidden="true"></i> 解除禁用</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($v->AdvState == 0)
                                            <button  class="btn btn-default btn-sm" disabled="disabled"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> 未有广告</button>
                                        @elseif($v->AdvState == 1)
                                            <a href="{{url("admin/advertiseother/$v->Id")}}" class="btn btn-warning btn-sm"><i class="fa fa-spinner" aria-hidden="true"></i> 待审核</a>
                                        @elseif($v->AdvState == 2)
                                            <button  class="btn btn-success btn-sm" disabled="disabled"><i class="fa fa-smile-o" aria-hidden="true"></i> 审核通过</button>
                                        @endif
                                    </td>
                                    <td>
                                        @if($v->State == 0)
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a class="btn btn-success" href="javascript:" onclick="pass({{$v->Id}})"><i class="fa fa-check" aria-hidden="true"></i> 通过</a>
                                                <a class="btn btn-warning" href="javascript:" onclick="no({{$v->Id}})"><i class="fa fa-times" aria-hidden="true"></i> 不通过</a>
                                            </div>
                                            <a class="btn btn-danger btn-group btn-group-sm" href="javascript:" onclick="del({{$v->Id}})"><i class="fa fa-trash" aria-hidden="true"></i> 删除</a>
                                            @elseif($v->State == 1)
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a class="btn btn-primary" href="javascript:" onclick="disuse({{$v->Id}})"><i class="fa fa-ban" aria-hidden="true"></i> 禁用</a>
                                                <a class="btn btn-danger" href="javascript:" onclick="del({{$v->Id}})"><i class="fa fa-trash" aria-hidden="true"></i> 删除</a>
                                            </div>
                                            @elseif($v->State == 2)
                                                <a class="btn btn-danger btn-sm" href="javascript:" onclick="del({{$v->Id}})"><i class="fa fa-trash" aria-hidden="true"></i> 删除</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
        function pass(id) {
            layer.confirm('是否确定通过此跑团的审核',{
                btn:['确定','取消']
            },function() {
                $.post("{{url('admin/group')}}/"+id,{'_method':'get','_token':"{{csrf_token()}}"},function (data) {

                        layer.msg(data.msg, {time:2000});
                    setTimeout(function(){location.href=location.href;}, 2300);
                });
            },function () {
            });
        }
        function no(id) {
            layer.confirm('是否确定不通过此跑团的审核',{
                btn:['确定','取消']},function() {
                $.post("{{url('admin/group/nopass')}}/"+id,{'_method':'get','_token':"{{csrf_token()}}"},function (data) {
                    layer.msg(data.msg, {time:2000});
                    setTimeout(function(){location.href=location.href;}, 2000);
                });
                },function () {
            });
        }
        function disuse(id) {
            layer.confirm('是否禁用此跑团',{
                btn:['确定','取消']
            },function() {
                $.post("{{url('admin/group/disuse')}}/"+id,{'_method':'get','_token':"{{csrf_token()}}"},function (data) {

                    layer.msg(data.msg, {time:2000});
                    setTimeout(function(){location.href=location.href;}, 2300);
                });
            },function () {
            });
        }
        function use(id) {
            layer.confirm('是否解除此跑团的禁用',{
                btn:['确定','取消']
            },function() {
                $.post("{{url('admin/group/use')}}/"+id,{'_method':'get','_token':"{{csrf_token()}}"},function (data) {

                    layer.msg(data.msg, {time:2000});
                    setTimeout(function(){location.href=location.href;}, 2300);
                });
            },function () {
            });
        }
        function del(id) {
            layer.confirm('您确定要删除这个跑团吗？',{
                btn:['确定','取消']
            },function() {
                $.post("{{url('admin/group')}}/"+id,{'_method':'DELETE','_token':"{{csrf_token()}}"},function (data) {
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

