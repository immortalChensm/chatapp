@extends("layouts.main")
@section("title")
    举报用户列表
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
                举报管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li class="active">举报用户列表</li>
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
                                    <span class="input-group-addon"><i class="fa">被举报人</i></span>
                                    <input type="text" class="form-control " name="name" placeholder="被举报人">
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
                                    <th>举报人</th>
                                    <th>被举报人</th>
                                    <th>举报原因</th>
                                    <th>举报日期</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>举报人</th>
                                    <th>被举报人</th>
                                    <th>举报原因</th>
                                    <th>举报日期</th>
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
                        { data:"user_name.realName",name:"user_name.realName",orderable: false,searchable:false },
                        { data:"report_user_name.realName",name:"report_user_name.realName",orderable: false,searchable:false },
                        { data:"reason",name:"reason",orderable: false,searchable:true },
                        { data:"createdDate",name:"createdDate"}
                    ],
                    columnDefs: [ {
                        "targets": 5,
                        "render": function ( data, type, row, meta ) {

                            var BtnHtml = "";
                            BtnHtml+= "  <button type='button' class='btn  btn-danger btn-sm delete' data='"+row.id+"' data-name='"+row.reason+"'>移除</button>";
                            BtnHtml+= "  <button type='button' class='btn  btn-danger btn-sm send' data='"+row.reportedUserId+"' data-name='"+row.reason+"'>警告</button>";
                            return BtnHtml;
                        }
                    } ],
                    hover:true,
                    language:dataGridlanguage,
                    serverSide: true,
                    ajax: {
                        url: '/admin/reportUsers/get/lists',
                        type: 'GET'
                    },
                    "searching": false,
                    "lengthMenu": [ 10, 25, 50, 75, 100 ],
                    "pageLength": 10
                });

                $("#search").on("click",function (e) {
                    var name = $(":input[name=name]").val();
                    table.ajax.url( '/admin/reportUsers/get/lists?name='+name).load();
                })

            })

            //发送消息【警告】
            $("#datagrid").on("click",".send",function (e) {
                var userId = $(this).attr("data");
                layer.open({
                    type:0,
                    area: ['540px', '240px'],
                    content: "<textarea class='form-control' style='height:100px' name='text' placeholder='警告内容'></textarea>"
                    ,btn: ['提交', '取消']
                    ,btn1: function(index, layero){
                        //按钮【按钮一】的回调

                        var message = $(layero).find(":input[name=text]").val();
                        if (message.length==0){
                            layer.msg("请填写消息内容");
                            return false;
                        }
                        $.ajax({
                            type: "post",
                            url: "{{url('/admin/customer/sendMsg')}}",
                            dataType: 'json',
                            data: {
                                "_token":"{{csrf_token()}}",
                                content:message,
                                userId:userId,
                                msgType:3,
                                title:'系统警告',
                            },
                            success: function(data){
                                if (data.code==1){
                                    layer.msg("操作成功");
                                }else{
                                    layer.msg(data.message);
                                }
                            },
                            error:function(data){

                            }
                        });


                    }
                    ,cancel: function(){
                        //右上角关闭回调

                        //return false 开启该代码可禁止点击该按钮关闭
                    }
                });
            });

            //移除操作
            $("#datagrid").on("click",".delete",function (e) {
                var name = $(":input[name=name]").val();
                var dataid = $(this).attr("data");
                layer.confirm('您确定要删除此条记录吗？', {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        type: "delete",
                        url: "{{url('/admin/reportUsers/remove/')}}/"+dataid,
                        dataType: 'json',
                        data: {
                            "_token":"{{csrf_token()}}"
                        },
                        success: function(data){
                            if (data.code==1){
                                layer.msg(data.message);
                                setTimeout(function () {

                                    window.tableGrid.ajax.url( '/admin/reportUsers/get/lists?name='+name).load();
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