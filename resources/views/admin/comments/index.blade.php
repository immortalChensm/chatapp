@extends("layouts.main")
@section("title")
    评论列表
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
                评论管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li class="active">评论列表</li>
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
                                    <span class="input-group-addon"><i class="fa">评论者</i></span>
                                    <input type="text" class="form-control " name="userName" placeholder="评论者">
                                </div>

                                <div class="input-group input-box input-max-box">
                                    <span class="input-group-addon"><i class="fa">评论内容</i></span>
                                    <input type="text" class="form-control " name="content" placeholder="评论内容">
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
                                    <th>评论者</th>
                                    <th>评论内容</th>
                                    <th>评论对象</th>
                                    <th>评论类型</th>
                                    <th>被评论者</th>
                                    <th>评论赞数</th>
                                    <th>评论回复数</th>
                                    <th>屏蔽</th>
                                    <th>评论时间</th>

                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>评论者</th>
                                    <th>评论内容</th>
                                    <th>评论对象</th>
                                    <th>评论类型</th>
                                    <th>被评论者</th>
                                    <th>评论赞数</th>
                                    <th>评论回复数</th>
                                    <th>屏蔽</th>
                                    <th>评论时间</th>

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
                        { data:"content",name:"content",orderable: false},
                        { data:"title",name:"title",orderable: false},
                        { data:"typeName",name:"typeName",orderable: false},
                        { data:"commentUserName",name:"commentUserName",orderable: false},
                        { data:"commentPraise",name:"commentPraise",orderable: false},
                        { data:"commentReply",name:"commentReply",orderable: false},
                        { data:"isShow",name:"isShow",orderable: false},
                        { data:"createdDate",name:"createdDate",orderable: false}
                    ],
                    columnDefs: [ {
                        "targets": 10,
                        "render": function ( data, type, row, meta ) {

                            var BtnHtml = "<button type='button' class='btn  btn-success btn-sm update' data='"+row.id+"'>查看回复详情</button>";
                            BtnHtml+= "  <button type='button' class='btn  btn-danger btn-sm delete' data='"+row.id+"' data-name='"+row.title+"'>移除</button>";
                            BtnHtml+= "  <button type='button' class='btn  btn-danger btn-sm isShow' data='"+row.id+"' data-name='"+row.title+"'>屏蔽</button>";
                            return BtnHtml;
                        }
                    } ],
                    hover:true,
                    language:dataGridlanguage,
                    serverSide: true,
                    ajax: {
                        url: '/admin/get/comments',
                        type: 'GET'
                    },
                    "searching": false,
                    "lengthMenu": [ 10, 25, 50, 75, 100 ],
                    "pageLength": 10
                });
                window.tableGrid =table;
                $("#search").on("click",function (e) {
                    var name = $(":input[name=userName]").val();
                    var content = $(":input[name=content]").val();
                    table.ajax.url( '/admin/get/comments?name='+name+'&content='+content).load();
                })

            })


            //编辑操作
            $("#datagrid").on("click",".update",function (e) {
               location.href = "/admin/report/reasons/edit/"+$(this).attr("data");
            });

            //移除操作
            $("#datagrid").on("click",".delete",function (e) {
                var name = $(":input[name=userName]").val();
                var content = $(":input[name=content]").val();
                var dataid = $(this).attr("data");
                layer.confirm('您确定要删除('+$(this).attr("data-name")+")吗？", {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        type: "delete",
                        url: "{{url('/admin/comments/remove/')}}/"+dataid,
                        dataType: 'json',
                        data: {
                            "_token":"{{csrf_token()}}"
                        },
                        success: function(data){
                            if (data.code==1){
                                layer.msg(data.message);
                                setTimeout(function () {
                                    window.tableGrid.ajax.url( '/admin/get/comments?name='+name+'&content='+content).load();
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
            //屏蔽操作
            $("#datagrid").on("click",".isShow",function (e) {
                var dateId = $(this).attr("data");
                var name = $(":input[name=userName]").val();
                var content = $(":input[name=content]").val();
                $.ajax({
                    type: "put",
                    url: "{{url('/admin/comments/shieldOrShare/')}}/" + dateId,
                    dataType: 'json',
                    data: {
                        "_token": "{{csrf_token()}}",
                        type:1
                    },
                    success: function (data) {
                        if (data.code == 1) {
                            layer.msg(data.message);
                            setTimeout(function () {
                                window.tableGrid.ajax.url( '/admin/get/comments?name='+name+'&content='+content).load();
                            }, 2000);
                        } else {
                            layer.msg(data.message);
                        }
                    },
                    error: function (data) {

                    }
                });
            });

        </script>
        @endsection

  @endsection