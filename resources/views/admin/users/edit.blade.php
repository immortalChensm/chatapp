@extends("layouts.main")
@section("title")
    用户编辑
    @endsection
@section("css")
    <link rel="stylesheet" href="{{asset("adminlte/css/common.css")}}">
    @endsection
@section("content")

    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                用户管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="{{url("/admin/users")}}"><i class="fa"></i> 用户管理</a></li>
                <li class="active">用户编辑</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            {{--<h3 class="box-title">Quick Example</h3>--}}
                        </div>
                        <form class="form-horizontal">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">用户头像</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control"  style="border: none" value="@if(isset($data['headImgUrl'])) {{$data['headImgUrl']}} @endif">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">传联号</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" style="border: none" value="@if(isset($data['handNum'])) {{$data['handNum']}} @endif">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">用户昵称</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" style="border: none" value="@if(isset($data['name'])) {{$data['name']}} @endif">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">用户星级</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" style="border: none"  value="@if(isset($data['star'])) {{$data['star']}} @endif">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">真实姓名</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" style="border: none"   value="@if(isset($data['realName'])) {{$data['realName']}} @endif">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">性别</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" style="border: none"   value="@if(isset($data['sex'])) {{$data['sex']}} @endif">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">手机号码</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" style="border: none"  value="@if(isset($data['mobile'])) {{$data['mobile']}} @endif">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">是否认证</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" style="border: none"  value="@if(isset($data['isValiated'])) {{$data['isValiated']}} @endif">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">账户余额</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" style="border: none"  value="@if(isset($data['money'])) {{$data['money']}} @endif">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">船票余额</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" style="border: none"  value="@if(isset($data['shipNumber'])) {{$data['shipNumber']}} @endif">
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                {{--<a  class="btn btn-success" onclick="store()">提交</a>--}}
                                <a href="{{url()->previous()}}" class="btn btn-info">返回</a>
                            </div>
                            <!-- /.box-footer -->
                        </form>
</div>


</div>

</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
            @section("js")
            <script>


            </script>

            @endsection
            @endsection
