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
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <form role="form" id="postForm">
                        {{csrf_field()}}

                        <input type="hidden" name="videoId" data-id = "@if(isset($data['videoId'])){{$data['videoId']}} @endif" data-user = "@if(isset($data['videoId'])){{$data['userType']}} @endif" value=" @if(isset($data['videoId'])){{$data['videoId']}} @endif">
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
                                            <div id="upload-image-view" class="clearfix">
                                                <div class="progress" style="width:50%;margin:0px 0px 0px -16px;display:none">
                                                    <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                                                        <span class="sr-only">20% Complete (success)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if(isset($data['videoId']))
                                            <div id="upload-image-view" class="clearfix ui-image html5">

                                                <div class="u-item u-over">
                                                    <div class="u-img">
                                                        {{--<img src="{{asset("attached/musicLogo.png")}}">--}}
                                                        <video src="{{$data['uri']}}" autoplay controls></video>
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

    <script src="{{asset("cos/common/cos-auth.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("webuploader/demo/demo.js")}}"></script>
    <script type="text/javascript" src="{{asset("webuploader/js/Q.js")}}"></script>
    <script type="text/javascript" src="{{asset("webuploader/js/Q.Uploader.js")}}"></script>
    <script type="text/javascript" src="{{asset("webuploader/js/Q.Uploader.UI.Image.js")}}"></script>

    <script>

        function getCosFileUri(obj)
        {
            $.ajax({
                type: 'GET',
                url: "{{url('admin/videos/uri')}}",
                dataType: 'json',
                data: {
                    "fileKeyName":obj.fileKeyName,
                },
                success: function(data){
                    if (data.code==1){
                        $("#upload-image-view").append(function () {
                            return '<div class="u-item u-over">'+
                                '<div class="u-img">'+
                                //'<img src="{{asset("attached/musicLogo.png")}}">'+
                                '<video src="'+data.message+'" autoplay controls></video>'+
                                '</div>'+
                                '<div class="u-progress-bar" style="opacity: 0.3;">'+
                                '<div class="u-progress" style="opacity: 0.5; width: 100%;"></div>'+
                                '</div>'+
                                '<div class="u-name" title="'+obj.fileKeyName+'">'+obj.fileKeyName+'</div>'+
                                '<div class="u-close-bg" style="opacity: 0.3;"></div>'+
                                '<div class="u-close-text" data="'+obj.fileKeyName+'" data-user="2">X</div>'+
                                '</div>';
                        }).addClass("clearfix ui-image html5");

                        $("#postForm").append(function () {
                            return "<input type='hidden' class='inputUploadFile' name='uriKey' value='"+obj.fileKeyName+"' data='"+obj.fileKeyName+"'/>";
                        });
                        console.log(data);
                    }
                },
                error:function(data){
                    console.log(data)
                }
            });
        }
        // 请求用到的参数
        var Bucket = 'chatapp-1258883738';
        var Region = 'ap-chengdu';
        var protocol = location.protocol === 'https:' ? 'https:' : 'http:';
        var prefix = protocol + '//' + Bucket + '.cos.' + Region + '.myqcloud.com/';

        // 对更多字符编码的 url encode 格式
        var camSafeUrlEncode = function (str) {
            return encodeURIComponent(str)
                .replace(/!/g, '%21')
                .replace(/'/g, '%27')
                .replace(/\(/g, '%28')
                .replace(/\)/g, '%29')
                .replace(/\*/g, '%2A');
        };

        // 计算签名
        var getAuthorization = function (options, callback) {
            var url = "{{url('admin/js/upload/key')}}";
            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.onload = function (e) {
                var credentials;
                try {
                    credentials = (new Function('return ' + xhr.responseText))().credentials;
                } catch (e) {}
                if (credentials) {
                    callback(null, {
                        XCosSecurityToken: credentials.sessionToken,
                        Authorization: CosAuth({
                            SecretId: credentials.tmpSecretId,
                            SecretKey: credentials.tmpSecretKey,
                            Method: options.Method,
                            Pathname: options.Pathname,
                        })
                    });
                } else {
                    console.error(xhr.responseText);
                    callback('获取签名出错');
                }
            };
            xhr.onerror = function (e) {
                callback('获取签名出错');
            };
            xhr.send();
        };

        // 上传文件
        var uploadFile = function (file, callback) {

            var KeyName = 'other/' + file.name; // 这里指定上传目录和文件名
            getAuthorization({Method: 'PUT', Pathname: '/' + KeyName}, function (err, info) {

                if (err) {
                    alert(err);
                    return;
                }

                var auth = info.Authorization;
                var XCosSecurityToken = info.XCosSecurityToken;
                var url = prefix + camSafeUrlEncode(KeyName).replace(/%2F/, '/');
                var xhr = new XMLHttpRequest();
                xhr.open('PUT', url, true);
                xhr.setRequestHeader('Authorization', auth);
                XCosSecurityToken && xhr.setRequestHeader('x-cos-security-token', XCosSecurityToken);
                xhr.upload.onprogress = function (e) {

                    if($("#upload-image-view").find("div.progress").length<=0){
                        $("#upload-image-view").append(function () {
                            return '<div id="upload-image-view" class="clearfix">'+
                                '<div class="progress" style="width:50%;margin:0px 0px 0px -16px;">'+
                                '<div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%">'+
                                '<span class="sr-only">20% Complete (success)</span>' +
                                '</div>'+
                                '</div>'+
                                '</div>';
                        });
                    }
console.log((Math.round(e.loaded / e.total * 10000) / 100));
                    $("#upload-image-view").find("div.progress div").css("width",(Math.round(e.loaded / e.total * 10000) / 100) + '%');
                    $("#upload-image-view").find("div.progress div").text((Math.round(e.loaded / e.total * 10000) / 100) + '%');

                };
                xhr.onload = function () {
                    if (xhr.status === 200 || xhr.status === 206) {
                        var ETag = xhr.getResponseHeader('etag');
                        $("#upload-image-view").find("div.progress").hide();
                        $("#upload-image-view").find("div.progress").find("div").text("");
                        $("#upload-image-view").find("div.progress").find("div").css("width","");

                        getCosFileUri({fileKeyName:KeyName});

                    } else {
                        callback('文件 ' + KeyName + ' 上传失败，状态码：' + xhr.status);
                    }
                };
                xhr.onerror = function (error) {
                    //callback('文件 ' + Key + ' 上传失败，请检查是否没配置 CORS 跨域规则');
                    layer.msg('上传失败，请检查是否没配置 CORS 跨域规则');
                    console.log(error);
                };
                xhr.send(file);
            });
        };

    </script>
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
            task.file && uploadFile(task.file, function (err, data) {
                console.log(data)

            });
            return false;

        },
            remove: function (task) {
                removeCosFile(task,"{{url('/admin/remove/upload/file')}}");
            },
            complete: function(task){
            }
        }
    });

    //删除
    $("#upload-image-view").on("click","div.u-close-text",function (e) {
        if ($($(this)[0]).attr("data-user")==1){
            layer.msg("该内容为用户发布的内容禁止操作！");
        } else{
            removeCosFile({
                json:{
                imgFile:$(this).attr("data"),
                fileKeyName:$(this).attr("data"),
                }
            },"/admin/videos/update/remove");

            //$($($(this)[0]).parent()[0]).remove();
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

            $("#upload-image-view").find("*").remove();
        }
        });
    }
    </script>

@endsection
@endsection
