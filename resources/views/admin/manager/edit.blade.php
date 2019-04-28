@extends("layouts.main")
@section("title")
    管理员编辑
    @endsection
@section("css")
    <link rel="stylesheet" href="{{asset("adminlte/css/manager.css")}}">
    @endsection
@section("content")

    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                管理员管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="{{url("/admin/managers")}}"><i class="fa"></i> 管理员管理</a></li>
                <li class="active">管理员编辑</li>
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
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" id="postForm">
                            {{csrf_field()}}
                            @if(isset($data['mid']))
                                <input type="hidden" name="mid" value="{{$data['mid']}}">
                                @endif
                            <div class="box-body">
                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">账号</label>
                                    <input type="text" class="form-control disabled" @if(isset($data['mid'])) disabled @endif @if(empty($data['mid'])) required="required" @endif id="account" class="edit-box" name="account" value="@if(isset($data['account'])) {{$data['account']}} @endif" placeholder="账号">
                                </div>

                                <div class="form-group edit-box">
                                    <label>所属角色</label>
                                    <select class="form-control" name="roleId" @if(empty($data['mid'])) required="required" @endif>
                                        <option>option 1</option>
                                        <option>option 2</option>
                                        <option>option 3</option>
                                        <option>option 4</option>
                                        <option>option 5</option>
                                    </select>
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputPassword1">密码</label>
                                    <input type="password" class="form-control" class="edit-box" name="password"  @if(empty($data['mid'])) required="required" @endif placeholder="密码">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputPassword1">确认密码</label>
                                    <input type="password" class="form-control" class="edit-box" name="password_confirmation"  @if(empty($data['mid'])) required="required" @endif placeholder="确认密码">
                                </div>


                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <a  class="btn btn-success" onclick="storeManager()">提交</a>
                                <a href="{{url()->previous()}}" class="btn btn-info">返回</a>
                            </div>
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
            function storeManager(){

                $.ajax({
                    type: 'POST',
                    url: "{{url('admin/manager/save')}}",
                    dataType: 'json',
                    data: $('#postForm').serializeArray(),
                    success: function(data){

                    },
                    error:function(data){

                    }
                });

            }

        </script>

        @endsection
    @endsection
