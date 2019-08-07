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
                <li><a href="#"><i class="fa fa-dashboard"></i> 主页</a></li>
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
                            <span class="info-box-text">CPU Traffic</span>
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
                            <span class="info-box-text">Likes</span>
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
                            <span class="info-box-text">Sales</span>
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
                            <span class="info-box-text">New Members</span>
                            <span class="info-box-number">2,000</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>


           
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
        @endsection
    @endsection
