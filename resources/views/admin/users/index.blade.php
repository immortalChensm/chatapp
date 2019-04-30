@extends("layouts.main")
@section("title")
    用户列表
    @endsection
        @section("css")
        <link rel="stylesheet" href="{{asset("adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css")}}">
        <link rel="stylesheet" href="{{asset("adminlte/css/common.css")}}">
        @endsection
    @section("content")
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                用户管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li class="active">用户列表</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">

                                <div class="input-group input-box ">
                                    <span class="input-group-addon"><i class="fa">用户昵称</i></span>
                                    <input type="text" class="form-control " name="title" placeholder="用户昵称">
                                </div>
                                <div class="input-group input-box ">
                                    <span class="input-group-addon"><i class="fa">传联号</i></span>
                                    <input type="text" class="form-control " name="title" placeholder="传联号">
                                </div>
                                <div class="input-group input-box ">
                                    <span class="input-group-addon"><i class="fa">手机号</i></span>
                                    <input type="text" class="form-control " name="title" placeholder="手机号">
                                </div>
                                <div class="input-group input-box ">
                                    <span class="input-group-addon"><i class="fa">真实姓名</i></span>
                                    <input type="text" class="form-control " name="title" placeholder="真实姓名">
                                </div>


                                <div class="input-group input-box">
                                    <span class="input-group-addon"><i class="fa">性别</i></span>
                                        <select class="form-control" name="tagId">
                                            <option value="">请选择性别</option>
                                                @foreach(['男','女'] as $item)
                                                    <option value="{{$item}}" >{{$item}}</option>
                                                @endforeach

                                        </select>

                                </div>

                                <div class="input-group input-box">
                                    <span class="input-group-addon"><i class="fa">是否认证</i></span>
                                    <select class="form-control" name="tagId">
                                        <option value="">请选择</option>
                                        @foreach(['已认证','未认证'] as $item)
                                            <option value="{{$item}}" >{{$item}}</option>
                                        @endforeach

                                    </select>

                                </div>


                                <div class="search-box" id="search">
                                    <span class="input-group-btn">
                                      <button type="button" class="btn btn-info btn-flat searchBtn">搜索</button>
                                    </span>
                                </div>

                                {{--<button type="button" class="btn bg-navy margin addBtn" onclick="location.href='{{url("/admin/articles/edit")}}'">发布文章</button>--}}


                            </h3>
                        </div>

                        <div class="box-body">
                            <table id="datagrid" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>用户昵称</th>
                                    <th>传联号</th>
                                    <th>用户星级</th>
                                    <th>真实姓名</th>
                                    <th>性别</th>
                                    <th>手机号码</th>
                                    <th>是否认证</th>
                                    <th>注册时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>用户昵称</th>
                                    <th>传联号</th>
                                    <th>用户星级</th>
                                    <th>真实姓名</th>
                                    <th>性别</th>
                                    <th>手机号码</th>
                                    <th>是否认证</th>
                                    <th>注册时间</th>
                                    <th>操作</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

    @section("js")
        <script src="{{asset("adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js")}}"></script>
        <script src="{{asset("adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js")}}"></script>
        <script>
            $(function () {
                var table = $('#datagrid').DataTable({
                    processing:true,
                    columns: [
                        { data:"userId",name:"userId",orderable: true,searchable:false },
                        { data:"name",name:"name",orderable: true,searchable:true },
                        { data:"handNum",name:"handNum",orderable: false,searchable:false },
                        { data:"star",name:"star",orderable: false,searchable:true },
                        { data:"realName",name:"realName",orderable: true,searchable:true },
                        { data:"sex",name:"sex",orderable: true,searchable:true },
                        { data:"mobile",name:"mobile",orderable: true,searchable:true },
                        { data:"isValiated",name:"isValiated",orderable: true,searchable:true },
                        { data:"createdDate",name:"createdDate",orderable: false,searchable:true },
                    ],
                    columnDefs: [ {
                        "targets": 9,
                        "render": function ( data, type, row, meta ) {
                            var BtnHtml = "<button type='button' class='fa fa-edit btn  btn-success btn-sm update' data='"+row.userId+"' data-user='"+row.userType+"'>编辑/查看</button>";
                            BtnHtml+= "  <button type='button' class='fa fa-remove btn  btn-danger btn-sm delete' data='"+row.userId+"' data-title='"+row.title+"' data-user='"+row.userType+"'>移除</button>";
                            return BtnHtml;
                        }
                    } ],
                    hover:true,
                    language: dataGridlanguage,
                    serverSide: true,
                    ajax: {
                        url: '/admin/get/users',
                        type: 'GET'
                    },
                    "searching": false,
                    "lengthMenu": [ 10, 25, 50, 75, 100 ],
                    "pageLength": 10
                });
                window.tableGrid =table;
                    $("#search").on("click",function (e) {
                    var title = $(":input[name=title]").val();
                    var tagId = $(":input[name=tagId]").val();

                    table.ajax.url( '/admin/get/articles?title='+ title+"&tagId="+tagId).load();
                })

            })


            //编辑操作
            $("#datagrid").on("click",".update",function (e) {
               location.href = "/admin/articles/edit/"+$(this).attr("data");
            });

            //移除操作
            $("#datagrid").on("click",".delete",function (e) {
                var title = $(":input[name=title]").val();
                var dateId = $(this).attr("data");
                layer.confirm('您确定要删除('+$(this).attr("data-title")+")该用户？", {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        type: "delete",
                        url: "{{url('/admin/articles/remove/')}}/"+dateId,
                        dataType: 'json',
                        data: {
                            "_token":"{{csrf_token()}}"
                        },
                        success: function(data){
                            if (data.code==1){
                                layer.msg(data.message);
                                setTimeout(function () {
                                    //window.location = "{{url('admin/articles')}}";
                                    window.tableGrid.ajax.url( '/admin/get/articles?title='+ title+"&tagId="+tagId).load();
                                },2000);
                            }else{
                                layer.msg(data.message);
                            }
                        },
                        error:function(data){

                        }
                    });

                }, function(){

                });
            });

        </script>
        @endsection

  @endsection