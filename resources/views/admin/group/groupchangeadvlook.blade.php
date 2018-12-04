@extends('admin.common.template')

@section('title')
    <title>广告位查看</title>
    <style>
        .form-group{
            margin: 15px;
        }
    </style>
@endsection
@section('page')
    <h1 class="page-header">
        沐风跑团 <small>广告位查看</small>
    </h1>
@endsection
@section('content')

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    广告位查看
                </div>
                @foreach($adv_data as $v)
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
                            <a href="JavaScript:history.back(-1)" class="btn btn-primary btn-lg">确定</a>
                        </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('menu')
    <script>
        $(".sidebar-nav li.adv").addClass('active');
    </script>
@endsection


