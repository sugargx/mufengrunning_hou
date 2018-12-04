@extends('admin.common.template')

@section('title')
    <title>广告位审核</title>
    <style>
        .form-group{
            margin: 15px;
        }
    </style>
@endsection
@section('page')
    <h1 class="page-header">
        沐风跑团 <small>广告位审核</small>
    </h1>
@endsection
@section('content')

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    广告位审核
                </div>
                @foreach($data as $v)
                    <form method="post" action="{{url("admin/advertise/addother/$v->GroupID")}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group ">
                            <label for="adv-title" class="control-label">标题:</label>
                            <input type="text" class="form-control" id="adv-title" name="adv-title"  disabled value="{{$v->AdvTitle}}">
                        </div>
                        <div class="form-group">
                            <label>内容</label>
                            <textarea class="form-control" rows="3" name="adv-control"  disabled>{{$v->Content}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="user-new-pas" class="control-label">广告存在的天数（只填数字）:</label>
                            <input type="text" class="form-control" id="adv-day" name="adv-day"  disabled value="{{$v->ExistDate}}">
                        </div>
                        <div class="form-group">
                            <label for="adv-InputFile">广告图片</label>

                            <img id="input-adv-img" src="{{$v->AdvImgUrl}}" style="width: 240px;max-height: 240px" >
                        </div>
                        <div class="form-group">
                            <label for="advInputFile">二维码图片</label>

                            <img id="input-adv-QR" src="{{$v->AdvQRUrl}}" style="width: 120px;height: 120px">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success ">通过审核</button>
                            <a class="btn btn-default " href="javascript:" onclick="nopass({{$v->GroupID}})"> 不通过</a>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('menu')
    <script>
        function nopass(groupid) {
            layer.confirm('是否确定不通过此广告位的审核',{
                btn:['确定','取消']
            },function() {
                $.post("{{url('admin/advertise/advertisenopass')}}/"+groupid,{'_method':'get','_token':"{{csrf_token()}}"},function (data) {

                    layer.msg(data.msg, {time:2000});
                    setTimeout(function(){history.back(-1);}, 2000);
                });
            },function () {
            });
        }
        $(".sidebar-nav li.adv").addClass('active');
    </script>
@endsection


