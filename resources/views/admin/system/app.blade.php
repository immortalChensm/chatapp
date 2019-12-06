@extends("layouts.main")
@section("title")
    APP应用设置
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
                <li class="active">APP应用设置</li>
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
                            <div class="box-body">
                                @foreach($data as $item)
                                        <div class="form-group edit-box">
                                            <label for="exampleInputEmail1">{{$item->item}}</label>
                                            <input type="{{$item->type}}" class="form-control input-max-box" class="edit-box" name="config[{{$item->name}}]" value="{{$item->value}}" placeholder="请输入数据">
                                            (<span>{{$item->description}}</span>)
                                        </div>

                                    @endforeach

                            </div>
                            <div class="box-footer">
                                <a  class="btn btn-success" onclick="store()">提交</a>
{{--                                <a href="{{url()->previous()}}" class="btn btn-info">返回</a>--}}
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
        function store(){
            $.ajax({
                type: 'POST',
                url: "{{url('admin/system/set')}}",
                dataType: 'json',
                data: $('#postForm').serializeArray(),
                success: function(data){
                    if (data.code == 1){
                        layer.msg(data.message);
                        setTimeout(function () {
                            window.location = "{{url('admin/system/index')}}";
                        },2000);

                    }else{
                        layer.msg(data.message);
                    }
                },
                error:function(data){

                }
            });

        }

    </script>

@endsection
@endsection
