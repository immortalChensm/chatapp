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

                            <input type="hidden" name="id" value=" @if(isset($data['id'])){{$data['id']}} @endif">

                            <div class="box-body">

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">角色名称</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="name" value="@if(isset($data['name'])) {{$data['name']}} @endif" placeholder="角色名称">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">角色说明</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="description" value="@if(isset($data['description'])) {{$data['description']}} @endif" placeholder="角色说明">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">权限选择</label>
                                    {{--@foreach($formatPermission as $group=>$item)--}}
                                        {{--<div>--}}
                                            {{--<input type="checkbox" style="margin: 10px 5px;"  value="{{$group}}" >{{$group}}--}}
                                        {{--</div>--}}

                                        {{--<div style="margin:1px 0px 1px 15px;">--}}
                                        {{--@foreach($item as $id=>$name)--}}
                                            {{--<input type="checkbox" style="margin: 10px 5px;" name="permissionIds[]" data="{{$id}}" value="{{$id}}" >{{$name}}--}}
                                         {{--@endforeach--}}
                                        {{--</div>--}}
                                        {{--@endforeach--}}
                                    @foreach($formatPermission as $group=>$item)
                                    <div class="auth-box">
                                        <p><label><input class="checkbox-all" type="checkbox" value="all">{{$group}}</label></p>
                                        @foreach($item as $id=>$name)
                                        <label><input class="checkboxs" type="checkbox" name="permissionIds[]" value="{{$id}}" @if(in_array($id,$data['permissionIds'])) checked="true" @endif>{{$name}}</label>
                                        @endforeach
                                    </div>
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
                    url: "{{url('admin/role/save')}}",
                    dataType: 'json',
                    data: $('#postForm').serializeArray(),
                    success: function(data){
                        if (data.code == 1){
                            layer.msg(data.message);
                           setTimeout(function () {
                               window.location = "{{url('admin/role')}}";
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

            //全选函数
            $('.checkbox-all').click(function(){
                if($(this).prop('checked')){
                    $(this).parents(".auth-box").find('.checkboxs').prop('checked',true);
                }else{
                    $(this).parents(".auth-box").find('.checkboxs').prop('checked',false);
                }
            });


            //单选函数
            $('.checkboxs').change(function () {
                var optionsLength = $(this).parents(".auth-box").find('.checkboxs').length;
                var checkedLength = $(this).parents(".auth-box").find('.checkboxs:checked').length;
                if (checkedLength==optionsLength) {
                    $(this).parents(".auth-box").find('.checkbox-all').prop('checked',true);
                }else {
                    $(this).parents(".auth-box").find('.checkbox-all').prop('checked',false);
                }
            });

        </script>

        @endsection
    @endsection
