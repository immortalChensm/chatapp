@extends("layouts.main")
@section("title")
    相册列表
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
                相册管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li class="active">相册列表</li>
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
                                    <span class="input-group-addon"><i class="fa">相册名称</i></span>
                                    <input type="text" class="form-control " name="title" placeholder="相册名称">
                                </div>


                                <div class="search-box" id="search">
                                    <span class="input-group-btn">
                                      <button type="button" class="btn btn-info btn-flat searchBtn">搜索</button>
                                    </span>
                                </div>

                                {{--<button type="button" class="btn bg-navy margin addBtn" onclick="location.href='{{url("/admin/photos/edit")}}'">添加相册</button>--}}


                            </h3>
                        </div>

                        <div class="box-body">
                            <table id="datagrid" class="table-bordered table table-striped table-hover display nowrap " style="width:100%">
                                <thead>
                                <tr>
                                    <th>相册标题</th>
                                    <th>发布用户</th>
                                    <th>评论量</th>
                                    <th>阅读量</th>
                                    <th>点赞量</th>
                                    <th>踩点量</th>
                                    <th title="屏蔽后前台就不会在展示">是否屏蔽</th>
                                    <th title="可控制用户该内容是否有分享权限">是否能分享</th>
                                    <th title="用户发布的内容是否已经选择永久存储">用户是否永久存储</th>
                                    <th>是否置顶</th>
                                    <th>置顶序号</th>
                                    <th>置顶起始时间</th>
                                    <th>置顶过期时间</th>
                                    <th>发布时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>相册标题</th>
                                    <th>发布用户</th>
                                    <th>评论量</th>
                                    <th>阅读量</th>
                                    <th>点赞量</th>
                                    <th>踩点量</th>
                                    <th title="屏蔽后前台就不会在展示">是否屏蔽</th>
                                    <th title="可控制用户该内容是否有分享权限">是否能分享</th>
                                    <th title="用户发布的内容是否已经选择永久存储">用户是否永久存储</th>
                                    <th>是否置顶</th>
                                    <th>置顶序号</th>
                                    <th>置顶起始时间</th>
                                    <th>置顶过期时间</th>
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
                    //autoWidth: true,
                    "scrollX": true,
                    columns: [
                        { data:"title",name:"title",orderable: true,searchable:true,width:'17%' },
                        { data:"userId",name:"userId",orderable: false,searchable:true },
                        { data:"commentCount",name:"commentCount",orderable: true,searchable:true },
                        { data:"readCount",name:"readCount",orderable: true,searchable:true },
                        { data:"upCount",name:"upCount",orderable: true,searchable:true },
                        { data:"downCount",name:"downCount",orderable: true,searchable:true },
                        { data:"isShow",name:"isShow",orderable: true,searchable:true },
                        { data:"canShared",name:"canShared",orderable: true,searchable:true },
                        { data:"isStoraged",name:"isStoraged",orderable: true,searchable:true },
                        { data:"top",name:"top",orderable: true,searchable:true },
                        { data:"topNumber",name:"topNumber",orderable: true,searchable:true },
                        { data:"topStartTime",name:"topStartTime",orderable: true,searchable:true },
                        { data:"expire",name:"expire",orderable: true,searchable:true },
                        { data:"createdDate",name:"createdDate",orderable: false,searchable:true },
                    ],
                    columnDefs: [ {
                        "targets": 14,
                        "render": function ( data, type, row, meta ) {

                            var BtnHtml = "<button type='button' class='btn  btn-success btn-sm update' data='"+row.photoId+"'>查看相册</button>";
                            BtnHtml+= "  <button type='button' class='btn  btn-danger btn-sm delete' data='"+row.photoId+"' data-name='"+row.title+"' data-user='"+row.userType+"'>移除</button>";
                            BtnHtml+= "  <button type='button' class='fa fa-eye btn  btn-danger btn-sm isShow' data-btn='isShow' data='"+row.photoId+"' data-title='"+row.title+"' data-user='"+row.userType+"' data-userId='"+row.userIdMsg+"' data-show='"+row.isShowFlag+"'>屏蔽</button>";
                            BtnHtml+= "  <button type='button' class='fa fa-share btn  btn-danger btn-sm disableShare' data-btn='disableShare' data='"+row.photoId+"' data-title='"+row.title+"' data-user='"+row.userType+"' data-userId='"+row.userIdMsg+"' data-share='"+row.canSharedFlag+"'>分享</button>";
                            BtnHtml+= "  <button type='button' class='fa fa-hand-pointer-o btn  btn-danger btn-sm top' data='"+row.photoId+"' data-title='"+row.title+"' data-user='"+row.userType+"'>置顶</button>";
                            return BtnHtml;
                        }
                    } ],
                    hover:true,
                    language:dataGridlanguage,
                    serverSide: true,
                    ajax: {
                        url: '/admin/get/photos',
                        type: 'GET'
                    },
                    "searching": false,
                    "lengthMenu": [ 10, 25, 50, 75, 100 ],
                    "pageLength": 10
                });
                window.tableGrid =table;
                $("#search").on("click",function (e) {
                    var title = $(":input[name=title]").val();
                    refreshData(title);
                })

            })


            //编辑操作
            $("#datagrid").on("click",".update",function (e) {
               location.href = "/admin/photos/edit/"+$(this).attr("data");
            });

            //移除操作
            $("#datagrid").on("click",".delete",function (e) {

                var title = $(":input[name=title]").val();
                //
                // if ($(this).attr("data-user")!=2){
                //     layer.msg("该相册为用户发布的内容禁止操作！");
                //     return false;
                // }
                var dataid = $(this).attr("data");
                layer.confirm('您确定要删除('+$(this).attr("data-name")+")这个相册吗？", {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        type: "delete",
                        url: "{{url('/admin/photos/remove/')}}/"+dataid,
                        dataType: 'json',
                        data: {
                            "_token":"{{csrf_token()}}"
                        },
                        success: function(data){
                            if (data.code==1){
                                layer.msg(data.message);
                                setTimeout(function () {
                                    refreshData(title);
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

            function refreshData(title) {
                window.tableGrid.ajax.url( '/admin/get/photos?title='+title).load();
            }

            //屏蔽操作
            $("#datagrid").on("click",".isShow,.disableShare",function (e) {
                var dateId = $(this).attr("data");
                var type=1;
                var title = $(":input[name=title]").val();
                if ($(this).hasClass("disableShare"))type=2;

                var userId = $(this).attr("data-userId");
                var articleTitle = $(this).attr("data-title");
                var action = $(this).attr("data-btn");
                var show = $(this).attr("data-show");
                var share = $(this).attr("data-share");
                $.ajax({
                    type: "put",
                    url: "{{url('/admin/photos/shieldOrShare/')}}/" + dateId,
                    dataType: 'json',
                    data: {
                        "_token": "{{csrf_token()}}",
                        'type':type,
                    },
                    success: function (data) {
                        if (data.code == 1) {
                            layer.msg(data.message);
                            setTimeout(function () {
                                refreshData(title);
                            }, 2000);
                        } else {
                            layer.msg(data.message);
                        }
                    },
                    error: function (data) {

                    }
                });

                sendMessageToUserWhenShowOrShareAction(userId,action,show,share,articleTitle);
            });


            //置顶操作
            {{--$("#datagrid").on("click",".top",function (e) {--}}
                {{--var dateId = $(this).attr("data");--}}
                {{--$.ajax({--}}
                    {{--type: "post",--}}
                    {{--url: "{{url('/admin/manager/setTop/')}}",--}}
                    {{--dataType: 'json',--}}
                    {{--data: {--}}
                        {{--"_token": "{{csrf_token()}}",--}}
                        {{--'topId':dateId,--}}
                        {{--'topType':'2'--}}
                    {{--},--}}
                    {{--success: function (data) {--}}
                        {{--if (data.code == 1) {--}}
                            {{--layer.msg(data.message);--}}
                        {{--} else {--}}
                            {{--layer.msg(data.message);--}}
                        {{--}--}}
                    {{--},--}}
                    {{--error: function (data) {--}}

                    {{--}--}}
                {{--});--}}
            {{--});--}}
            $("#datagrid").on("click",".top",function (e) {
                var dateId = $(this).attr("data");
                var title = $(":input[name=title]").val();
                var tagId = $(":input[name=tagId]").val();
                layer.open({
                    type:0,
                    area: ['540px', '240px'],
                    content: "<input type='number' class='form-control'  name='number' placeholder='请输入置顶编号'/><input type='number' class='form-control'  name='text' placeholder='请输入置顶时间'/>"
                    ,btn: ['提交', '取消']
                    ,btn1: function(index, layero){
                        //按钮【按钮一】的回调

                        var expire = $(layero).find(":input[name=text]").val();
                        var number = $(layero).find(":input[name=number]").val();
                        if (expire.length==0){
                            layer.msg("请填写过期时间");
                            return false;
                        }
                        if (number.length==0){
                            layer.msg("请填写编号");
                            return false;
                        }
                        $.ajax({
                            type: "post",
                            url: "{{url('/admin/manager/setTop/')}}",
                            dataType: 'json',
                            data: {
                                "_token": "{{csrf_token()}}",
                                'topId':dateId,
                                'topType':'2',
                                'expire':expire,
                                'number':number,
                            },
                            success: function (data) {
                                if (data.code == 1) {
                                    layer.msg(data.message);
                                    setTimeout(function () {
                                        refreshData(title);
                                    },2000);
                                } else {
                                    layer.msg(data.message);
                                }
                            },
                            error: function (data) {

                            }
                        });

                    }
                    ,cancel: function(){
                        //右上角关闭回调

                        //return false 开启该代码可禁止点击该按钮关闭
                    }
                });
            });
        </script>
        @endsection

  @endsection