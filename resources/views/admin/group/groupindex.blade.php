@extends('admin.common.grouptemplate')

@section('title')
    <title>跑团管理</title>
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
                    <table class="table-none-border-min table table-striped table-bordered table-hover" >
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
                        <tr>
                            <td colspan="2">
                                @if(!$adv_data->isEmpty())
                                    <a href="{{url("group/groupindex/advlook/$v->Id")}}" class="btn btn-success" ><i class="fa fa-search" aria-hidden="true"></i> 查看广告</a>
                                @else
                                    <a href="{{url("group/groupindex/group_adv/$v->Id")}}" class="btn btn-success" ><i class="fa fa-cloud-upload" aria-hidden="true"></i> 上传广告</a>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
    </div>
    <!-- /. ROW  -->

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
        function del_adv(adv_id) {
            layer.confirm('您确定要删除广告吗？',{
                btn:['确定','取消']
            },function() {
                $.post("{{url('admin/group/del_adv')}}/"+adv_id,{'_method':'post','_token':"{{csrf_token()}}"},function (data) {
                    if(data.status==0){

                        layer.msg(data.msg, {time:2000});setTimeout(function(){location.href=location.href;}, 2300);
                    }else {
                        layer.msg(data.msg, {time:2000});setTimeout(function(){location.href=location.href;}, 2300);
                    }
                });
            },function () {

            });
        }
        $(".sidebar-nav li.group_index").addClass('active');
    </script>
@endsection




