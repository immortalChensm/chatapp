@extends("layouts.main")
@section("title")
    举报列表
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
                <li class="active">举报列表</li>
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
                                    <span class="input-group-addon"><i class="fa">举报原因</i></span>
                                    <select class="form-control" name="reasonId">
                                        <option value="">请选择选项</option>
                                        @if(!empty($data))
                                            @foreach($data as $item)
                                                <option value="{{$item['id']}}" @if($item['id']==request()['id']) selected @endif >{{$item['reason']}}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>


                                <div class="search-box" id="search">
                                    <span class="input-group-btn">
                                      <button type="button" class="btn btn-info btn-flat searchBtn">搜索</button>
                                    </span>
                                </div>

{{--                                <button type="button" class="btn bg-navy margin addBtn" onclick="location.href='{{url("/admin/report/reasons/edit")}}'">添加</button>--}}


                            </h3>
                        </div>

                        <div class="box-body">
                            <table id="datagrid" class="table-bordered table table-striped table-hover display nowrap " style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID编号</th>
                                    <th>举报原因</th>
                                    <th>举报详情</th>
                                    <th>举报者</th>
                                    <th>联系人信息</th>
                                    <th>举报内容</th>
                                    <th>内容类型</th>
                                    <th>举报时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID编号</th>
                                    <th>举报原因</th>
                                    <th>举报详情</th>
                                    <th>举报者</th>
                                    <th>联系人信息</th>
                                    <th>举报内容</th>
                                    <th>内容类型</th>
                                    <th>举报时间</th>
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
                        { data:"reasonName",name:"reasonName",orderable: false,searchable:true },
                        { data:"reason",name:"reason",orderable: false,searchable:true },
                        { data:"userName",name:"userName",orderable: false,searchable:true },
                        { data:"contact",name:"contact",orderable: false,searchable:true },
                        { data:"title",name:"title",orderable: false,searchable:true },
                        { data:"typeName",name:"typeName",orderable: false,searchable:true },
                        { data:"createdDate",name:"createdDate"}
                    ],
                    columnDefs: [ {
                        "targets": 8,
                        "render": function ( data, type, row, meta ) {

                            var BtnHtml = "";
                            BtnHtml+= "  <button type='button' class='btn  btn-danger btn-sm delete' data='"+row.id+"' data-name='"+row.reasonName+"'>移除</button>";
                            return BtnHtml;
                        }
                    } ],
                    hover:true,
                    language:dataGridlanguage,
                    serverSide: true,
                    ajax: {
                        url: '/admin/reports/list',
                        type: 'GET'
                    },
                    "searching": false,
                    "lengthMenu": [ 10, 25, 50, 75, 100 ],
                    "pageLength": 10
                });

                $("#search").on("click",function (e) {
                    var reasonId = $(":input[name=reasonId]").val();
                    table.ajax.url( '/admin/reports/list?reasonId='+reasonId).load();
                })

            })


            //移除操作
            $("#datagrid").on("click",".delete",function (e) {

                var dataid = $(this).attr("data");
                layer.confirm('您确定要删除('+$(this).attr("data-name")+")吗？", {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        type: "delete",
                        url: "{{url('/admin/report/remove/')}}/"+dataid,
                        dataType: 'json',
                        data: {
                            "_token":"{{csrf_token()}}"
                        },
                        success: function(data){
                            if (data.code==1){
                                layer.msg(data.message);
                                setTimeout(function () {
                                    window.location = "{{url('admin/reports')}}";
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