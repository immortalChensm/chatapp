@extends("layouts.main")
@section("title")
    视频编辑
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
                视频管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="{{url("/admin/videos")}}"><i class="fa"></i> 视频管理</a></li>
                <li class="active">视频编辑</li>
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

                            <input type="hidden" name="musicId" data-id = "@if(isset($data['videoId'])){{$data['videoId']}} @endif" data-user = "@if(isset($data['videoId'])){{$data['userType']}} @endif" value=" @if(isset($data['videoId'])){{$data['videoId']}} @endif">

                            @if(isset($data['videoId']))
                                    <input type="hidden" class="inputUploadFile" name="uriKey" value="{{$data['uriKey']}}"/>

                            @endif
                            <div class="box-body">

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">视频名称</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="title" value="@if(isset($data['videoId'])) {{$data['title']}} @endif" placeholder="视频名称">
                                </div>


                                <div class="form-group" >
                                    <label>简介</label>
                                    <textarea name="introduction"  value="@if(isset($data['videoId'])) {{$data['introduction']}} @endif" class="form-control textarea-input" rows="4">@if(isset($data['videoId'])){{$data['introduction']}} @endif</textarea>
                                </div>

                                <div class="form-group">
                                        <div>
                                            <a id="upload-target" class="btn btn-success btn-success-upload">上传视频</a>
                                        </div>
                                        <div class="content">
                                            <div class="contentin">

                                                @if(!isset($data['videoId']))
                                                <div id="upload-image-view" class="clearfix"></div>
                                                @endif

                                                    @if(isset($data['videoId']))
                                                <div id="upload-image-view" class="clearfix ui-image html5">

                                                    <div class="u-item u-over">
                                                        <div class="u-img">
                                                            <img src="{{asset("attached/musicLogo.png")}}">
                                                            <audio src="{{$data['uri']}}"></audio>
                                                        </div>
                                                        <div class="u-progress-bar" style="opacity: 0.3;">
                                                            <div class="u-progress" style="opacity: 0.5; width: 100%;"></div>
                                                        </div>
                                                        <div class="u-name" title="{{$data['title']}}">{{$data['title']}}</div>
                                                        <div class="u-close-bg" style="opacity: 0.3;"></div>
                                                        <div class="u-close-text" data="{{$data['uriKey']}}" data-user="{{$data['userType']}}">X</div>
                                                    </div>


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
                    url: "{{url('admin/videos/save')}}",
                    dataType: 'json',
                    data: $('#postForm').serializeArray(),
                    success: function(data){
                        if (data.code == 1){
                            layer.msg(data.message);
                           setTimeout(function () {
                               window.location = "{{url('admin/videos')}}";
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
                allows: ".mp4,.avi",
                //accept: "audio/mp3",        //指定浏览器接受的文件类型 eg:image/*,video/*  =>  IE9及以下不支持
                upName: "imgFile",
                on: {
                    //添加之前触发
                    add: function (task) {
                        if ($(":input[name=videoId]").attr("data-id")>0){
                            if ($(":input[name=videoId]").attr("data-user")!=2){
                                layer.msg("该视频为用户发布的内容禁止操作！");
                                return false;
                            }
                        }
                        //限制数量
                        if ($(".inputUploadFile").val()){
                            layer.msg("一次只能上传一个视频！");
                            return false;
                        }
                        if (task.disabled) return layer.msg("允许上传的文件格式为：" + this.ops.allows);
                    },
                    remove: function (task) {
                        //log(task.name + " : 已移除！");
                        removeCosFile(task,"{{url('/admin/remove/upload/file')}}");
                    },
                    complete: function(task){

                        var uri = $("#upload-image-view").find("img").attr("src");
                        $("#upload-image-view").find("img").remove();
                        $("#upload-image-view .u-item .u-img").append(function () {
                            return "<video src='"+uri+"'></video>"+
                                "<img src='"+"{{asset('attached/musicLogo.png')}}"+"'>";
                        });
                        $("#postForm").append(function () {
                            return "<input type='hidden' class='inputUploadFile' name='uriKey' value='"+task.json.fileKeyName+"' data='"+task.name+"'/>";
                        });
                    }
                }
            });

            //修改相册时的删除
            $("div.u-close-text").click(function (e) {
                //console.log($(this).attr("data"));
                if ($($(this)[0]).attr("data-user")!=2){
                    layer.msg("该相册为用户发布的内容禁止操作！");
                } else{
                    removeCosFile({
                        json:{
                            imgFile:$(this).attr("data"),
                            fileKeyName:$(this).attr("data"),
                        }
                    },"/admin/musics/update/remove");

                    $($($(this)[0]).parent()[0]).remove();
                }

            });

            //移除存储桶上的文件
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
                            layer.msg("文件已移除！");
                        }
                        var inputUploadFile = $(".inputUploadFile");
                            if ($(inputUploadFile).val() == task.json.fileKeyName){
                                $(inputUploadFile).remove();
                            }

                    }
                });
            }
        </script>
        @endsection
    @endsection
