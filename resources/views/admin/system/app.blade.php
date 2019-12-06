@extends("layouts.main")
@section("title")
    应用列表
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
                系统管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li class="active">应用列表</li>
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
                                    <span class="input-group-addon"><i class="fa">版本号</i></span>
                                    <input type="text" class="form-control " name="version" placeholder="版本号">
                                </div>


                                <div class="search-box" id="search">
                                    <span class="input-group-btn">
                                      <button type="button" class="btn btn-info btn-flat searchBtn">搜索</button>
                                    </span>
                                </div>

                                <button type="button" class="btn bg-navy margin addBtn" onclick="location.href='{{url("/admin/system/app/edit")}}'">添加</button>


                            </h3>
                        </div>

                        <div class="box-body">
                            <table id="datagrid" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>应用名称</th>
                                    <th>版本号</th>
                                    <th>平台</th>
                                    <th>简介</th>
                                    <th>下载地址</th>
                                    <th>发布时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>应用名称</th>
                                    <th>版本号</th>
                                    <th>平台</th>
                                    <th>简介</th>
                                    <th>下载地址</th>
                                    <th>发布时间</th>
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
                        { data:"name",name:"name",orderable: true,searchable:false },
                        { data:"version",name:"version",orderable: true,searchable:true },
                        { data:"platform",name:"platform",orderable: true,searchable:false },
                        { data:"description",name:"description",orderable: true,searchable:false },
                        { data:"uri",name:"uri",orderable: true,searchable:false },
                        { data:"createdDate",name:"createdDate"}
                    ],
                    columnDefs: [ {
                        "targets": 7,
                        "render": function ( data, type, row, meta ) {

                            var BtnHtml = "<button type='button' class='btn  btn-success btn-sm update' data='"+row.id+"'>修改</button>";
                            BtnHtml+= "  <button type='button' class='btn  btn-danger btn-sm delete' data='"+row.id+"' data-name='"+row.name+"'>移除</button>";
                            return BtnHtml;
                        }
                    }
                    ],
                    hover:true,
                    language:dataGridlanguage,
                    serverSide: true,
                    ajax: {
                        url: '/admin/get/system/app',
                        type: 'GET'
                    },
                    "searching": false,
                    "lengthMenu": [ 10, 25, 50, 75, 100 ],
                    "pageLength": 10
                });

                $("#search").on("click",function (e) {
                    var name = $(":input[name=version]").val();
                    table.ajax.url( '/admin/get/system/app?version='+name).load();
                })

            })



            $("#datagrid").on("click",".qrcode",function (e) {
                $(this).find("div").show();
                $(this).find(".minImg").hide();
            });
            $("#datagrid").on("click",".sourceImg",function (e) {
                $(this).hide();
                console.log("ss");
                $(this).parent("div").find(".minImg").show();
            });
            //编辑操作
            $("#datagrid").on("click",".update",function (e) {
               location.href = "/admin/system/app/edit/"+$(this).attr("data");
            });

            //移除操作
            $("#datagrid").on("click",".delete",function (e) {

                var dataid = $(this).attr("data");
                layer.confirm('您确定要删除('+$(this).attr("data-name")+")这个应用吗？删除后用户将无法下载", {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        type: "delete",
                        url: "{{url('/admin/system/app/remove/')}}/"+dataid,
                        dataType: 'json',
                        data: {
                            "_token":"{{csrf_token()}}"
                        },
                        success: function(data){
                            if (data.code==1){
                                layer.msg(data.message);
                                setTimeout(function () {
                                    window.location = "{{url('admin/system/app')}}";
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