@extends("layouts.main")
@section("title")
    红包退还列表
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
                <li class="active"> 红包退还列表</li>
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
                                    <span class="input-group-addon"><i class="fa">发送人</i></span>
                                    <input type="text" class="form-control " name="sender" placeholder="发送人">
                                </div>

                                <div class="search-box" id="search">
                                    <span class="input-group-btn">
                                      <button type="button" class="btn btn-info btn-flat searchBtn">搜索</button>
                                    </span>
                                </div>

                            </h3>
                        </div>

                        <div class="box-body">
                            <table id="datagrid" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>发送人</th>
                                    <th>红包金额</th>
                                    <th>留言</th>
                                    <th>红包个数</th>
                                    <th>退还金额</th>
                                    <th>退还时间</th>
                                    <th>发送时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>发送人</th>
                                    <th>红包金额</th>
                                    <th>留言</th>
                                    <th>红包个数</th>
                                    <th>退还金额</th>
                                    <th>退还时间</th>
                                    <th>发送时间</th>
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
                        { data:"userName",name:"userName",orderable: true,searchable:true },
                        { data:"money",name:"money",orderable: false,searchable:false },
                        { data:"message",name:"message",orderable: false,searchable:false },
                        { data:"num",name:"num",orderable: false,searchable:false },
                        { data:"refundMoney",name:"refundMoney",orderable: false,searchable:false },
                        { data:"refundDate",name:"refundDate",orderable: false,searchable:false },
                        { data:"createdDate",name:"createdDate",orderable: false,searchable:false }
                    ],
                    columnDefs: [ {
                        // "targets": 8,
                        // "render": function ( data, type, row, meta ) {
                        //     // var BtnHtml = "<button type='button' class='fa fa-edit btn  btn-success btn-sm update' data='"+row.id+"' data-user='"+row.id+"'>编辑/查看</button>";
                        //     // BtnHtml+= "  <button type='button' class='fa fa-remove btn  btn-danger btn-sm delete' data='"+row.GroupId+"' data-title='"+row.name+"' data-user='"+row.GroupId+"'>解散群</button>";
                        //     // BtnHtml+= "  <button type='button' class='fa fa-info btn  btn-success btn-sm send' data='"+row.GroupId+"' data-title='"+row.name+"' data-user='"+row.GroupId+"'>发送消息</button>";
                        //     // return BtnHtml;
                        // }
                    } ],
                    hover:true,
                    language: dataGridlanguage,
                    serverSide: true,
                    ajax: {
                        url: '/admin/get/order/refund',
                        type: 'GET'
                    },
                    "searching": false,
                    "lengthMenu": [ 10, 25, 50, 75, 100 ],
                    "pageLength": 10
                });
                window.tableGrid =table;
                $("#search").on("click",function (e) {
                    searchByField();
                })

            })
            //
            function searchByField()
            {
                var sender = $(":input[name=sender]").val();
                window.tableGrid.ajax.url( '/admin/get/order/refund?sender='+sender).load();
            }
        </script>
        @endsection

  @endsection