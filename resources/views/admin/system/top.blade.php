@extends("layouts.main")
@section("title")
    置顶记录
@endsection
@section("css")
    <link rel="stylesheet" href="{{asset("adminlte/css/common.css")}}">
    <link rel="stylesheet" href="{{asset("adminlte/css/photos.css")}}">
    <style type="text/css">
        .ui-image .u-close-bg, .ui-image .u-close-text { display: block; }
    </style>
@endsection
@section("content")

    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                系统设置
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li class="active">置顶记录</li>
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
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tbody><tr>
                                    <th>ID</th>
                                    <th>置顶数据ID</th>
                                    <th>置顶类型</th>
                                    <th>置顶数据标题</th>
                                    <th>置顶时间</th>
                                </tr>
                                <tr>
                                    <td>{{$data->id}}</td>
                                    <td>{{$data->topId}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->title}}</td>
                                    <td>{{$data->created_at}}</td>
                                </tr>
                                </tbody></table>
                        </div>
                    </div>


                </div>

            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@section("js")

@endsection
@endsection
