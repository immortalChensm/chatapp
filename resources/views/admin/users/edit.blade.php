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
                        <form class="form-horizontal">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">用户头像</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control"  style="border: none" value="@if(isset($data['headImgUrl'])) {{$data['headImgUrl']}} @endif">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">传联号</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="@if(isset($data['handNum'])) {{$data['handNum']}} @endif">
                                    </div>
                                </div>


                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-default">Cancel</button>
                                <button type="submit" class="btn btn-info pull-right">Sign in</button>
                            </div>
                            <!-- /.box-footer -->
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
