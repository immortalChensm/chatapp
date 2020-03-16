@extends("layouts.main")
@section("title")
    空间订单列表
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
                <li class="active">空间订单列表</li>
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
                                    <span class="input-group-addon"><i class="fa">买家</i></span>
                                    <input type="text" class="form-control " name="buyer" placeholder="买家">
                                </div>

                                <div class="search-box" id="search">
                                    <span class="input-group-btn">
                                      <button type="button" class="btn btn-info btn-flat searchBtn">搜索</button>
                                    </span>
                                </div>

                            </h3>
                        </div>

                        <div class="box-body">
                            <table id="datagrid" class="table-bordered table table-striped table-hover display nowrap " style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID编号</th>
                                    <th>买家名字</th>
                                    <th>卖家名字</th>
                                    <th>空间大小/G</th>
                                    <th>购买/续费时间</th>
                                    <th>过期时间</th>
                                    <th>消费船票数量</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID编号</th>
                                    <th>买家名字</th>
                                    <th>卖家名字</th>
                                    <th>空间大小/G</th>
                                    <th>购买/续费时间</th>
                                    <th>过期时间</th>
                                    <th>消费船票数量</th>
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
                    "scrollX": true,
                    columns: [
                        { data:"id",name:"id",orderable: true,searchable:false },
                        { data:"buyer.realName",name:"buyer.realName",orderable: true,searchable:true },
                        { data:"sellerUserName",name:"sellerUserName",orderable: false,searchable:false },
                        { data:"spaceNum",name:"spaceNum",orderable: false,searchable:false },
                        { data:"buyDate",name:"buyDate",orderable: false,searchable:false },
                        { data:"expireDate",name:"expireDate",orderable: false,searchable:false },
                        { data:"shipNum",name:"shipNum",orderable: false,searchable:false }
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
                        url: '/admin/get/order/storage',
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
                var buyer = $(":input[name=buyer]").val();
                window.tableGrid.ajax.url( '/admin/get/order/storage?buyer='+buyer).load();
            }
        </script>
        @endsection

  @endsection