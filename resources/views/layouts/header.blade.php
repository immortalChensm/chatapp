<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield("title")</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{asset("adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{asset("adminlte/bower_components/font-awesome/css/font-awesome.min.css")}}">
    <link rel="stylesheet" href="{{asset("adminlte/bower_components/Ionicons/css/ionicons.min.css")}}">
    <link rel="stylesheet" href="{{asset("adminlte/dist/css/AdminLTE.min.css")}}">
    <link rel="stylesheet" href="{{asset("adminlte/dist/css/skins/_all-skins.min.css")}}">


    <link href="{{asset("adminlte/css/switch.css")}}" rel="stylesheet">

    {{--<link href="{{asset("H5/css/bootstrap.css")}}" rel="stylesheet" type="text/css">--}}
    {{--<link href="{{asset("H5/css/jquery-ui.css")}}" rel="stylesheet" type="text/css">--}}
    {{--<link href="{{asset("H5/css/webim_demo.css")}}" rel="stylesheet" type="text/css">--}}
    {{--<link href="{{asset("H5/css/bootstrap-table.css")}}" rel="stylesheet" type="text/css">--}}
    <link href="{{asset("H5/css/im.css")}}" rel="stylesheet" type="text/css">

    @yield("css")

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="../../index2.html" class="logo">

            <span class="logo-mini"><b>传</b>联</span>

            <span class="logo-lg"><b>传联</b>管理系统</span>
        </a>

        <nav class="navbar navbar-static-top">

            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>



            <div class="navbar-custom-menu">


                <ul class="nav navbar-nav">

                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success" id="webimMessage">0</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header" >You have 4 messages</li>

                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li>

                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{asset("adminlte/dist/img/user2-160x160.jpg")}}" class="user-image" alt="User Image">
                            <span class="hidden-xs" onclick="logout();">退出系统</span>
                        </a>

                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>

        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
