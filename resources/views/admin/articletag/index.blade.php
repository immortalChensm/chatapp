@extends("layouts.main")
@section("title")
    文章标签列表
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
                文章标签管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li class="active">文章标签列表</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">

                                <div class="input-group input-box input-max-box">
                                    <span class="input-group-addon"><i class="fa">标签名称</i></span>
                                    <input type="text" class="form-control " name="name" placeholder="标签名称">
                                </div>


                                <div class="search-box" id="search">
                                    <span class="input-group-btn">
                                      <button type="button" class="btn btn-info btn-flat searchBtn">搜索</button>
                                    </span>
                                </div>

                                <button type="button" class="btn bg-navy margin addBtn" onclick="location.href='{{url("/admin/article/tags/edit")}}'">添加标签</button>


                            </h3>
                        </div>

                        <div class="box-body">
                            <table id="datagrid" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>标签名称</th>
                                    <th>添加时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>标签名称</th>
                                    <th>添加时间</th>
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
                        { data:"tagId",name:"tagId",orderable: true,searchable:false },
                        { data:"name",name:"name",orderable: true,searchable:true },
                        { data:"created_at",name:"created_at"}
                    ],
                    columnDefs: [ {
                        "targets": 3,
                        "render": function ( data, type, row, meta ) {

                            var BtnHtml = "<button type='button' class='btn  btn-success btn-sm update' data='"+row.tagId+"'>修改</button>";
                            BtnHtml+= "  <button type='button' class='btn  btn-danger btn-sm delete' data='"+row.tagId+"' data-name='"+row.name+"'>移除</button>";
                            return BtnHtml;
                        }
                    } ],
                    hover:true,
                    language:dataGridlanguage,
                    serverSide: true,
                    ajax: {
                        url: '/admin/article/tags/list',
                        type: 'GET'
                    },
                    "searching": false,
                    "lengthMenu": [ 10, 25, 50, 75, 100 ],
                    "pageLength": 10
                });

                $("#search").on("click",function (e) {
                    var name = $(":input[name=name]").val();
                    table.ajax.url( '/admin/article/tags/list?name='+name).load();
                })

            })


            //编辑操作
            $("#datagrid").on("click",".update",function (e) {
               location.href = "/admin/article/tags/edit/"+$(this).attr("data");
            });

            //移除操作
            $("#datagrid").on("click",".delete",function (e) {

                var dataid = $(this).attr("data");
                layer.confirm('您确定要删除('+$(this).attr("data-name")+")这个标签吗？", {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        type: "delete",
                        url: "{{url('/admin/article/tags/remove/')}}/"+dataid,
                        dataType: 'json',
                        data: {
                            "_token":"{{csrf_token()}}"
                        },
                        success: function(data){
                            if (data.code==1){
                                layer.msg(data.message);
                                setTimeout(function () {
                                    window.location = "{{url('admin/article/tags')}}";
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