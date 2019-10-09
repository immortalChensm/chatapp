<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 0.0.1
    </div>
    <strong>Copyright &copy; 2019-2030 <a href="https://adminlte.io">传联科技</a>.</strong> All rights
    reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                            <p>Will be 23 on April 24th</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-user bg-yellow"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                            <p>New phone +1(800)555-1234</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                            <p>nora@example.com</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-file-code-o bg-green"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                            <p>Execution time 5 seconds</p>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Custom Template Design
                            <span class="label label-danger pull-right">70%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Update Resume
                            <span class="label label-success pull-right">95%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Laravel Integration
                            <span class="label label-warning pull-right">50%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Back End Framework
                            <span class="label label-primary pull-right">68%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

        </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
                <h3 class="control-sidebar-heading">General Settings</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Report panel usage
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Some information about this general settings option
                    </p>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Allow mail redirect
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Other sets of options are available
                    </p>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Expose author name in posts
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Allow the user to show his name in blog posts
                    </p>
                </div>
                <!-- /.form-group -->

                <h3 class="control-sidebar-heading">Chat Settings</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Show me as online
                        <input type="checkbox" class="pull-right" checked>
                    </label>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Turn off notifications
                        <input type="checkbox" class="pull-right">
                    </label>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Delete chat history
                        <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                    </label>
                </div>
                <!-- /.form-group -->
            </form>
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>


</div>

@include ("layouts.im")


<!-- jQuery 3 -->
<script src="{{asset("adminlte/bower_components/jquery/dist/jquery.min.js")}}"></script>
<script src="{{asset("adminlte/js/switch.js")}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset("adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js")}}"></script>
<!-- SlimScroll -->
{{--<script src="{{asset("adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js")}}"></script>--}}
<!-- FastClick -->
<script src="{{asset("adminlte/bower_components/fastclick/lib/fastclick.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{asset("adminlte/dist/js/adminlte.min.js")}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset("adminlte/dist/js/demo.js")}}"></script>
<script src="{{asset("adminlte/js/datasheet.js")}}"></script>
<script src="{{asset("layer/layer.js")}}"></script>


<script charset="utf-8" src="{{asset("kindeditor/kindeditor-all-min.js")}}"></script>
<script charset="utf-8" src="{{asset("kindeditor/lang/zh-CN.js")}}"></script>
<script>


    function openWin() {
        var url='http://47.110.136.62:8092/index.html?account={{session('imToken')}}';                             //转向网页的地址;
        var name='传联客服聊天系统';                            //网页名称，可为空;
        var iWidth=1000;                          //弹出窗口的宽度;
        var iHeight=700;                         //弹出窗口的高度;
        //获得窗口的垂直位置
        var iTop = (window.screen.availHeight - 30 - iHeight) / 2;
        //获得窗口的水平位置
        var iLeft = (window.screen.availWidth - 10 - iWidth) / 2;
        window.open(url, name, 'height=' + iHeight + ',,innerHeight=' + iHeight + ',width=' + iWidth + ',innerWidth=' + iWidth + ',top=' + iTop + ',left=' + iLeft + ',status=no,toolbar=no,menubar=no,location=no,resizable=no,scrollbars=0,titlebar=no,location=no');
        // window.open("AddScfj.aspx", "newWindows", 'height=100,width=400,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
    }

    $("#message").click(function () {

        //window.open("http://im.com/","_blank","toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=1000, height=650");
        openWin();
    });

    function logout()
    {
        window.location.href='/admin/logout';

    }

    function sendMessageToUserWhenShowOrShareAction(userId,action,show,share,articleTitle) {
        if (userId!=0){

            if (action=='isShow'){
                $.ajax({
                    type: "post",
                    url: "{{url('/admin/customer/sendMsg')}}",
                    dataType: 'json',
                    data: {
                        "_token":"{{csrf_token()}}",
                        content:(show==1?"你发布的<<"+articleTitle+">>内容存在违规系统已屏蔽":"你发布的<<"+articleTitle+">>内容已解除屏蔽"),
                        userId:userId,
                        msgType:6,
                        title:'系统警告',
                    },
                    success: function(data){
                        if (data.code==1){
                            //layer.msg("操作成功");
                        }else{
                            //layer.msg(data.message);
                        }
                    },
                    error:function(data){

                    }
                });
            }
            if (action=='disableShare'){
                $.ajax({
                    type: "post",
                    url: "{{url('/admin/customer/sendMsg')}}",
                    dataType: 'json',
                    data: {
                        "_token":"{{csrf_token()}}",
                        content:(share==1?"你发布的<<"+articleTitle+">>内容存在违规系统已禁止分享":"你发布的<<"+articleTitle+">>内容已解除分享功能"),
                        userId:userId,
                        msgType:6,
                        title:'系统警告',
                    },
                    success: function(data){
                        if (data.code==1){
                            //layer.msg("操作成功");
                        }else{
                            //layer.msg(data.message);
                        }
                    },
                    error:function(data){

                    }
                });
            }

        }

    }


</script>

@yield("js")

</body>
</html>
