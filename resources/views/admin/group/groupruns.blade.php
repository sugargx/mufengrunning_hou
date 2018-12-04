@extends('admin.common.grouptemplate')

@section('title')
    <title>成员跑量</title>
    <style>
        .input_data{
            width:60px;
        }
    </style>
@endsection
@section('page')
    <h1 class="page-header">
        本周打卡 <small>信息</small>
    </h1>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    本周打卡信息表
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <p style="color: #ff4500">
                            @if(count($errors)>0)
                                {{$errors}}
                            @endif
                        </p>
                        <table class="table table-striped table-bordered table-hover" >
                            <thead>
                            <tr>
                                <th>姓名</th>
                                <th>上传图片</th>
                                <th>跑步里程(公里)</th>
                                <th>跑步时长</th>
                                <th style="width: 200px;">打卡时间</th>
                                <th style="width: 110px;">此次积分</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                @foreach($group_data as $v)
                                <td colspan="4" style="line-height: 30px;margin-top:10px;" >
                                    <form action="{{url("group/excel_month/$v->Id")}}" method="get">
                       <div style="float: left;">请输入开始时间：</div>
                        <div style="float: left;">
                              <input name="time_begin1" class="form-control input-sm" type="number" maxlength="4" style="float: left; width: 65px;" placeholder="例如2017" value="2017">&nbsp;<span style="font-weight: bolder;">年</span>&nbsp;
                        </div>
                        <div style="float: left;" >
                             <input name="time_begin2" class="input_data form-control input-sm" type="number" maxlength="4" style="float: left;" placeholder="例如5" value="1">&nbsp;<span style="font-weight: bolder;">月</span>&nbsp;
                        </div>
                            <div style="float: left;" >
                                <input name="time_begin3" class="input_data form-control input-sm" type="number" maxlength="4" placeholder="例如31" style="float: left;" value="1">&nbsp;<span style="font-weight: bolder;">日</span>&nbsp;
                        </div>
                   
                     <div style="float: left;margin-left: 20px;">请输入结束时间：  </div>
                        <div style="float: left;">
                              <input name="time_end1" class="form-control input-sm" type="number" maxlength="4" style="float: left; width: 65px;" value="2017">&nbsp;<span style="font-weight: bolder;">年</span>&nbsp;
                        </div>
                        <div style="float: left;" >
                             <input name="time_end2" class="input_data form-control input-sm" type="number" maxlength="4" style="float: left;" value="1">&nbsp;<span style="font-weight: bolder;">月</span>&nbsp;
                        </div>
                            <div style="float: left;" >
                                <input name="time_end3" class="input_data form-control input-sm" type="number" maxlength="4" style="float: left;" value="1">&nbsp;<span style="font-weight: bolder;">日</span>&nbsp;
                        </div>
                           
                        <div>
                        <button class="btn btn-xs btn-success" style="float :right;margin-top: 5px;margin-right: 40px;" > 下载跑量记录</button></div>
                                    </form>
                                </td>

                                <td colspan="2">
                                    <form action="{{url("group/excel_peopleWeek/$v->Id")}}" method="get">
                                        {{csrf_field()}}
                                            <input type="text" class="form-control input-sm" id="excel-name" name="excel-name" style="width: 130px; float: left"placeholder="请输入跑团成员姓名">
                                        <button class="btn btn-warning btn-xs" type="submit" name="find_name" style="float: left;margin-left: 20px"><i class="fa fa-cloud-download" aria-hidden="true"></i> 下载个人月跑量表</button>
                                    </form>
                                </td>
                                @endforeach
                            </tr>
                            @foreach($day_data as $v)
                                <tr>
                                    <td>{{$v->Name}}</td>
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

@endsection
@section('menu')
  <script type="text/javascript">

$(function (){
 $(".sidebar-nav li.group_runs").addClass('active')
    $(".jcDate").jcDate({                          

            IcoClass : "jcDateIco",

            Event : "click",

            Speed : 100,

            Left : 0,

            Top : 28,

            format : "-",

            Timeout : 100

    });

});



        </script>
 
@endsection



