@extends("layouts.main")
@section("title")
    管理员列表
    @endsection
        @section("css")
        <link rel="stylesheet" href="{{asset("adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css")}}">
        <link rel="stylesheet" href="{{asset("adminlte/css/manager.css")}}">
        @endsection
    @section("content")
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                管理员管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li class="active">管理员列表</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">

                                <div class="input-group input-box">
                                    <span class="input-group-addon"><i class="fa">账号</i></span>
                                    <input type="text" class="form-control " name="account" placeholder="账号">
                                </div>


                                <div class="search-box" id="search">
                                    <span class="input-group-btn">
                                      <button type="button" class="btn btn-info btn-flat searchBtn">搜索</button>
                                    </span>
                                </div>

                                <button type="button" class="btn bg-navy margin addBtn" onclick="location.href='{{url("/admin/manager/edit")}}'">添加管理员</button>


                            </h3>
                        </div>

                        <div class="box-body">
                            <table id="datagrid" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>账号</th>
                                    <th>角色</th>
                                    <th>登录IP</th>
                                    <th>登录时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>账号</th>
                                    <th>角色</th>
                                    <th>登录IP</th>
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
                        { data:"account",name:"account",orderable: true,searchable:true },
                        { data:"role",name:"role",orderable: true,searchable:false },
                        { data:"loginIp",name:"loginIp",orderable: true,searchable:true },
                        { data:"loginTime",name:"loginTime",orderable: true,searchable:true }
                    ],
                    columnDefs: [ {
                        "targets": 5,
                        //"data": "download_link",
                        "render": function ( data, type, row, meta ) {

                            var BtnHtml = "<button type='button' class='btn  btn-success btn-sm manager-update' data='"+row.userId+"'>修改</button>";
                            BtnHtml+= "  <button type='button' class='btn  btn-danger btn-sm manager-delete' data='"+row.userId+"' data-account='"+row.account+"'>移除</button>";
                            return BtnHtml;
                        }
                    } ],
                    hover:true,
                    language: {
                        "sProcessing": "处理中...",
                        "sLengthMenu": "显示 _MENU_ 项结果",
                        "sZeroRecords": "没有匹配结果",
                        "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                        "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                        "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                        "sInfoPostFix": "",
                        "sSearch": "搜索:",
                        "sUrl": "",
                        "sEmptyTable": "表中数据为空",
                        "sLoadingRecords": "载入中...",
                        "sInfoThousands": ",",
                        "oPaginate": {
                            "sFirst": "首页",
                            "sPrevious": "上页",
                            "sNext": "下页",
                            "sLast": "末页"
                        },
                        "oAria": {
                            "sSortAscending": ": 以升序排列此列",
                            "sSortDescending": ": 以降序排列此列"
                        }
                    },
                    serverSide: true,
                    ajax: {
                        url: '/admin/get/managers',
                        type: 'GET'
                    },
                    "searching": false,
                    "lengthMenu": [ 10, 25, 50, 75, 100 ],
                    "pageLength": 10
                });

                $("#search").on("click",function (e) {
                    var account = $(":input[name=account]").val();
                    table.ajax.url( '/admin/get/managers?account='+ account).load();
                })

            })


            //编辑操作
            $("#datagrid").on("click",".manager-update",function (e) {
               location.href = "/admin/manager/edit/"+$(this).attr("data");
            });

            //移除操作
            $("#datagrid").on("click",".manager-delete",function (e) {

                var mid = $(this).attr("data");
                layer.confirm('您确定要删除('+$(this).attr("data-account")+")这个管理员吗？", {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        type: "delete",
                        url: "{{url('/admin/manager/remove/')}}/"+mid,
                        dataType: 'json',
                        data: {
                            "_token":"{{csrf_token()}}"
                        },
                        success: function(data){
                            if (data.code == 1){
                                layer.msg(data.message);
                                setTimeout(function () {
                                    window.location = "{{url('admin/managers')}}";
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

                }, function(){

                });
            });


        </script>
        @endsection

  @endsection