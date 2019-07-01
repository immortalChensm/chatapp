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

                            <input type="hidden" name="articleId" value=" @if(isset($data['userId'])){{$data['userId']}} @endif">

                            <div class="box-body">

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">传联号</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="handNum" value="@if(isset($data['handNum'])) {{$data['handNum']}} @endif">
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
