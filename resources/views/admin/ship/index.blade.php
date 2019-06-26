@extends("layouts.main")
@section("title")
    船票订单列表
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
                <li class="active">船票订单列表</li>
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
                                    <span class="input-group-addon"><i class="fa">群组ID</i></span>
                                    <input type="text" class="form-control " name="groupId" placeholder="群组ID">
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
                                    <th>买家</th>
                                    <th>卖家</th>
                                    <th>船票类别</th>
                                    <th>出售/购买数量</th>
                                    <th>出售/购买金额</th>
                                    <th>售出时间</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>买家</th>
                                    <th>卖家</th>
                                    <th>船票类别</th>
                                    <th>出售/购买数量</th>
                                    <th>出售/购买金额</th>
                                    <th>售出时间</th>
                                    <th>状态</th>
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
                        { data:"userName",name:"userName",orderable: true,searchable:true },
                        { data:"sellerUserName",name:"sellerUserName",orderable: false,searchable:false },
                        { data:"typeName",name:"typeName",orderable: false,searchable:false },
                        { data:"shipNum",name:"shipNum",orderable: false,searchable:false },
                        { data:"payMoney",name:"payMoney",orderable: false,searchable:false },
                        { data:"createdDate",name:"createdDate",orderable: false,searchable:false }
                    ],
                    columnDefs: [ {
                        "targets": 7,
                        "render": function ( data, type, row, meta ) {
                            // var BtnHtml = "<button type='button' class='fa fa-edit btn  btn-success btn-sm update' data='"+row.id+"' data-user='"+row.id+"'>编辑/查看</button>";
                            // BtnHtml+= "  <button type='button' class='fa fa-remove btn  btn-danger btn-sm delete' data='"+row.GroupId+"' data-title='"+row.name+"' data-user='"+row.GroupId+"'>解散群</button>";
                            // BtnHtml+= "  <button type='button' class='fa fa-info btn  btn-success btn-sm send' data='"+row.GroupId+"' data-title='"+row.name+"' data-user='"+row.GroupId+"'>发送消息</button>";
                            // return BtnHtml;
                        }
                    } ],
                    hover:true,
                    language: dataGridlanguage,
                    serverSide: true,
                    ajax: {
                        url: '/admin/get/order/ship',
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
                var name = $(":input[name=groupId]").val();
                window.tableGrid.ajax.url( '/admin/get/groups?name='+name).load();
            }

            //编辑操作
            $("#datagrid").on("click",".update",function (e) {
                location.href = "/admin/articles/edit/"+$(this).attr("data");
            });

            //移除操作
            $("#datagrid").on("click",".delete",function (e) {
                var title = $(":input[name=name]").val();
                var dateId = $(this).attr("data");
                layer.confirm('您确定要删除('+$(this).attr("data-title")+")该用户？", {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        type: "delete",
                        url: "{{url('/admin/users/remove/')}}/"+dateId,
                        dataType: 'json',
                        data: {
                            "_token":"{{csrf_token()}}"
                        },
                        success: function(data){
                            if (data.code==1){
                                layer.msg(data.message);
                                setTimeout(function () {
                                    searchByField();
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