@extends("layouts.main")

    @section("css")
    <link rel="stylesheet" href="{{asset("adminlte/bower_components/morris.js/morris.css")}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{asset("adminlte/bower_components/jvectormap/jquery-jvectormap.css")}}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{asset("adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset("adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css")}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset("adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset("adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css")}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset("adminlte/bower_components/font-awesome/css/font-awesome.min.css")}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset("adminlte/bower_components/Ionicons/css/ionicons.min.css")}}">
    <!-- jvectormap -->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("adminlte/dist/css/AdminLTE.min.css")}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset("adminlte/dist/css/skins/_all-skins.min.css")}}">
    @endsection

@section("content")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Version 2.0</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">注册人数</span>
                            <span class="info-box-number">90<small>%</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">内容发布量</span>
                            <span class="info-box-number">41,410</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">船票销售额</span>
                            <span class="info-box-number">760</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">注册人数</span>
                            <span class="info-box-number">2,000</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">
                    <!-- MAP & BOX PANE -->
                    <!-- /.box -->
                    <div class="row">
                        {{--<div class="col-md-6">--}}
                            {{--<!-- DIRECT CHAT -->--}}
                            {{--<div class="box box-warning direct-chat direct-chat-warning">--}}
                                {{--<div class="box-header with-border">--}}
                                    {{--<h3 class="box-title">会员消息</h3>--}}

                                    {{--<div class="box-tools pull-right">--}}
                                        {{--<span data-toggle="tooltip" title="3 New Messages" class="badge bg-yellow">3</span>--}}
                                        {{--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>--}}
                                        {{--</button>--}}
                                        {{--<button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts"--}}
                                                {{--data-widget="chat-pane-toggle">--}}
                                            {{--<i class="fa fa-comments"></i></button>--}}
                                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>--}}
                                        {{--</button>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<!-- /.box-header -->--}}
                                {{--<div class="box-body">--}}
                                    {{--<!-- Conversations are loaded here -->--}}
                                    {{--<div class="direct-chat-messages">--}}
                                        {{--<!-- Message. Default to the left -->--}}
                                        {{--<div class="direct-chat-msg">--}}
                                            {{--<div class="direct-chat-info clearfix">--}}
                                                {{--<span class="direct-chat-name pull-left">Alexander Pierce</span>--}}
                                                {{--<span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>--}}
                                            {{--</div>--}}
                                            {{--<!-- /.direct-chat-info -->--}}
                                            {{--<img class="direct-chat-img" src="{{asset("adminlte/dist/img/user1-128x128.jpg")}}" alt="message user image">--}}
                                            {{--<!-- /.direct-chat-img -->--}}
                                            {{--<div class="direct-chat-text">--}}
                                                {{--Is this template really for free? That's unbelievable!--}}
                                            {{--</div>--}}
                                            {{--<!-- /.direct-chat-text -->--}}
                                        {{--</div>--}}
                                        {{--<!-- /.direct-chat-msg -->--}}

                                        {{--<!-- Message to the right -->--}}
                                        {{--<div class="direct-chat-msg right">--}}
                                            {{--<div class="direct-chat-info clearfix">--}}
                                                {{--<span class="direct-chat-name pull-right">Sarah Bullock</span>--}}
                                                {{--<span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>--}}
                                            {{--</div>--}}
                                            {{--<!-- /.direct-chat-info -->--}}
                                            {{--<img class="direct-chat-img" src="{{asset("adminlte/dist/img/user3-128x128.jpg")}}" alt="message user image">--}}
                                            {{--<!-- /.direct-chat-img -->--}}
                                            {{--<div class="direct-chat-text">--}}
                                                {{--You better believe it!--}}
                                            {{--</div>--}}
                                            {{--<!-- /.direct-chat-text -->--}}
                                        {{--</div>--}}
                                        {{--<!-- /.direct-chat-msg -->--}}

                                        {{--<!-- Message. Default to the left -->--}}
                                        {{--<div class="direct-chat-msg">--}}
                                            {{--<div class="direct-chat-info clearfix">--}}
                                                {{--<span class="direct-chat-name pull-left">Alexander Pierce</span>--}}
                                                {{--<span class="direct-chat-timestamp pull-right">23 Jan 5:37 pm</span>--}}
                                            {{--</div>--}}
                                            {{--<!-- /.direct-chat-info -->--}}
                                            {{--<img class="direct-chat-img" src="{{asset("adminlte/dist/img/user1-128x128.jpg")}}" alt="message user image">--}}
                                            {{--<!-- /.direct-chat-img -->--}}
                                            {{--<div class="direct-chat-text">--}}
                                                {{--Working with AdminLTE on a great new app! Wanna join?--}}
                                            {{--</div>--}}
                                            {{--<!-- /.direct-chat-text -->--}}
                                        {{--</div>--}}
                                        {{--<!-- /.direct-chat-msg -->--}}

                                        {{--<!-- Message to the right -->--}}
                                        {{--<div class="direct-chat-msg right">--}}
                                            {{--<div class="direct-chat-info clearfix">--}}
                                                {{--<span class="direct-chat-name pull-right">Sarah Bullock</span>--}}
                                                {{--<span class="direct-chat-timestamp pull-left">23 Jan 6:10 pm</span>--}}
                                            {{--</div>--}}
                                            {{--<!-- /.direct-chat-info -->--}}
                                            {{--<img class="direct-chat-img" src="{{asset("adminlte/dist/img/user3-128x128.jpg")}}" alt="message user image">--}}
                                            {{--<!-- /.direct-chat-img -->--}}
                                            {{--<div class="direct-chat-text">--}}
                                                {{--I would love to.--}}
                                            {{--</div>--}}
                                            {{--<!-- /.direct-chat-text -->--}}
                                        {{--</div>--}}
                                        {{--<!-- /.direct-chat-msg -->--}}

                                    {{--</div>--}}
                                    {{--<!--/.direct-chat-messages-->--}}

                                    {{--<!-- Contacts are loaded here -->--}}
                                    {{--<div class="direct-chat-contacts">--}}
                                        {{--<ul class="contacts-list">--}}
                                            {{--<li>--}}
                                                {{--<a href="#">--}}
                                                    {{--<img class="contacts-list-img" src="{{asset("adminlte/dist/img/user1-128x128.jpg")}}" alt="User Image">--}}

                                                    {{--<div class="contacts-list-info">--}}
                                {{--<span class="contacts-list-name">--}}
                                  {{--Count Dracula--}}
                                  {{--<small class="contacts-list-date pull-right">2/28/2015</small>--}}
                                {{--</span>--}}
                                                        {{--<span class="contacts-list-msg">How have you been? I was...</span>--}}
                                                    {{--</div>--}}
                                                    {{--<!-- /.contacts-list-info -->--}}
                                                {{--</a>--}}
                                            {{--</li>--}}
                                            {{--<!-- End Contact Item -->--}}
                                            {{--<li>--}}
                                                {{--<a href="#">--}}
                                                    {{--<img class="contacts-list-img" src="{{asset("adminlte/dist/img/user7-128x128.jpg")}}" alt="User Image">--}}

                                                    {{--<div class="contacts-list-info">--}}
                                {{--<span class="contacts-list-name">--}}
                                  {{--Sarah Doe--}}
                                  {{--<small class="contacts-list-date pull-right">2/23/2015</small>--}}
                                {{--</span>--}}
                                                        {{--<span class="contacts-list-msg">I will be waiting for...</span>--}}
                                                    {{--</div>--}}
                                                    {{--<!-- /.contacts-list-info -->--}}
                                                {{--</a>--}}
                                            {{--</li>--}}
                                            {{--<!-- End Contact Item -->--}}
                                            {{--<li>--}}
                                                {{--<a href="#">--}}
                                                    {{--<img class="contacts-list-img" src="{{asset("adminlte/dist/img/user3-128x128.jpg")}}" alt="User Image">--}}

                                                    {{--<div class="contacts-list-info">--}}
                                {{--<span class="contacts-list-name">--}}
                                  {{--Nadia Jolie--}}
                                  {{--<small class="contacts-list-date pull-right">2/20/2015</small>--}}
                                {{--</span>--}}
                                                        {{--<span class="contacts-list-msg">I'll call you back at...</span>--}}
                                                    {{--</div>--}}
                                                    {{--<!-- /.contacts-list-info -->--}}
                                                {{--</a>--}}
                                            {{--</li>--}}
                                            {{--<!-- End Contact Item -->--}}
                                            {{--<li>--}}
                                                {{--<a href="#">--}}
                                                    {{--<img class="contacts-list-img" src="{{asset("adminlte/dist/img/user5-128x128.jpg")}}" alt="User Image">--}}

                                                    {{--<div class="contacts-list-info">--}}
                                {{--<span class="contacts-list-name">--}}
                                  {{--Nora S. Vans--}}
                                  {{--<small class="contacts-list-date pull-right">2/10/2015</small>--}}
                                {{--</span>--}}
                                                        {{--<span class="contacts-list-msg">Where is your new...</span>--}}
                                                    {{--</div>--}}
                                                    {{--<!-- /.contacts-list-info -->--}}
                                                {{--</a>--}}
                                            {{--</li>--}}
                                            {{--<!-- End Contact Item -->--}}
                                            {{--<li>--}}
                                                {{--<a href="#">--}}
                                                    {{--<img class="contacts-list-img" src="{{asset("adminlte/dist/img/user6-128x128.jpg")}}" alt="User Image">--}}

                                                    {{--<div class="contacts-list-info">--}}
                                {{--<span class="contacts-list-name">--}}
                                  {{--John K.--}}
                                  {{--<small class="contacts-list-date pull-right">1/27/2015</small>--}}
                                {{--</span>--}}
                                                        {{--<span class="contacts-list-msg">Can I take a look at...</span>--}}
                                                    {{--</div>--}}
                                                    {{--<!-- /.contacts-list-info -->--}}
                                                {{--</a>--}}
                                            {{--</li>--}}
                                            {{--<!-- End Contact Item -->--}}
                                            {{--<li>--}}
                                                {{--<a href="#">--}}
                                                    {{--<img class="contacts-list-img" src="{{asset("adminlte/dist/img/user8-128x128.jpg")}}" alt="User Image">--}}

                                                    {{--<div class="contacts-list-info">--}}
                                {{--<span class="contacts-list-name">--}}
                                  {{--Kenneth M.--}}
                                  {{--<small class="contacts-list-date pull-right">1/4/2015</small>--}}
                                {{--</span>--}}
                                                        {{--<span class="contacts-list-msg">Never mind I found...</span>--}}
                                                    {{--</div>--}}
                                                    {{--<!-- /.contacts-list-info -->--}}
                                                {{--</a>--}}
                                            {{--</li>--}}
                                            {{--<!-- End Contact Item -->--}}
                                        {{--</ul>--}}
                                        {{--<!-- /.contatcts-list -->--}}
                                    {{--</div>--}}
                                    {{--<!-- /.direct-chat-pane -->--}}
                                {{--</div>--}}
                                {{--<!-- /.box-body -->--}}
                                {{--<div class="box-footer">--}}
                                    {{--<form action="#" method="post">--}}
                                        {{--<div class="input-group">--}}
                                            {{--<input type="text" name="message" placeholder="Type Message ..." class="form-control">--}}
                                            {{--<span class="input-group-btn">--}}
                            {{--<button type="button" class="btn btn-warning btn-flat">Send</button>--}}
                          {{--</span>--}}
                                        {{--</div>--}}
                                    {{--</form>--}}
                                {{--</div>--}}
                                {{--<!-- /.box-footer-->--}}
                            {{--</div>--}}
                            {{--<!--/.direct-chat -->--}}
                        {{--</div>--}}
                        <!-- /.col -->

                        <div class="col-md-12">
                            <!-- USERS LIST -->
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">最近的注册会员</h3>

                                    <div class="box-tools pull-right">
                                        <span class="label label-danger">8 New Members</span>
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <ul class="users-list clearfix">
                                        <li>
                                            <img src="{{asset("adminlte/dist/img/user1-128x128.jpg")}}" alt="User Image">
                                            <a class="users-list-name" href="#">Alexander Pierce</a>
                                            <span class="users-list-date">Today</span>
                                        </li>
                                        <li>
                                            <img src="{{asset("adminlte/dist/img/user8-128x128.jpg")}}" alt="User Image">
                                            <a class="users-list-name" href="#">Norman</a>
                                            <span class="users-list-date">Yesterday</span>
                                        </li>
                                        <li>
                                            <img src="{{asset("adminlte/dist/img/user7-128x128.jpg")}}" alt="User Image">
                                            <a class="users-list-name" href="#">Jane</a>
                                            <span class="users-list-date">12 Jan</span>
                                        </li>
                                        <li>
                                            <img src="{{asset("adminlte/dist/img/user6-128x128.jpg")}}" alt="User Image">
                                            <a class="users-list-name" href="#">John</a>
                                            <span class="users-list-date">12 Jan</span>
                                        </li>
                                        <li>
                                            <img src="{{asset("adminlte/dist/img/user2-160x160.jpg")}}" alt="User Image">
                                            <a class="users-list-name" href="#">Alexander</a>
                                            <span class="users-list-date">13 Jan</span>
                                        </li>
                                        <li>
                                            <img src="{{asset("adminlte/dist/img/user5-128x128.jpg")}}" alt="User Image">
                                            <a class="users-list-name" href="#">Sarah</a>
                                            <span class="users-list-date">14 Jan</span>
                                        </li>
                                        <li>
                                            <img src="{{asset("adminlte/dist/img/user4-128x128.jpg")}}" alt="User Image">
                                            <a class="users-list-name" href="#">Nora</a>
                                            <span class="users-list-date">15 Jan</span>
                                        </li>
                                        <li>
                                            <img src="{{asset("adminlte/dist/img/user3-128x128.jpg")}}" alt="User Image">
                                            <a class="users-list-name" href="#">Nadia</a>
                                            <span class="users-list-date">15 Jan</span>
                                        </li>
                                    </ul>
                                    <!-- /.users-list -->
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer text-center">
                                    <a href="javascript:void(0)" class="uppercase">View All Users</a>
                                </div>
                                <!-- /.box-footer -->
                            </div>
                            <!--/.box -->
                        </div>


                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- TABLE: LATEST ORDERS -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">最近的船票订单</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Item</th>
                                        <th>Status</th>
                                        <th>Popularity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                        <td>Call of Duty IV</td>
                                        <td><span class="label label-success">Shipped</span></td>
                                        <td>
                                            <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                        <td>Samsung Smart TV</td>
                                        <td><span class="label label-warning">Pending</span></td>
                                        <td>
                                            <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                        <td>iPhone 6 Plus</td>
                                        <td><span class="label label-danger">Delivered</span></td>
                                        <td>
                                            <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                        <td>Samsung Smart TV</td>
                                        <td><span class="label label-info">Processing</span></td>
                                        <td>
                                            <div class="sparkbar" data-color="#00c0ef" data-height="20">90,80,-90,70,-61,83,63</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                        <td>Samsung Smart TV</td>
                                        <td><span class="label label-warning">Pending</span></td>
                                        <td>
                                            <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                        <td>iPhone 6 Plus</td>
                                        <td><span class="label label-danger">Delivered</span></td>
                                        <td>
                                            <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                        <td>Call of Duty IV</td>
                                        <td><span class="label label-success">Shipped</span></td>
                                        <td>
                                            <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->

                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @section("js")
        <script src="{{asset("adminlte/bower_components/jquery-ui/jquery-ui.min.js")}}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.7 -->

        <!-- Morris.js charts -->
        <script src="{{asset("adminlte/bower_components/raphael/raphael.min.js")}}"></script>
        <script src="{{asset("adminlte/bower_components/morris.js/morris.min.js")}}"></script>
        <!-- Sparkline -->
        <script src="{{asset("adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js")}}"></script>
        <!-- jvectormap -->
        <script src="{{asset("adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js")}}"></script>
        <script src="{{asset("adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js")}}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{asset("adminlte/bower_components/jquery-knob/dist/jquery.knob.min.js")}}"></script>
        <!-- daterangepicker -->
        <script src="{{asset("adminlte/bower_components/moment/min/moment.min.js")}}"></script>
        <script src="{{asset("adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js")}}"></script>
        <!-- datepicker -->
        <script src="{{asset("adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")}}"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="{{asset("adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}"></script>
        <!-- Slimscroll -->
        <!-- FastClick -->

        <!-- AdminLTE App -->

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{asset("adminlte/dist/js/pages/dashboard.js")}}"></script>
        <!-- AdminLTE for demo purposes -->

        <!-- Bootstrap 3.3.7 -->
        <script src="{{asset("adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js")}}"></script>
        <!-- FastClick -->
        <script src="{{asset("adminlte/bower_components/fastclick/lib/fastclick.js")}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset("adminlte/dist/js/adminlte.min.js")}}"></script>
        <!-- Sparkline -->
        <!-- jvectormap  -->
        <!-- SlimScroll -->
        <script src="{{asset("adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js")}}"></script>
        <!-- ChartJS -->
        <script src="{{asset("adminlte/bower_components/chart.js/Chart.js")}}"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{asset("adminlte/dist/js/pages/dashboard2.js")}}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{asset("adminlte/dist/js/demo.js")}}"></script>
        <script>
            // layer.open({
            //     type: 2,
            //     title: '用客户咨询你了',
            //     shadeClose: true,
            //     shade: false,
            //     area: ['732px', '90%'],
            //     maxmin: true, //开启最大化最小化按钮
            //     min:true,
            //     content: 'http://www.baidu.com/' //iframe的url
            // });
        </script>
        @endsection
    @endsection
