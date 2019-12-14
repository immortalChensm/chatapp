@extends("layouts.main")
@section("title")
    文章列表
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
                文章管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li class="active">文章列表</li>
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
                                    <span class="input-group-addon"><i class="fa">标题</i></span>
                                    <input type="text" class="form-control " name="title" placeholder="文章标题">
                                </div>

                                <div class="input-group input-box">
                                    <span class="input-group-addon"><i class="fa">文章标签</i></span>
                                        <select class="form-control" name="tagId">
                                            <option value="">请选择文章标签</option>
                                            @if(!empty($tag))
                                                @foreach($tag as $item)
                                                    <option value="{{$item['tagId']}}" @if($item['tagId']==request()['tagId']) selected @endif >{{$item['name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                </div>


                                <div class="search-box" id="search">
                                    <span class="input-group-btn">
                                      <button type="button" class="btn btn-info btn-flat searchBtn">搜索</button>
                                    </span>
                                </div>

                                <button type="button" class="btn bg-navy margin addBtn" onclick="location.href='{{url("/admin/articles/edit")}}'">发布文章</button>


                            </h3>
                        </div>

                        <div class="box-body">
                            <table id="datagrid" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>标题</th>
                                    <th>文章标签</th>
                                    <th>发布用户</th>
                                    <th>评论数</th>
                                    <th>阅读数</th>
                                    <th>点赞数</th>
                                    <th>踩点数</th>
                                    <th>屏蔽否</th>
                                    <th>能分享否</th>
                                    <th>置顶否</th>
                                    <th>置顶序号</th>
                                    <th>置顶起始时间</th>
                                    <th>置顶过期时间/H</th>
                                    <th>发布时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>标题</th>
                                    <th>文章标签</th>
                                    <th>发布用户</th>
                                    <th>评论数</th>
                                    <th>阅读数</th>
                                    <th>点赞数</th>
                                    <th>踩点数</th>
                                    <th>屏蔽否</th>
                                    <th>能分享否</th>
                                    <th>置顶否</th>
                                    <th>置顶序号</th>
                                    <th>置顶起始时间</th>
                                    <th>置顶过期时间/H</th>
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
                    autoWidth: true,
                    columns: [
                        { data:"articleId",name:"articleId",orderable: true,searchable:false },
                        { data:"title",name:"title",orderable: true,searchable:true,width:'20%' },
                        { data:"tagName",name:"tagName",orderable: false,searchable:false },
                        { data:"userId",name:"userId",orderable: false,searchable:true },
                        { data:"commentCount",name:"commentCount",orderable: true,searchable:true },
                        { data:"readCount",name:"readCount",orderable: true,searchable:true },
                        { data:"upCount",name:"upCount",orderable: true,searchable:true },
                        { data:"downCount",name:"downCount",orderable: true,searchable:true },
                        { data:"isShow",name:"isShow",orderable: true,searchable:true },
                        { data:"canShared",name:"canShared",orderable: true,searchable:true },
                        { data:"top",name:"top",orderable: true,searchable:true },
                        { data:"topNumber",name:"topNumber",orderable: true,searchable:true },
                        { data:"topStartTime",name:"topStartTime",orderable: true,searchable:true },
                        { data:"expire",name:"expire",orderable: true,searchable:true },
                        { data:"isStoraged",name:"isStoraged",orderable: true,searchable:true },
                        { data:"createdDate",name:"createdDate",orderable: false,searchable:true },
                    ],
                    columnDefs: [ {
                        "targets": 16,
                        "render": function ( data, type, row, meta ) {
                            var BtnHtml = "<button type='button' class='fa fa-edit btn  btn-success btn-sm update' data='"+row.articleId+"' data-user='"+row.userType+"'>修改</button>";
                            BtnHtml+= "  <button type='button' class='fa fa-remove btn  btn-danger btn-sm delete' data='"+row.articleId+"' data-title='"+row.title+"' data-user='"+row.userType+"'>移除</button>";
                            BtnHtml+= "  <button type='button' class='fa fa-eye btn  btn-danger btn-sm isShow' data-btn='isShow' data='"+row.articleId+"' data-title='"+row.title+"' data-user='"+row.userType+"' data-userId='"+row.userIdMsg+"' data-show='"+row.isShowFlag+"'>屏蔽</button>";
                            BtnHtml+= "  <button type='button' class='fa fa-share btn  btn-danger btn-sm disableShare' data-btn='disableShare' data='"+row.articleId+"' data-title='"+row.title+"' data-user='"+row.userType+"' data-userId='"+row.userIdMsg+"' data-share='"+row.canSharedFlag+"'>分享</button>";
                            BtnHtml+= "  <button type='button' class='fa fa-hand-pointer-o btn  btn-danger btn-sm top' data='"+row.articleId+"' data-title='"+row.title+"' data-user='"+row.userType+"'>置顶</button>";
                            return BtnHtml;
                        }
                    } ],
                    hover:true,
                    language: dataGridlanguage,
                    serverSide: true,
                    ajax: {
                        url: '/admin/get/articles',
                        type: 'GET'
                    },
                    "searching": false,
                    "lengthMenu": [ 10, 25, 50, 75, 100 ],
                    "pageLength": 10
                });
                window.tableGrid =table;
                    $("#search").on("click",function (e) {
                    var title = $(":input[name=title]").val();
                    var tagId = $(":input[name=tagId]").val();

                    table.ajax.url( '/admin/get/articles?title='+ title+"&tagId="+tagId).load();
                })

            })


            //编辑操作
            $("#datagrid").on("click",".update",function (e) {
               location.href = "/admin/articles/edit/"+$(this).attr("data");
            });

            //移除操作
            $("#datagrid").on("click",".delete",function (e) {
                var title = $(":input[name=title]").val();
                var tagId = $(":input[name=tagId]").val();
                var dateId = $(this).attr("data");
                layer.confirm('您确定要删除('+$(this).attr("data-title")+")这篇文章吗？", {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        type: "delete",
                        url: "{{url('/admin/articles/remove/')}}/"+dateId,
                        dataType: 'json',
                        data: {
                            "_token":"{{csrf_token()}}"
                        },
                        success: function(data){
                            if (data.code==1){
                                layer.msg(data.message);
                                setTimeout(function () {
                                    //window.location = "{{url('admin/articles')}}";
                                    window.tableGrid.ajax.url( '/admin/get/articles?title='+ title+"&tagId="+tagId).load();
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
            $("#datagrid").on("click",".isShow,.disableShare",function (e) {
                var dateId = $(this).attr("data");
                var userId = $(this).attr("data-userId");
                var articleTitle = $(this).attr("data-title");

                var show = $(this).attr("data-show");
                var share = $(this).attr("data-share");
                var type=1;
                var title = $(":input[name=title]").val();
                var tagId = $(":input[name=tagId]").val();

                var action = $(this).attr("data-btn");
                if ($(this).hasClass("disableShare"))type=2;
                $.ajax({
                    type: "put",
                    url: "{{url('/admin/articles/shieldOrShare/')}}/" + dateId,
                    dataType: 'json',
                    data: {
                        "_token": "{{csrf_token()}}",
                        'type':type,
                    },
                    success: function (data) {
                        if (data.code == 1) {
                            layer.msg(data.message);
                            setTimeout(function () {
                                //window.location = "{{url('admin/articles')}}";
                                window.tableGrid.ajax.url( '/admin/get/articles?title='+ title+"&tagId="+tagId).load();
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
                {{--var title = $(":input[name=title]").val();--}}
                {{--var tagId = $(":input[name=tagId]").val();--}}
                {{--$.ajax({--}}
                    {{--type: "post",--}}
                    {{--url: "{{url('/admin/manager/setTop/')}}",--}}
                    {{--dataType: 'json',--}}
                    {{--data: {--}}
                        {{--"_token": "{{csrf_token()}}",--}}
                        {{--'topId':dateId,--}}
                        {{--'topType':'1'--}}
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
                
                layer.open({
                    type:0,
                    area: ['540px', '240px'],
                    content: "<input type='number' class='form-control'  name='number' placeholder='请输入置顶编号'/><input type='number' class='form-control'  name='text' placeholder='请输入置顶时间'/>"
                    ,btn: ['提交', '取消']
                    ,btn1: function(index, layero){
                        //按钮【按钮一】的回调

                        var expire = $(layero).find(":input[name=text]").val();
                        var number = $(layero).find(":input[name=number]").val();
                        if (message.length==0){
                            layer.msg("请填写时间");
                            return false;
                        }
                        $.ajax({
                        type: "post",
                        url: "{{url('/admin/manager/setTop/')}}",
                        dataType: 'json',
                        data: {
                            "_token": "{{csrf_token()}}",
                            'topId':dateId,
                            'topType':'1',
                            'expire':expire,
                            'number':number,
                        },
                        success: function (data) {
                        if (data.code == 1) {
                        layer.msg(data.message);
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