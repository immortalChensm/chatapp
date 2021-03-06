@extends("layouts.main")
@section("title")
    业务列表
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
                <li class="active">业务列表</li>
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
                                    <span class="input-group-addon"><i class="fa">提交人</i></span>
                                    <input type="text" class="form-control " name="userName" placeholder="提交人">
                                </div>

                                <div class="input-group input-box">
                                    <span class="input-group-addon"><i class="fa">业务类型</i></span>
                                    <select class="form-control" name="type">
                                        <option value="">请选择业务类型</option>
                                            @foreach(['1'=>'撰写专记','2'=>'专业拍摄','3'=>'音乐制作','4'=>'视频拍摄'] as $k=>$item)
                                                <option value="{{$k}}" @if($k==request()['type']) selected @endif >{{$item}}</option>
                                            @endforeach

                                    </select>

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
                                    <th>业务类型</th>
                                    <th>提交人</th>
                                    <th>用户姓名</th>
                                    <th>联系电话</th>
                                    <th>联系地址</th>
                                    <th>提交时间</th>
                                    <th>处理状态</th>
                                    <th>后台备注</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID编号</th>
                                    <th>业务类型</th>
                                    <th>提交人</th>
                                    <th>用户姓名</th>
                                    <th>联系电话</th>
                                    <th>联系地址</th>
                                    <th>提交时间</th>
                                    <th>处理状态</th>
                                    <th>后台备注</th>
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
                        { data:"type",name:"type",orderable: false,searchable:false },
                        { data:"userName",name:"userName",orderable: false,searchable:true },
                        { data:"name",name:"name",orderable: false,searchable:true },
                        { data:"mobile",name:"content",orderable: false},
                        { data:"address",name:"replyUserName",orderable: false},
                        { data:"createdDate",name:"createdDate",orderable: false},
                        { data:"state",name:"state",orderable: false},
                        { data:"mark",name:"mark",orderable: false}
                    ],
                    columnDefs: [ {
                        "targets": 9,
                        "render": function ( data, type, row, meta ) {

                            var BtnHtml = "";
                            BtnHtml+= "  <button type='button' class='btn  btn-danger btn-sm delete' data='"+row.id+"' data-name='"+row.userName+"'>移除</button>";
                            BtnHtml+= "  <button type='button' class='btn  btn-info btn-sm mark' data='"+row.id+"' data-name='"+row.userName+"'>备注</button>";
                            if (row.state=='待处理'){
                                BtnHtml+= "  <button type='button' class='btn  btn-success btn-sm handle' data='"+row.id+"' data-name='"+row.userName+"' data-type='1'>已排班</button>";
                                BtnHtml+= "  <button type='button' class='btn  btn-success btn-sm finish' data='"+row.id+"' data-name='"+row.userName+"' data-type='2'>已结账</button>";
                            } else if (row.state=='已排班'){
                                BtnHtml+= "  <button type='button' class='btn  btn-success btn-sm finish' data='"+row.id+"' data-name='"+row.userName+"' data-type='2'>已结账</button>";
                            } else if (row.state=='已结账'){
                                BtnHtml+= "  <button type='button' class='btn  btn-success btn-sm handle' data='"+row.id+"' data-name='"+row.userName+"' data-type='1'>已排班</button>";
                            }

                            return BtnHtml;
                        }
                    } ],
                    hover:true,
                    language:dataGridlanguage,
                    serverSide: true,
                    ajax: {
                        url: '/admin/order/get/business',
                        type: 'GET'
                    },
                    "searching": false,
                    "lengthMenu": [ 10, 25, 50, 75, 100 ],
                    "pageLength": 10
                });
                window.tableGrid =table;
                $("#search").on("click",function (e) {
                    var name = $(":input[name=userName]").val();
                    var type = $(":input[name=type]").val();
                    table.ajax.url( '/admin/order/get/business?name='+name+"&type="+type).load();
                })

            })

            $("#datagrid").on("click",".mark",function (e) {
                var dataid = $(this).attr("data");
                layer.open({
                    type:0,
                    area: ['540px', '240px'],
                    content: "<textarea class='form-control' style='height:100px' name='text' placeholder='备注内容'></textarea>"
                    ,btn: ['提交', '取消']
                    ,btn1: function(index, layero){
                        //按钮【按钮一】的回调

                        var message = $(layero).find(":input[name=text]").val();
                        if (message.length==0){
                            layer.msg("请填写备注内容");
                            return false;
                        }
                        $.ajax({
                            type: "post",
                            url: "{{url('/admin/order/business/mark/')}}/"+dataid,
                            dataType: 'json',
                            data: {
                                "_token":"{{csrf_token()}}",
                                mark:message,
                            },
                            success: function(data){
                                if (data.code==1){
                                    layer.msg(data.message);
                                    var name = $(":input[name=userName]").val();
                                    var type = $(":input[name=type]").val();
                                    table.ajax.url( '/admin/order/get/business?name='+name+"&type="+type).load();
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

            $("#datagrid").on("click",".handle,.finish",function (e) {
                var type = $(this).attr("data-type");
                var dataid = $(this).attr("data");
                layer.confirm('您确定要处理('+$(this).attr("data-name")+")的状态吗？", {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        type: "post",
                        url: "{{url('/admin/order/business/state/')}}/"+dataid,
                        dataType: 'json',
                        data: {
                            "_token":"{{csrf_token()}}",
                            type:type
                        },
                        success: function(data){
                            if (data.code==1){
                                layer.msg(data.message);
                                var name = $(":input[name=userName]").val();
                                var type = $(":input[name=type]").val();
                                table.ajax.url( '/admin/order/get/business?name='+name+"&type="+type).load();
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

            //移除操作
            $("#datagrid").on("click",".delete",function (e) {
                var name = $(":input[name=userName]").val();
                var type = $(":input[name=type]").val();
                var dataid = $(this).attr("data");
                layer.confirm('您确定要删除('+$(this).attr("data-name")+")吗？", {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        type: "delete",
                        url: "{{url('/admin/order/business/remove/')}}/"+dataid,
                        dataType: 'json',
                        data: {
                            "_token":"{{csrf_token()}}"
                        },
                        success: function(data){
                            if (data.code==1){
                                layer.msg(data.message);
                                setTimeout(function () {
                                    window.tableGrid.ajax.url( '/admin/order/get/business?name='+name+"&type="+type).load();
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