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

    @endsection

@section("content")

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                主页面板
                <small>Version 2.0</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> 主页</a></li>
                <li class="active">主页面板</li>
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
                            <span class="info-box-text">空间销售额</span>
                            <span class="info-box-number">用户消费{{$data['spaceSale']}}张船票</span>
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
                            <span class="info-box-number">{{$data['articleNum']}}条</span>
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
                            <span class="info-box-number">收入{{$data['shipSale']}}元</span>
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
                            <span class="info-box-number">{{$data['userNum']}}人</span>
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
                <div class="col-md-12">
                    <!-- MAP & BOX PANE -->
                    <!-- /.box -->
                    <div class="row">


                        <div class="col-md-12">
                            <!-- USERS LIST -->
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">最近的注册会员</h3>

                                    <div class="box-tools pull-right">
                                        <span class="label label-danger">{{count($data['users'])}}</span>
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <ul class="users-list clearfix">
                                        @foreach($data['users'] as $user)
                                        <li>
                                            <img src="{{$user->headImgUrl['data']}}" alt="User Image">
                                            <a class="users-list-name" href="#">{{$user->name}}</a>
                                            <span class="users-list-date">{{$user->created_at}}</span>
                                        </li>
                                        @endforeach

                                    </ul>
                                    <!-- /.users-list -->
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer text-center">
                                    <a href="/admin/users" class="uppercase">查看所有用户</a>
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
                                        <th>船票订单 ID</th>
                                        <th>卖方</th>
                                        <th>买方</th>
                                        <th>交易状态</th>
                                        <th>交易船票张数</th>
                                        <th>交易金额</th>
                                        <th>交易时间</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($data['shipOrder'])&&count($data['shipOrder'])>0)
                                    @foreach($data['shipOrder'] as $order)
                                    <tr>
                                        <td><a href="">{{$order->id}}</a></td>
                                        <td>
                                            @if($order->sellerUserId==1)
                                                平台
                                                @else
                                                {{$order->sellerUser}}
                                                @endif
                                        </td>
                                        <td> @if(empty($order->userInfo))
                                                暂无
                                            @else
                                               {{$order->userInfo}}
                                            @endif</td>
                                        <td><span class="label label-success">
                                                @if(empty($order->userInfo))
                                                    未售出去
                                                    @else
                                                    已销售
                                                    @endif
                                            </span></td>
                                        <td>
                                            <div class="sparkbar" data-color="#00a65a" data-height="20">{{$order->shipNum}}</div>
                                        </td>
                                        <td>{{$order->payMoney}}</td>
                                        <td>{{$order->created_at}}</td>
                                    </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="6" align="center">暂无数据</td>
                                        </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            {{--<a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>--}}
                            <a href="/admin/order/ship" class="btn btn-sm btn-default btn-flat pull-right" >查看所有</a>
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

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{asset("adminlte/dist/js/pages/dashboard.js")}}"></script>
        <!-- AdminLTE for demo purposes -->

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{asset("adminlte/dist/js/pages/dashboard2.js")}}"></script>

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
