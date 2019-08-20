@extends("layouts.main")
@section("title")
    角色管理
    @endsection
@section("css")
    <link rel="stylesheet" href="{{asset("adminlte/css/common.css")}}">
    @endsection
@section("content")

    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                角色管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="{{url("/admin/role")}}"><i class="fa"></i> 角色管理</a></li>
                <li class="active"> 角色编辑</li>
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
                        <form role="form" id="postForm">
                            {{csrf_field()}}

                            <input type="hidden" name="tagId" value=" @if(isset($data['tagId'])){{$data['tagId']}} @endif">

                            <div class="box-body">

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">角色名称</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="name" value="@if(isset($data['name'])) {{$data['name']}} @endif" placeholder="角色名称">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">角色说明</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" description="name" value="@if(isset($data['description'])) {{$data['description']}} @endif" placeholder="角色说明">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">权限选择</label>
                                    @foreach($formatPermission as $group=>$item)
                                        <div>{{$group}}</div>
                                        @foreach($item as $id=>$name)
                                            <input type="checkbox" name="check" data="{{$id}}" value="{{$name}}">
                                            @endforeach
                                        @endforeach
                                </div>


                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <a  class="btn btn-success" onclick="store()">提交</a>
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
            function store(){
                $.ajax({
                    type: 'POST',
                    url: "{{url('admin/article/tags/save')}}",
                    dataType: 'json',
                    data: $('#postForm').serializeArray(),
                    success: function(data){
                        if (data.code == 1){
                            layer.msg(data.message);
                           setTimeout(function () {
                               window.location = "{{url('admin/article/tags')}}";
                           },2000);

                        }else if(data.code ==100)
                        {
                           for(var field in data.message){
                               layer.msg(data.message[field][0]);
                               return ;
                           }
                        }else{
                            layer.msg(data.message);
                        }
                    },
                    error:function(data){

                    }
                });

            }

        </script>

        @endsection
    @endsection
