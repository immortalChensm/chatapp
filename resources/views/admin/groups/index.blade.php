@extends("layouts.main")
@section("title")
    群组列表
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
                群组管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li class="active">群组列表</li>
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
                                    <th>群ID</th>
                                    <th>群名称</th>
                                    <th>群人数</th>
                                    <th>群简介</th>
                                    <th>创建人</th>
                                    <th>群主ID</th>
                                    <th>群主名</th>
                                    <th>类型</th>
                                    <th>创建时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>群ID</th>
                                    <th>群名称</th>
                                    <th>群人数</th>
                                    <th>群简介</th>
                                    <th>创建人</th>
                                    <th>群主ID</th>
                                    <th>群主名</th>
                                    <th>类型</th>
                                    <th>创建时间</th>
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
                        { data:"GroupId",name:"GroupId",orderable: true,searchable:true },
                        { data:"Name",name:"Name",orderable: false,searchable:false },
                        { data:"MemberNum",name:"MemberNum",orderable: false,searchable:false },
                        { data:"Introduction",name:"Introduction",orderable: false,searchable:false },
                        { data:"Operator_Account",name:"Operator_Account",orderable: false,searchable:false },
                        { data:"Owner_Account",name:"Owner_Account",orderable: false,searchable:false },
                        { data:"Owner_Name",name:"Owner_Name",orderable: false,searchable:false },
                        { data:"Type",name:"Type",orderable: false,searchable:false },
                        { data:"createdDate",name:"createdDate",orderable: false,searchable:false }
                    ],
                    columnDefs: [ {
                        "targets": 10,
                        "render": function ( data, type, row, meta ) {
                            var BtnHtml = "<button type='button' class='fa fa-edit btn  btn-success btn-sm update' data='"+row.id+"' data-user='"+row.id+"'>编辑/查看</button>";
                            BtnHtml+= "  <button type='button' class='fa fa-remove btn  btn-danger btn-sm delete' data='"+row.GroupId+"' data-title='"+row.name+"' data-user='"+row.GroupId+"'>解散群</button>";
                            BtnHtml+= "  <button type='button' class='fa fa-info btn  btn-success btn-sm send' data='"+row.GroupId+"' data-title='"+row.name+"' data-user='"+row.GroupId+"'>发送消息</button>";
                            return BtnHtml;
                        }
                    } ],
                    hover:true,
                    language: dataGridlanguage,
                    serverSide: true,
                    ajax: {
                        url: '/admin/get/groups',
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

            //发送消息
          $("#datagrid").on("click",".send",function (e) {
            var groupId = $(this).attr("data");
                layer.open({
                    type:0,
                    area: ['540px', '240px'],
                    content: "<textarea class='form-control' style='height:100px' name='text' placeholder='消息内容'></textarea>"
                    ,btn: ['提交', '取消']
                    ,yes: function(index, layero){
                        //按钮【按钮一】的回调

                        var message = $(layero).find(":input[name=text]").val();
                        if (message.length==0){

                            layer.msg("请填写消息内容");
                            return false;
                        }
                        $.ajax({
                            type: "post",
                            url: "{{url('/admin/groups/sendMsg')}}",
                            dataType: 'json',
                            data: {
                                "_token":"{{csrf_token()}}",
                                Text:message,
                                groupId:groupId,
                            },
                            success: function(data){
                                if (data.code==1){
                                    layer.msg(data.message.result.ActionStatus);
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