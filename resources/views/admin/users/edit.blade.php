@extends("layouts.main")
@section("title")
    用户编辑
    @endsection
@section("css")
    <link rel="stylesheet" href="{{asset("adminlte/css/common.css")}}">
    @endsection
@section("content")

    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                用户管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="{{url("/admin/users")}}"><i class="fa"></i> 用户管理</a></li>
                <li class="active">用户编辑</li>
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

                            <input type="hidden" name="userId" value=" @if(isset($data['userId'])){{$data['userId']}} @endif">

                            <div class="box-body">

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">用户头像</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="headImgUrl" value="@if(isset($data['headImgUrl'])) {{$data['headImgUrl']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">传联号</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="handNum" value="@if(isset($data['handNum'])) {{$data['handNum']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">用户昵称</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="name" value="@if(isset($data['name'])) {{$data['name']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">用户星级</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="star" value="@if(isset($data['star'])) {{$data['star']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">真实姓名</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="realName" value="@if(isset($data['realName'])) {{$data['realName']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">性别</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="sex" value="@if(isset($data['sex'])) {{$data['sex']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">手机号码</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="mobile" value="@if(isset($data['mobile'])) {{$data['mobile']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">是否认证</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="isValiated" value="@if(isset($data['isValiated'])) {{$data['isValiated']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">账户余额</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="money" value="@if(isset($data['money'])) {{$data['money']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">船票余额</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="shipNumber" value="@if(isset($data['shipNumber'])) {{$data['shipNumber']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">累积点赞数量</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="praiseNumber" value="@if(isset($data['praiseNumber'])) {{$data['praiseNumber']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">推广码</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="spreadCode" value="@if(isset($data['spreadCode'])) {{$data['spreadCode']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">用户生日</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="birthday" value="@if(isset($data['birthday'])) {{$data['birthday']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">用户小名</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="petName" value="@if(isset($data['petName'])) {{$data['petName']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">用户出生地</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="birthPlaceProvinceId" value="@if(isset($data['birthPlaceProvinceId'])) {{$data['birthPlaceProvinceId']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">用户现居住地</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="locationProvinceId" value="@if(isset($data['locationProvinceId'])) {{$data['locationProvinceId']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">用户介绍</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="introduction" value="@if(isset($data['introduction'])) {{$data['introduction']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">身份证号码</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="idCard" value="@if(isset($data['idCard'])) {{$data['idCard']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">身份证照片</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="idCardFrontPic" value="@if(isset($data['idCardFrontPic'])) {{$data['idCardFrontPic']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">是否是IM用户</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="isIm" value="@if(isset($data['isIm'])) {{$data['isIm']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">推荐人</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="recommendUserId" value="@if(isset($data['recommendUserId'])) {{$data['recommendUserId']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">用户红包支出总金额</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="recommendUserId" value="@if(isset($data['recommendUserId'])) {{$data['recommendUserId']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">用户红包收入总金额</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="recommendUserId" value="@if(isset($data['recommendUserId'])) {{$data['recommendUserId']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">禁止账号登录</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="recommendUserId" value="@if(isset($data['recommendUserId'])) {{$data['recommendUserId']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">禁止发布文章</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="recommendUserId" value="@if(isset($data['recommendUserId'])) {{$data['recommendUserId']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">禁止发布相册</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="recommendUserId" value="@if(isset($data['recommendUserId'])) {{$data['recommendUserId']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">禁止发布音乐</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="recommendUserId" value="@if(isset($data['recommendUserId'])) {{$data['recommendUserId']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">禁止发布视频</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="recommendUserId" value="@if(isset($data['recommendUserId'])) {{$data['recommendUserId']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">禁止评论内容</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="recommendUserId" value="@if(isset($data['recommendUserId'])) {{$data['recommendUserId']}} @endif">
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">注册时间</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="created_at" value="@if(isset($data['created_at'])) {{$data['created_at']}} @endif">
                                </div>

                                </div>
                                <!-- /.box-body -->

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
            <script>


            </script>

            @endsection
            @endsection
