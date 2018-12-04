@extends('admin.common.template')

@section('title')
    <title>轮播图管理</title>
    <link rel="stylesheet" type="text/css" href="{{asset('/org/uploadify/uploadify.css')}}">
@endsection

@section('page')
    <h1 class="page-header">
        轮播图 <small>管理页面</small>
    </h1>
@endsection
@section('content')
    <div class="modal fade add-carousel" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">增加轮播图</h4>
                </div>
                <form action="{{url('admin/carousel')}}" method="post">
                    {{csrf_field()}}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="carousel-id" class="control-label">请输入图片id（唯一）:</label>
                        <input type="text" class="form-control" id="carousel-id" name="carousel-id">
                    </div>
                    <div class="form-group">
                        <label for="carousel-name" class="control-label">请输入图片名称:</label>
                        <input type="text" class="form-control" id="carousel-name" name="carousel-name">
                    </div>
                    <div class="form-group">
                        <label for="carouselInputFile">上传图片(长：宽 = 5:2)
                            @if(session('msg'))
                                <span style="margin-left: 30px; color: #ff4500">{{session('msg')}}</span>
                            @endif
                        <strong style="color: #ff4500">(*必填)</strong></label>
                        <input type="text" class="form-control" name="carousel-img" style="display: none">
                        <input type="file" id="input-img" name="input-img">
                        <img id="input-car" src="" alt="" style="width: 200px;max-height: 120px">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">确定上传</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                </div>
            </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    轮播图信息表
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>标题</th>
                                    <th>图片</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="3" ></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button class="btn btn-success" data-toggle="modal" data-target=".add-carousel"><span class="glyphicon glyphicon-plus"></span> 添加</button>
                                    </div>
                                </td>
                            </tr>
                            @foreach($data as $h)
                                <tr>
                                    <td>{{$h->Id}}</td>
                                    <td>{{$h->CarName}}</td>
                                    <td><img src="{{$h->CarUrl}}" alt="" style="width: 100px;max-height: 60px"></td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a class="btn btn-danger" href="javascript:" onclick="del({{$h->Id}})"><span class="glyphicon glyphicon-trash"></span> 删除</a>
                                        </div>
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
    <script src="{{asset('/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
    <script>
        function del(id) {
            layer.confirm('您确定要删除这个轮播图吗？',{
                btn:['确定','取消']
            },function() {
                $.post("{{url('admin/carousel/del')}}/"+id,{'_method':'post','_token':"{{csrf_token()}}"},function (data) {
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
        //nav
        $(".sidebar-nav li.advertise").addClass('active');
        //uploadify
        <?php $timestamp = time();?>
        $('#input-img').uploadify({
            'buttonText':'轮播图上传',
            'formData'     : {
                'timestamp' : '<?php echo $timestamp;?>',
                '_token'     : "{{csrf_token()}}"
            },
            'swf'      : "{{asset(url('/org/uploadify/uploadify.swf'))}}",
            'uploader' : "{{asset(url('admin/common'))}}",
            'onUploadSuccess' : function(file, data, response) {
                $('input[name=carousel-img]').val(data);
                $('#input-car').attr('src',data);
            }
        });
    </script>
@endsection

