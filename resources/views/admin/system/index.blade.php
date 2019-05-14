@extends("layouts.main")
@section("title")
    网站设置
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
                <li class="active">网站设置</li>
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

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">用户注册短期存储空间大小</label>


                                    @if (isset($data))
                                        @foreach($data as $item)
                                            @if($item->name == 'tempSize')
                                                <input type="number" class="form-control input-max-box" class="edit-box" name="config[tempSize]" value="{{$item->value}}" placeholder="空间大小M">

                                            @endif
                                        @endforeach
                                        @else
                                        <input type="number" class="form-control input-max-box" class="edit-box" name="config[tempSize]" value="" placeholder="空间大小M">
                                    @endif
                                    (注册时的临时存储空间大小，默认单位为M)
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">用户多久未登录会清空数据</label>>
                                    @if (isset($data))
                                        @foreach($data as $item)

                                            @if($item->name == 'noLogDay')
                                                <input type="number" class="form-control input-max-box" class="edit-box" name="config[noLogDay]" value="{{$item->value}}" placeholder="单位为天">
                                            @endif
                                        @endforeach
                                        @else
                                        <input type="number" class="form-control input-max-box" class="edit-box" name="config[noLogDay]" value="" placeholder="单位为天">
                                    @endif
                                    (用户距离上次登录时间未活动时清空数据，单位为天)
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">用户分享的数据多少个赞得一张船票</label>
                                    @if (isset($data))
                                        @foreach($data as $item)

                                            @if($item->name == 'praiseToShip')
                                                <input type="number" class="form-control input-max-box" class="edit-box" name="config[praiseToShip]" value="{{$item->value}}" placeholder="单位为赞个数">
                                            @endif
                                        @endforeach
                                        @else
                                        <input type="number" class="form-control input-max-box" class="edit-box" name="config[praiseToShip]" value="" placeholder="单位为赞个数">
                                    @endif

                                    (用户分享的数据多少个赞得一张船票，单位为个)
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">用户累积多少张船票升一级</label>

                                    @if (isset($data))
                                        @foreach($data as $item)

                                            @if($item->name == 'shipToGrade')
                                                <input type="number" class="form-control input-max-box" class="edit-box" name="config[shipToGrade]" value="{{$item->value}}" placeholder="单位为张">
                                            @endif
                                        @endforeach
                                        @else
                                        <input type="number" class="form-control input-max-box" class="edit-box" name="config[shipToGrade]" value="" placeholder="单位为张">
                                    @endif
                                    (用户累积多少张船票升一级，单位为张)
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
