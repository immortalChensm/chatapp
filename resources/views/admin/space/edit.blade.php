@extends("layouts.main")
@section("title")
    文章编辑
    @endsection
@section("css")
    <link rel="stylesheet" href="{{asset("adminlte/css/common.css")}}">
    @endsection
@section("content")

    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                文章管理
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url("/admin")}}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="{{url("/admin/articles")}}"><i class="fa"></i> 文章管理</a></li>
                <li class="active">文章编辑</li>
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

                            <input type="hidden" name="articleId" value=" @if(isset($data['articleId'])){{$data['articleId']}} @endif">

                            <div class="box-body">


                                <div class="form-group edit-box">
                                    <label>文章标签</label>
                                    <select class="form-control" name="tagId"  required="required">
                                        <option value="">请选择文章标签</option>
                                        @if(!empty($tag))
                                            @foreach($tag as $item)
                                        <option value="{{$item['tagId']}}" @if(isset($data['articleId'])&&$item['tagId']==$data['tagId']) selected @endif>{{$item['name']}}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                </div>

                                <div class="form-group edit-box">
                                    <label for="exampleInputEmail1">文章标题</label>
                                    <input type="text" class="form-control input-max-box" class="edit-box" name="title" value="@if(isset($data['title'])) {{$data['title']}} @endif" placeholder="文章标题">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputEmail1">文章内容</label>

                                    <textarea id="editor" name="content" value="@if(isset($data['articleId'])){{$data['content']}}@endif" style="width:1000px;height:450px;">
                                      @if(isset($data['articleId'])) {{$data['content']}} @endif
                                    </textarea>



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

            $(function () {
                    if (KindEditor){
                    KindEditor.ready(function(K) {
                    window.editor = K.create('#editor',{
                    uploadJson:"{{url('admin/upload/file')}}"
                    });

            });


            }else{
            console.log("请引入kindeditor文件");
            }


            });

            function store(){
                    editor.sync();
                    $.ajax({
                            type: 'POST',
                            url: "{{url('admin/articles/save')}}",
                            dataType: 'json',
                            data: $('#postForm').serializeArray(),
                            success: function(data){
                                    if (data.code == 1){
                                    layer.msg(data.message);
                                    setTimeout(function () {
                                    window.location = "{{url('admin/articles')}}";
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

            @endsection
            @endsection
