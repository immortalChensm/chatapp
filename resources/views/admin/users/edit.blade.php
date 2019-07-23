@extends("layouts.main")
@section("title")
    用户管理
@endsection
@section("css")
    <link rel="stylesheet" href="{{asset("adminlte/css/common.css")}}">
    <link rel="stylesheet" href="{{asset("adminlte/css/photos.css")}}">

    <link rel="stylesheet" href="{{asset("adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css")}}">
    <link rel="stylesheet" href="{{asset("adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")}}">
    <link rel="stylesheet" href="{{asset("adminlte/plugins/iCheck/all.css")}}">
    <link rel="stylesheet" href="{{asset("adminlte/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css")}}">
    <link rel="stylesheet" href="{{asset("adminlte/plugins/timepicker/bootstrap-timepicker.min.css")}}">
    <link rel="stylesheet" href="{{asset("adminlte/bower_components/select2/dist/css/select2.min.css")}}">

    <style type="text/css">
        .ui-image .u-close-bg, .ui-image .u-close-text { display: block; }
    </style>
@endsection
@section("content")

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                用户资料
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="{{url("/admin/users")}}"><i class="fa"></i>  用户管理</a></li>
                <li class="active">用户资料</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="profile-user-img img-responsive img-circle" src="{{$data['headImgUrl']}}" alt="User profile picture">

                            <h3 class="profile-username text-center">{{$data['name']}}</h3>

                            <p class="text-muted text-center">{{$data['realName']}}</p>
                            <p class="text-muted text-center">{{$data['sex']==1?'男':'女'}}</p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>粉丝</b> <a class="pull-right">{{$data['followerNum']}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>关注</b> <a class="pull-right">{{$data['subscribeNum']}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>亲友数量</b> <a class="pull-right">{{$data['relationNum']}}</a>
                                </li>
                            </ul>

                            {{--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>--}}
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- About Me Box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">用户详情</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <strong><i class="fa fa-book margin-r-5"></i> 账号余额</strong>
                            <p class="text-muted">
                                {{$data['money']}}元
                            </p>
                            <strong><i class="fa fa-map-marker margin-r-5"></i>船票余额</strong>

                            <p class="text-muted">{{$data['shipNumber']}}张</p>
                            <strong><i class="fa fa-map-marker margin-r-5"></i>累积点赞数量</strong>

                            <p class="text-muted">{{$data['totalPraiseNum']}}个</p>

                            <strong><i class="fa fa-map-marker margin-r-5"></i>红包支出总额</strong>

                            <p class="text-muted">{{$data['sentMoney']}}元</p>

                            <strong><i class="fa fa-map-marker margin-r-5"></i>红包收入总额</strong>

                            <p class="text-muted">{{$data['recvMoney']}}元</p>

                            <strong><i class="fa fa-map-marker margin-r-5"></i>红包退回总额</strong>

                            <p class="text-muted">{{$data['refundMoney']}}元</p>

                            <strong><i class="fa fa-map-marker margin-r-5"></i>注册时间</strong>

                            <p class="text-muted">{{$data['created_at']}}</p>

                            <strong><i class="fa fa-map-marker margin-r-5"></i>最近登录IP</strong>

                            <p class="text-muted">
                                @if(!is_null($data['loginInfo'])&&isset($data['loginInfo']->loginIp))
                                    {{$data['loginInfo']->loginIp}}
                                    @else
                                    未登录
                                    @endif
                            </p>


                            <strong><i class="fa fa-map-marker margin-r-5"></i>最近登录时间</strong>

                            <p class="text-muted"> @if(!is_null($data['loginInfo'])&&isset($data['loginInfo']->loginDate))
                                    {{$data['loginInfo']->loginDate}}
                                @else
                                    ---
                                @endif</p>


                            <strong><i class="fa fa-map-marker margin-r-5"></i>登录次数</strong>

                            <p class="text-muted">@if(!is_null($data['loginInfo'])&&isset($data['loginInfo']->loginCount))
                                    {{$data['loginInfo']->loginCount}}
                                @else
                                    0
                                @endif次</p>


                            <strong><i class="fa fa-pencil margin-r-5"></i> 账号状态</strong>

                            <p>
                                <span style="display:inline-block;margin:3px auto;" class="label label-@if($data['isIm']==1)success @else danger @endif">@if($data['isIm']==1)IM账号@else普通账号@endif</span>
                                <span style="display:inline-block;margin:3px auto;" class="label label-success">{{$data['star']}}星级</span>
                                <span style="display:inline-block;margin:3px auto;" class="label @if($data['isValiated']==1)label-success @else label-danger @endif">@if($data['isValiated']==1)已认证@else未认证@endif</span>
                                <span style="display:inline-block;margin:3px auto;" class="label @if(!is_null($data['loginInfo'])&&isset($data['loginInfo']->canLogin))label-success @else label-danger @endif">@if(!is_null($data['loginInfo'])&&isset($data['loginInfo']->canLogin))可登录@else已限制登录@endif</span>
                                <span style="display:inline-block;margin:3px auto;" class="label @if(!is_null($data['loginInfo'])&&isset($data['loginInfo']->canPost))label-success @else label-danger @endif">@if(!is_null($data['loginInfo'])&&isset($data['loginInfo']->canPost))可发布文章@else已限制文章发布@endif</span>
                                <span style="display:inline-block;margin:3px auto;" class="label @if(!is_null($data['loginInfo'])&&isset($data['loginInfo']->canPhoto))label-success @else label-danger @endif">@if(!is_null($data['loginInfo'])&&isset($data['loginInfo']->canPhoto))可发布相册@else已限制发布相册@endif</span>
                                <span style="display:inline-block;margin:3px auto;" class="label @if(!is_null($data['loginInfo'])&&isset($data['loginInfo']->canMusic))label-success @else label-danger @endif">@if(!is_null($data['loginInfo'])&&isset($data['loginInfo']->canMusic))可发布音乐@else已限制发布音乐@endif</span>
                                <span style="display:inline-block;margin:3px auto;" class="label @if(!is_null($data['loginInfo'])&&isset($data['loginInfo']->canVideo))label-success @else label-danger @endif">@if(!is_null($data['loginInfo'])&&isset($data['loginInfo']->canVideo))可发布视频@else已限制发布视频@endif</span>
                                <span style="display:inline-block;margin:3px auto;" class="label @if(!is_null($data['loginInfo'])&&isset($data['loginInfo']->canComment))label-success @else label-danger @endif">@if(!is_null($data['loginInfo'])&&isset($data['loginInfo']->canComment))可评论@else已限制评论@endif</span>
                            </p>

                            <hr>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            {{--<li class="active"><a href="#activity" data-toggle="tab">聊天</a></li>--}}
                            <li class="active"><a href="#timeline" data-toggle="tab">身份证资料</a></li>
                            <li><a href="#settings" data-toggle="tab">设置</a></li>
                        </ul>
                        <div class="tab-content">
                            {{--<div class="active tab-pane" id="activity">--}}
                                {{--<!-- Post -->--}}
                                {{--<div class="post">--}}
                                    {{--<div class="user-block">--}}
                                        {{--<img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">--}}
                                        {{--<span class="username">--}}
                          {{--<a href="#">Jonathan Burke Jr.</a>--}}
                          {{--<a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>--}}
                        {{--</span>--}}
                                        {{--<span class="description">Shared publicly - 7:30 PM today</span>--}}
                                    {{--</div>--}}
                                    {{--<!-- /.user-block -->--}}
                                    {{--<p>--}}
                                        {{--Lorem ipsum represents a long-held tradition for designers,--}}
                                        {{--typographers and the like. Some people hate it and argue for--}}
                                        {{--its demise, but others ignore the hate as they create awesome--}}
                                        {{--tools to help create filler text for everyone from bacon lovers--}}
                                        {{--to Charlie Sheen fans.--}}
                                    {{--</p>--}}
                                    {{--<ul class="list-inline">--}}
                                        {{--<li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>--}}
                                        {{--<li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>--}}
                                        {{--</li>--}}
                                        {{--<li class="pull-right">--}}
                                            {{--<a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments--}}
                                                {{--(5)</a></li>--}}
                                    {{--</ul>--}}

                                    {{--<input class="form-control input-sm" type="text" placeholder="Type a comment">--}}
                                {{--</div>--}}
                                {{--<!-- /.post -->--}}

                                {{--<!-- Post -->--}}
                                {{--<div class="post clearfix">--}}
                                    {{--<div class="user-block">--}}
                                        {{--<img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image">--}}
                                        {{--<span class="username">--}}
                          {{--<a href="#">Sarah Ross</a>--}}
                          {{--<a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>--}}
                        {{--</span>--}}
                                        {{--<span class="description">Sent you a message - 3 days ago</span>--}}
                                    {{--</div>--}}
                                    {{--<!-- /.user-block -->--}}
                                    {{--<p>--}}
                                        {{--Lorem ipsum represents a long-held tradition for designers,--}}
                                        {{--typographers and the like. Some people hate it and argue for--}}
                                        {{--its demise, but others ignore the hate as they create awesome--}}
                                        {{--tools to help create filler text for everyone from bacon lovers--}}
                                        {{--to Charlie Sheen fans.--}}
                                    {{--</p>--}}

                                    {{--<form class="form-horizontal">--}}
                                        {{--<div class="form-group margin-bottom-none">--}}
                                            {{--<div class="col-sm-9">--}}
                                                {{--<input class="form-control input-sm" placeholder="Response">--}}
                                            {{--</div>--}}
                                            {{--<div class="col-sm-3">--}}
                                                {{--<button type="submit" class="btn btn-danger pull-right btn-block btn-sm">Send</button>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</form>--}}
                                {{--</div>--}}
                                {{--<!-- /.post -->--}}

                                {{--<!-- Post -->--}}
                                {{--<div class="post">--}}
                                    {{--<div class="user-block">--}}
                                        {{--<img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg" alt="User Image">--}}
                                        {{--<span class="username">--}}
                          {{--<a href="#">Adam Jones</a>--}}
                          {{--<a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>--}}
                        {{--</span>--}}
                                        {{--<span class="description">Posted 5 photos - 5 days ago</span>--}}
                                    {{--</div>--}}
                                    {{--<!-- /.user-block -->--}}
                                    {{--<div class="row margin-bottom">--}}
                                        {{--<div class="col-sm-6">--}}
                                            {{--<img class="img-responsive" src="../../dist/img/photo1.png" alt="Photo">--}}
                                        {{--</div>--}}
                                        {{--<!-- /.col -->--}}
                                        {{--<div class="col-sm-6">--}}
                                            {{--<div class="row">--}}
                                                {{--<div class="col-sm-6">--}}
                                                    {{--<img class="img-responsive" src="../../dist/img/photo2.png" alt="Photo">--}}
                                                    {{--<br>--}}
                                                    {{--<img class="img-responsive" src="../../dist/img/photo3.jpg" alt="Photo">--}}
                                                {{--</div>--}}
                                                {{--<!-- /.col -->--}}
                                                {{--<div class="col-sm-6">--}}
                                                    {{--<img class="img-responsive" src="../../dist/img/photo4.jpg" alt="Photo">--}}
                                                    {{--<br>--}}
                                                    {{--<img class="img-responsive" src="../../dist/img/photo1.png" alt="Photo">--}}
                                                {{--</div>--}}
                                                {{--<!-- /.col -->--}}
                                            {{--</div>--}}
                                            {{--<!-- /.row -->--}}
                                        {{--</div>--}}
                                        {{--<!-- /.col -->--}}
                                    {{--</div>--}}
                                    {{--<!-- /.row -->--}}

                                    {{--<ul class="list-inline">--}}
                                        {{--<li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>--}}
                                        {{--<li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>--}}
                                        {{--</li>--}}
                                        {{--<li class="pull-right">--}}
                                            {{--<a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments--}}
                                                {{--(5)</a></li>--}}
                                    {{--</ul>--}}

                                    {{--<input class="form-control input-sm" type="text" placeholder="Type a comment">--}}
                                {{--</div>--}}
                                {{--<!-- /.post -->--}}
                            {{--</div>--}}
                            <!-- /.tab-pane -->
                            <div class="active tab-pane" id="timeline">
                                <!-- The timeline -->
                                <ul class="timeline timeline-inverse">

                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <li>
                                        <i class="fa fa-camera bg-purple"></i>

                                        <div class="timeline-item">
                                            {{--<span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>--}}

                                            <h3 class="timeline-header"><a href="#">{{$data['name']}}</a>的身份证</h3>

                                            <div class="timeline-body">
                                                @if(!empty($data['idCardFace']))
                                                    <img src="{{$data['idCardFace']}}" alt="..." class="margin">
                                                    @else
                                                    头像面未上传
                                                    @endif
                                                    @if(!empty($data['idCardWall']))
                                                <img src="{{$data['idCardWall']}}" alt="..." class="margin">
                                                        @else
                                                        国徽未上传
                                                        @endif
                                            </div>
                                        </div>
                                    </li>
                                    <!-- END timeline item -->
                                    <li>
                                        <i class="fa fa-clock-o bg-gray"></i>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="settings">
                                <div class="form-group" id="login">
                                    <input type="checkbox" name="login-checkbox" checked>
                                    <label>
                                        登录权限
                                    </label>
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" name="post-checkbox" checked>
                                    <label>
                                        文章发布权限
                                    </label>
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" name="photo-checkbox" checked>
                                    <label>
                                        相册发布权限
                                    </label>
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" name="music-checkbox" checked>
                                    <label>
                                        音乐发布权限
                                    </label>
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" name="video-checkbox" checked>
                                    <label>
                                        视频发布权限
                                    </label>
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" name="comment-checkbox" checked>
                                    <label>
                                        评论权限
                                    </label>
                                </div>

                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@section("js")
    <script src="{{asset("adminlte/plugins/iCheck/icheck.min.js")}}"></script>
    <script>
        function setting(field,value,userId){
            $.ajax({
                type: 'POST',
                url: "{{url('admin/system/set')}}",
                dataType: 'json',
                data: {
                    field:field,
                    value:value,
                    userId:userId
                },
                success: function(data){
                    if (data == 1){
                        layer.msg("设置成功");

                    }else{
                        layer.msg("设置失败");
                    }
                },
                error:function(data){

                }
            });

        }


        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        })

        $("[name='login-checkbox']").bootstrapSwitch({
            onText : "启用",      // 设置ON文本  
            offText : "禁用",    // 设置OFF文本  
            onColor : "success",// 设置ON文本颜色     (info/success/warning/danger/primary)  
            offColor : "danger",  // 设置OFF文本颜色        (info/success/warning/danger/primary)  
            size : "mini",    // 设置控件大小,从小到大  (mini/small/normal/large)  
            handleWidth:"35",//设置控件宽度
            state:{{$data['loginInfo']->canLogin}}?true:false,
            // 当开关状态改变时触发  
            onSwitchChange : function(event, state) {
                var data = event.target.defaultValue;
                if (state == true) {
                    setting("canLogin",state?1:0,data);
                } else {
                    setting("canLogin",state?1:0,data);
                }
            }
        })


    </script>

@endsection
@endsection
