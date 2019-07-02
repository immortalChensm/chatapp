@extends("layouts.main")
@section("title")
    用户升级列表
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
                订单管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li class="active">用户升级列表</li>
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
                                    <span class="input-group-addon"><i class="fa">升级用户</i></span>
                                    <input type="text" class="form-control " name="userName" placeholder="升级用户">
                                </div>


                                <div class="search-box" id="search">
                                    <span class="input-group-btn">
                                      <button type="button" class="btn btn-info btn-flat searchBtn">搜索</button>
                                    </span>
                                </div>

                                {{--<button type="button" class="btn bg-navy margin addBtn" onclick="location.href='{{url("/admin/report/reasons/edit")}}'">添加</button>--}}


                            </h3>
                        </div>

                        <div class="box-body">
                            <table id="datagrid" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>升级用户</th>
                                    <th>消耗船票张数</th>
                                    <th>空间大小</th>
                                    <th>升级时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>升级用户</th>
                                    <th>消耗船票张数</th>
                                    <th>空间大小</th>
                                    <th>升级时间</th>
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
                        { data:"id",name:"id",orderable: true,searchable:false },
                        { data:"userName",name:"userName",orderable: false,searchable:true },
                        { data:"shipNum",name:"name",orderable: false,searchable:true },
                        { data:"storageSize",name:"storageSize",orderable: false},
                        { data:"createdDate",name:"createdDate",orderable: false}
                    ],
                    columnDefs: [ {
                        // "targets": 7,
                        // "render": function ( data, type, row, meta ) {
                        //
                        //     var BtnHtml = "";
                        //     BtnHtml+= "  <button type='button' class='btn  btn-danger btn-sm delete' data='"+row.id+"' data-name='"+row.userName+"'>移除</button>";
                        //     return BtnHtml;
                        // }
                    } ],
                    hover:true,
                    language:dataGridlanguage,
                    serverSide: true,
                    ajax: {
                        url: '/admin/order/get/upgrade',
                        type: 'GET'
                    },
                    "searching": false,
                    "lengthMenu": [ 10, 25, 50, 75, 100 ],
                    "pageLength": 10
                });
                window.tableGrid =table;
                $("#search").on("click",function (e) {
                    var name = $(":input[name=userName]").val();
                    table.ajax.url( '/admin/order/get/upgrade?name='+name).load();
                })

            })

            //移除操作
            $("#datagrid").on("click",".delete",function (e) {
                var name = $(":input[name=userName]").val();
                var type = $(":input[name=type]").val();
                var dataid = $(this).attr("data");
                layer.confirm('您确定要删除('+$(this).attr("data-name")+")吗？", {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        type: "delete",
                        url: "{{url('/admin/order/business/remove/')}}/"+dataid,
                        dataType: 'json',
                        data: {
                            "_token":"{{csrf_token()}}"
                        },
                        success: function(data){
                            if (data.code==1){
                                layer.msg(data.message);
                                setTimeout(function () {
                                    window.tableGrid.ajax.url( '/admin/order/get/business?name='+name+"&type="+type).load();
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