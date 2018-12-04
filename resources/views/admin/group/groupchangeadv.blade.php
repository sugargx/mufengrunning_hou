@extends('admin.common.grouptemplate')

@section('title')
    <title>广告位上传</title>
@endsection
@section('page')
    <h1 class="page-header">
        沐风跑团 <small>广告位上传</small>
    </h1>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    上传广告位
                </div>
                <div class="panel-body">
                    @foreach($group_data as $v)
                    <form method="post" action="{{url("group/groupindex/group_adv/$v->Id")}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <p style="color: #ff4500">
                            @if(count($errors)>0)
                                @if(is_object($errors))
                                    @foreach($errors->all() as $error)
                                        {{$error}}
                                    @endforeach
                                @else
                                    {{$errors}}
                                @endif
                            @endif
                        </p>
                        <div class="form-group">
                            <label for="adv-title" class="control-label">请输入标题:</label>
                            <input type="text" class="form-control" id="adv-title" name="adv-title" required>
                        </div>
                        <div class="form-group">
                            <label>请输入内容</label>
                            <textarea class="form-control" rows="3" name="adv-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="adv-InputFile">上传广告图片(长：宽 = 5:2)
                               </label>
                            <input type="file" id="advimg" name="advimg">
                            {{--<img id="input-adv-img" src=""  style="width: 100px;max-height: 60px" >--}}
                        </div>
                        <div class="form-group">
                            <label for="advInputFile">上传二维码图片(长：宽 = 1:1)
                               </label>
                            {{--<input type="text" class="form-control" name="adv-QR-val" style="display: none">--}}
                            <input type="file" id="advQR" name="advQR">
                            {{--<img id="input-adv-QR" src=""  style="width: 100px;max-height: 60px">--}}
                        </div>
                        <div class="form-group">
                            <label for="user-new-pas" class="control-label">请输入此广告存在的天数（只填数字）:</label>
                            <input type="text" class="form-control" id="adv-day" name="adv-day" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">提交</button>
                            <a class="btn btn-default" href="JavaScript:history.back(-1)">取消</a>
                        </div>
                    </form>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('menu')
    <script>
        $(".sidebar-nav li.group_adv").addClass('active');
    </script>
@endsection


