@extends("layouts.main")
@section("title")
    广告编辑
    @endsection
@section("css")
    <link rel="stylesheet" href="{{asset("adminlte/css/common.css")}}">
    <link rel="stylesheet" href="{{asset("adminlte/css/photos.css")}}">

    <link href="{{asset("webuploader/css/uploader-image.css")}}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .ui-image .u-close-bg, .ui-image .u-close-text { display: block; }
    </style>
    @endsection
@section("content")

    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                广告管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="{{url("/admin/ads")}}"><i class="fa"></i> 广告管理</a></li>
                <li class="active">广告编辑</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            {{--<h3 class="box-title">Quick Example</h3>--}}
                        </div>
                        <form role="form" id="postForm">
                            {{csrf_field()}}

                            <input type="hidden" name="id" data-id = "@if(isset($data['id'])){{$data['id']}} @endif" value=" @if(isset($data['id'])){{$data['id']}} @endif">

                            @if(isset($data['id']))
                                @foreach($data['uri'] as $uri)
                                    <input type="hidden" class="inputUploadFile" name="uri[]" value="{{$uri}}"/>
                                @endforeach
                            @endif
                            <div class="box-body">

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">广告名称</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="name" value="@if(isset($data['id'])) {{$data['name']}} @endif" placeholder="广告名称">
                                </div>
                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">公司名称</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="company" value="@if(isset($data['id'])) {{$data['company']}} @endif" placeholder="公司名称">
                                </div>
                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">公司地址</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="address" value="@if(isset($data['id'])) {{$data['address']}} @endif" placeholder="公司地址">
                                </div>
                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">联系人</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="contact" value="@if(isset($data['id'])) {{$data['contact']}} @endif" placeholder="联系人">
                                </div>
                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">联系电话</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="mobile" value="@if(isset($data['id'])) {{$data['mobile']}} @endif" placeholder="联系电话">
                                </div>
                                <div class="form-group" >
                                    <label>活动内容</label>
                                    <textarea name="content"  value="@if(isset($data['id'])) {{$data['content']}} @endif" class="form-control textarea-input" rows="4">@if(isset($data['id'])){{$data['content']}} @endif</textarea>
                                </div>
                                <div class="input-group" >
                                    <span class="input-group-addon"><i class="fa">广告类型</i></span>
                                    <select class="form-control" name="type" style="width: 100px">
                                        <option value="">请选择</option>
                                            @foreach([1=>'图片',2=>'视频'] as $k=>$item)
                                                <option value="{{$k}}" @if(isset($data['id'])&&$k==$data['type'])  selected @endif >{{$item}}</option>
                                            @endforeach

                                    </select>

                                </div>
                                <div class="form-group">
                                        <div>
                                            <a id="upload-target" class="btn btn-success btn-success-upload">上传</a>
                                        </div>
                                        <div class="content">
                                            <div class="contentin">

                                                @if(!isset($data['id']))
                                                <div id="upload-image-view" class="clearfix"></div>
                                                @endif

                                                    @if(isset($data['id']))
                                                <div id="upload-image-view" class="clearfix ui-image html5">

                                                    @foreach($data['uri'] as $uri)
                                                    <div class="u-item u-over">
                                                        <div class="u-img">
                                                            @if($data['type']==1)
                                                            <img src="{{$uri}}">
                                                                @else
                                                                <video src="{{$uri}}" autoplay controls></video>
                                                        @endif


                                                        </div>
                                                        <div class="u-progress-bar" style="opacity: 0.3;">
                                                            <div class="u-progress" style="opacity: 0.5; width: 100%;"></div>
                                                        </div>
                                                        <div class="u-name" title="{{$uri}}">{{$uri}}</div>
                                                        <div class="u-close-bg" style="opacity: 0.3;"></div>
                                                        <div class="u-close-text" data="{{$uri}}">X</div>
                                                    </div>
                                                        @endforeach

                                                </div>
                                                    @endif

                                                <div id="log"></div>
                                            </div>
                                        </div>
                                        <div id="sidebar" class="sidebar"></div>
                                </div>
                            </div>

                            <div class="box-footer">
                                <a  class="btn btn-success" onclick="store()">提交</a>
                                <a href="{{url()->previous()}}" class="btn btn-info">返回</a>
                            </div>
                        </form>
                    </div>


                </div>

            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @section("js")
        <script type="text/javascript" src="{{asset("webuploader/demo/demo.js")}}"></script>

        <script type="text/javascript" src="{{asset("webuploader/js/Q.js")}}"></script>
        <script type="text/javascript" src="{{asset("webuploader/js/Q.Uploader.js")}}"></script>
        <script type="text/javascript" src="{{asset("webuploader/js/Q.Uploader.UI.Image.js")}}"></script>

        <script>
            function store(){
                $.ajax({
                    type: 'POST',
                    url: "{{url('admin/ads/save')}}",
                    dataType: 'json',
                    data: $('#postForm').serializeArray(),
                    success: function(data){
                        if (data.code == 1){
                            layer.msg(data.message);
                           setTimeout(function () {
                               window.location = "{{url('admin/ads')}}";
                           },2000);

                        }else if(data.code ==100)
                        {
                           for(var field in data.message){
                               layer.msg(data.message[field][0]);
                               return ;
                           }
                        }else{
                            layer.msg(data.message);
                        }
                    },
                    error:function(data){

                    }
                });

            }

        </script>
        <script type="text/javascript">
            //https://github.com/devin87/web-uploader-node
            function log(msg) {
                document.getElementById("log").innerHTML += (msg != undefined ? msg : "") + "<br />";
            }
            var Uploader = Q.Uploader,
                formatSize = Q.formatSize,
                boxView = document.getElementById("upload-image-view");
            var uploader = new Uploader({
                url: UPLOAD_URL,
                target: document.getElementById("upload-target"),
                view: boxView,
                //将auto配置为false以手动上传
                auto: true,
                allows: ".jpg,.png,.gif,.bmp,.mp4",
                //图片缩放
                scale: {
                    //要缩放的图片格式
                    types: ".jpg",
                    //最大图片大小(width|height)
                    maxWidth: 1024
                },
                upName: "imgFile",
                on: {
                    //添加之前触发
                    add: function (task) {
                        //限制数量
                        if ($(":input[name=type]").val()==2){
                            if ($(".inputUploadFile").val()){
                                layer.msg("一次只能一个文件！");
                                return false;
                            }
                        }

                        if (task.disabled) return layer.msg("允许上传的文件格式为：" + this.ops.allows);
                    },
                    remove: function (task) {
                        //log(task.name + " : 已移除！");
                        removeCosFile(task,"{{url('/admin/remove/upload/file')}}");
                    },
                    complete: function(task){

                        if($(":input[name=type]").val()==2){
                            //视频
                            var uri = $("#upload-image-view").find("img").attr("src");
                            $("#upload-image-view").find("img").remove();
                            $("#upload-image-view .u-item .u-img").append(function () {
                                return "<video src='"+uri+"' autoplay controls></audio>";
                            });
                        }
                        $("#postForm").append(function () {
                            return "<input type='hidden' class='inputUploadFile' name='uri[]' value='"+task.json.url+"' data='"+task.name+"'/>";
                        });
                    }
                }
            });

            //修改时的删除
            $("div.u-close-text").click(function (e) {
                //console.log($(this).attr("data"));

                removeCosFile({
                    json:{
                        imgFile:$(this).attr("data"),
                        fileKeyName:$(this).attr("data"),
                    }
                },"/admin/remove/upload/file");

                $($($(this)[0]).parent()[0]).remove();


            });

            //移除文件
            function removeCosFile(task,uri)
            {
                $.ajax({
                    type:'post',
                    data:{
                        imgFile:task.json.url,
                        fileKeyName:task.json.fileKeyName,
                        '_token':"{{csrf_token()}}",
                    },
                    url:uri,
                    success:function (res) {
                        if (res.code==1){
                            layer.msg("已移除！");
                        }
                        var inputUploadFile = $(".inputUploadFile");
                        for(var j=0;j<inputUploadFile.length;j++){
                            if ($(inputUploadFile[j]).val() == task.json.fileKeyName){
                                $(inputUploadFile[j]).remove();
                            }
                        }
                    }
                });
            }
        </script>
        @endsection
    @endsection
