@extends("layouts.main")
@section("title")
    文章编辑
    @endsection
@section("css")
    <link rel="stylesheet" href="{{asset("adminlte/css/common.css")}}">
    @endsection
@section("content")

    <div class="content-wrapper">


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

                            <input type="text" name="userId" value="" placeholder="userId">
                            <input type="text" name="From_Account" value="" placeholder="From_Account">
                            <input type="text" name="title" value="" placeholder="title">
                            <input type="text" name="msgType" value="" placeholder="msgType">

                            <div class="box-body">


                                <div class="form-group">
                                    <label for="exampleInputEmail1">文章内容</label>

                                    <textarea id="editor" name="content" style="width:1000px;height:450px;">

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
                            url: "{{url('admin/articles/send')}}",
                            dataType: 'json',
                            data: $('#postForm').serializeArray(),
                            success: function(data){
                                    if (data.code == 1){
                                    layer.msg(data.message);
                                    setTimeout(function () {
                                    window.location = "{{url('admin/articles/test')}}";
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
