@extends("layouts.main")
@section("title")
    搜索列表
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
                搜索排行
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li class="active">搜索列表</li>
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
                                    <span class="input-group-addon"><i class="fa">关键词名称</i></span>
                                    <input type="text" class="form-control " name="keyword" placeholder="关键词名称">
                                </div>

                                <div class="input-group input-box input-max-box">
                                    <span class="input-group-addon"><i class="fa">起始日期</i></span>
                                    <input type="date" class="form-control " name="startDate" placeholder="起始日期">
                                </div>

                                <div class="input-group input-box input-max-box">
                                    <span class="input-group-addon"><i class="fa">终止日期</i></span>
                                    <input type="date" class="form-control " name="endDate" placeholder="终止日期">
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
                                    <th>关键词名称</th>
                                    <th>搜索次数</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>关键词名称</th>
                                    <th>搜索次数</th>
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

            function searchKeyword(table)
            {
                var keyword = $(":input[name=keyword]").val();
                var startDate = $(":input[name=startDate]").val();
                var endDate = $(":input[name=endDate]").val();
                table.ajax.url( '/admin/keywords/ranking/list?keyword='+keyword+"&startDate="+startDate+"&endDate="+endDate).load();
            }
            $(function () {
                var table = $('#datagrid').DataTable({
                    processing:true,
                    columns: [
                        { data:"keyword",name:"keyword",orderable: true,searchable:true },
                        { data:"ranking",name:"ranking",orderable: true,searchable:true },
                    ],
                    columnDefs: [ {
                        "targets": 2,
                        "render": function ( data, type, row, meta ) {

                            var BtnHtml = "";
                            BtnHtml+= "  <button type='button' class='btn  btn-danger btn-sm delete' data='"+row.keyword+"' data-name='"+row.keyword+"'>移除</button>";
                            return BtnHtml;
                        }
                    } ],
                    hover:true,
                    language:dataGridlanguage,
                    serverSide: true,
                    ajax: {
                        url: '/admin/keywords/ranking/list',
                        type: 'GET'
                    },
                    "searching": false,
                    "lengthMenu": [ 10, 25, 50, 75, 100 ],
                    "pageLength": 10
                });

                $("#search").on("click",function (e) {
                    searchKeyword(table);
                })
                //移除操作
                $("#datagrid").on("click",".delete",function (e) {

                    var keyword = $(this).attr("data");
                    layer.confirm('您确定要删除('+$(this).attr("data-name")+")这条关键词的所有记录吗？", {
                        btn: ['确认','取消'] //按钮
                    }, function(){
                        $.ajax({
                            type: "delete",
                            url: "{{url('/admin/keywords/ranking/remove')}}/"+keyword,
                            dataType: 'json',
                            data: {
                                "_token":"{{csrf_token()}}"
                            },
                            success: function(data){
                                if (data.code==1){
                                    layer.msg(data.message);
                                    setTimeout(function () {
                                        searchKeyword(table);
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
            })


            //编辑操作
            $("#datagrid").on("click",".update",function (e) {
               location.href = "/admin/article/tags/edit/"+$(this).attr("data");
            });




        </script>
        @endsection

  @endsection