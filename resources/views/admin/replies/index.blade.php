@extends("layouts.main")
@section("title")
    回复列表
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
                回复管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li class="active">回复列表</li>
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
                                    <span class="input-group-addon"><i class="fa">回复者</i></span>
                                    <input type="text" class="form-control " name="userName" placeholder="回复者">
                                </div>

                                <div class="input-group input-box input-max-box">
                                    <span class="input-group-addon"><i class="fa">内容</i></span>
                                    <input type="text" class="form-control " name="content" placeholder="内容">
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
                            <table id="datagrid" class="table-bordered table table-striped table-hover display nowrap " style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID编号</th>
                                    <th>回复人</th>
                                    <th>回复内容</th>
                                    <th>被回复者</th>
                                    <th title="屏蔽后内容将不可见">是否屏蔽</th>
                                    <th>回复时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID编号</th>
                                    <th>回复人</th>
                                    <th>回复内容</th>
                                    <th>被回复者</th>
                                    <th title="屏蔽后内容将不可见">是否屏蔽</th>
                                    <th>回复时间</th>
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
                    "scrollX": true,
                    columns: [
                        { data:"id",name:"id",orderable: true,searchable:false },
                        { data:"userName",name:"userName",orderable: false,searchable:true },
                        { data:"content",name:"content",orderable: false,width:'20%' },
                        { data:"replyUserName",name:"replyUserName",orderable: false},
                        { data:"isShow",name:"isShow",orderable: false},
                        { data:"createdDate",name:"createdDate",orderable: false}
                    ],
                    columnDefs: [ {
                        "targets": 6,
                        "render": function ( data, type, row, meta ) {

                            var BtnHtml = "";
                            BtnHtml+= "  <button type='button' class='btn  btn-danger btn-sm delete' data='"+row.id+"' data-name='"+row.userName+"'>移除</button>";
                            BtnHtml+= "  <button type='button' class='btn  btn-danger btn-sm isShow' data='"+row.id+"' data-name='"+row.userName+"'>屏蔽</button>";
                            return BtnHtml;
                        }
                    } ],
                    hover:true,
                    language:dataGridlanguage,
                    serverSide: true,
                    ajax: {
                        url: '/admin/get/replies',
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
                    table.ajax.url( '/admin/get/replies?name='+name+'&content='+content).load();
                })

            })


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
                        url: "{{url('/admin/replies/remove/')}}/"+dataid,
                        dataType: 'json',
                        data: {
                            "_token":"{{csrf_token()}}"
                        },
                        success: function(data){
                            if (data.code==1){
                                layer.msg(data.message);
                                setTimeout(function () {
                                    window.tableGrid.ajax.url( '/admin/get/replies?name='+name+'&content='+content).load();
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
                    url: "{{url('/admin/replies/shieldOrShare/')}}/" + dateId,
                    dataType: 'json',
                    data: {
                        "_token": "{{csrf_token()}}",
                        type:1
                    },
                    success: function (data) {
                        if (data.code == 1) {
                            layer.msg(data.message);
                            setTimeout(function () {
                                window.tableGrid.ajax.url( '/admin/get/replies?name='+name+'&content='+content).load();
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