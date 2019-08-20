@extends("layouts.main")
@section("title")
    管理员管理
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
                权限管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li class="active">权限列表</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div class="box">
                        <div class="box-header">
                            {{--<h3 class="box-title">--}}

                                {{--<div class="input-group input-box input-max-box">--}}
                                    {{--<span class="input-group-addon"><i class="fa">标签名称</i></span>--}}
                                    {{--<input type="text" class="form-control " name="name" placeholder="标签名称">--}}
                                {{--</div>--}}


                                {{--<div class="search-box" id="search">--}}
                                    {{--<span class="input-group-btn">--}}
                                      {{--<button type="button" class="btn btn-info btn-flat searchBtn">搜索</button>--}}
                                    {{--</span>--}}
                                {{--</div>--}}

                                {{--<button type="button" class="btn bg-navy margin addBtn" onclick="location.href='{{url("/admin/article/tags/edit")}}'">添加标签</button>--}}


                            {{--</h3>--}}
                        </div>

                        <div class="box-body">
                            <table id="datagrid" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>权限名称</th>
                                    <th>权限分组</th>
                                    <th>权限动作</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>权限名称</th>
                                    <th>权限分组</th>
                                    <th>权限动作</th>
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
                        { data:"id",name:"id",orderable: true,searchable:false },
                        { data:"name",name:"name",orderable: true,searchable:false },
                        { data:"group",name:"group",orderable: true,searchable:false },
                        { data:"action",name:"action",orderable: true,searchable:false },
                    ],
                    hover:true,
                    language:dataGridlanguage,
                    serverSide: true,
                    ajax: {
                        url: '/admin/get/permission',
                        type: 'GET'
                    },
                    "searching": false,
                    "lengthMenu": [ 10, 25, 50, 75, 100 ],
                    "pageLength": 10
                });



            })




        </script>
        @endsection

  @endsection