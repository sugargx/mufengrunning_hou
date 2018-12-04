@extends('admin.common.grouptemplate')

@section('title')
    <title>修改管理员密码</title>
@endsection
@section('page')
    <h1 class="page-header">
        沐风跑团 <small>修改密码</small>
    </h1>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    修改密码
                </div>
                <div class="panel-body">
                    @foreach($group_data as $v)
                        <form method="get" action="{{url("group/groupindex/group_pass/$v->Id")}}">
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
                            <label for="user-old-pas" class="control-label">请输入原密码&nbsp;&nbsp;(可在沐风跑步微信小程序中“我的”-“跑团管理”-“电脑端登录信息”查看):</label>
                            <input type="text" class="form-control" id="user-old-pas" name="user-old-pas" required="required"/>
                        </div>
                        <div class="form-group">
                            <label for="user-new-pas" class="control-label">请输入新密码(必须在8-16位之间):</label>
                            <input type="text" class="form-control" id="user-new-pas" name="user-new-pas" required="required"/>
                        </div>
                        <div class="form-group">
                            <label for="user-news-pas" class="control-label">请再次输入新密码:</label>
                            <input type="text" class="form-control" id="user-news-pas" name="user-new-pas_confirmation" required="required"/>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">确定</button>
                            <a class="btn btn-default" href="{{url('admin/index')}}">取消</a>
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
        $(".sidebar-nav li.group_index").addClass('active');
    </script>
@endsection



