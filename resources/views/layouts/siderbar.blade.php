<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        {{--<div class="user-panel">--}}
            {{--<div class="pull-left image">--}}
                {{--<img src="{{asset("adminlte/dist/img/user2-160x160.jpg")}}" class="img-circle" alt="User Image">--}}
            {{--</div>--}}
            {{--<div class="pull-left info">--}}
                {{--<p>Alexander Pierce</p>--}}
                {{--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<!-- search form -->--}}
        {{--<form action="#" method="get" class="sidebar-form">--}}
            {{--<div class="input-group">--}}
                {{--<input type="text" name="q" class="form-control" placeholder="Search...">--}}
                {{--<span class="input-group-btn">--}}
                {{--<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>--}}
                {{--</button>--}}
              {{--</span>--}}
            {{--</div>--}}
        {{--</form>--}}

        <ul class="sidebar-menu" data-widget="tree">

            <li class="header">管理模块</li>
            <li class="treeview @if(preg_match('/admin/',request()->url())) active @endif">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>传联系统</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="@if(preg_match('/admin/',request()->url())) active @endif"><a href="{{url("/admin")}}"><i class="fa fa-circle-o"></i> 系统首页</a></li>
                </ul>
            </li>

            @if(array_key_exists('管理员管理',session("permission")))
            <li class="treeview @if(
            preg_match('/manager/',request()->url())
            ||preg_match('/role/',request()->url())
            ||preg_match('/permission/',request()->url())

            ) active @endif">
                <a href="#">
                    <i class="fa fa-table"></i> <span>管理员管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    @if(in_array("admin/managers",session("permission")['管理员管理']))
                    <li class="@if(preg_match('/manager/',request()->url())) active @endif"><a href="{{url("admin/managers")}}"><i class="fa fa-circle-o"></i> 管理员列表</a></li>
                    @endif
                    @if(in_array("admin/role",session("permission")['管理员管理']))
                    <li class="@if(preg_match('/role/',request()->url())) active @endif"><a href="{{url("admin/role")}}"><i class="fa fa-circle-o"></i> 角色列表</a></li>
                    @endif
                        @if(in_array("admin/role",session("permission")['管理员管理']))
                    <li class="@if(preg_match('/permission/',request()->url())) active @endif"><a href="{{url("admin/permission")}}"><i class="fa fa-circle-o"></i> 权限列表</a></li>
                        @endif
                </ul>
            </li>
            @endif

            @if(array_key_exists('文章管理',session("permission"))||array_key_exists('文章标签管理',session("permission")))
            <li class="treeview @if(preg_match('/articles|tags/',request()->url())) active @endif">
                <a href="#">
                    <i class="fa fa-book"></i> <span>文章管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">

                    @if(in_array("admin/articles",session("permission")['文章管理']))
                    <li @if(preg_match('/articles/',request()->url())) class="active" @endif ><a href="{{url("admin/articles")}}"><i class="fa fa-circle-o"></i> 文章列表</a></li>@endif
                        @if(in_array("admin/article/tags",session("permission")['文章标签管理']))
                    <li @if(preg_match('/article\/tags/',request()->url())) class="active" @endif ><a href="{{url("admin/article/tags")}}"><i class="fa fa-circle-o"></i> 文章标签</a></li>@endif
                </ul>
            </li>
            @endif

            @if(array_key_exists('搜索排行',session("permission")))
                <li class="treeview @if(preg_match('/keywords/',request()->url())) active @endif">
                    <a href="#">
                        <i class="fa fa-book"></i> <span>关键词排行</span>
                        <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">

                        @if(in_array("admin/keywords/ranking",session("permission")['搜索排行']))
                            <li @if(preg_match('/keywords/',request()->url())) class="active" @endif ><a href="{{url("admin/keywords/ranking")}}"><i class="fa fa-circle-o"></i> 排行列表</a></li>@endif
                    </ul>
                </li>
            @endif

            @if(array_key_exists('相册管理',session("permission")))
            <li class="treeview @if(preg_match('/photos/',request()->url())) active @endif">
                <a href="#">
                    <i class="fa fa-file-image-o"></i> <span>相册管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    @if(in_array("admin/photos",session("permission")['相册管理']))
                    <li @if(preg_match('/photos/',request()->url())) class="active" @endif  ><a href="{{url("admin/photos")}}"><i class="fa fa-circle-o"></i> 相册列表</a></li>@endif
                </ul>
            </li>
            @endif

            @if(array_key_exists('广告管理',session("permission")))
                <li class="treeview @if(preg_match('/ads/',request()->url())) active @endif">
                    <a href="#">
                        <i class="fa fa-file-image-o"></i> <span>广告管理</span>
                        <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        @if(in_array("admin/ads",session("permission")['广告管理']))
                            <li @if(preg_match('/ads/',request()->url())) class="active" @endif  ><a href="{{url("admin/ads")}}"><i class="fa fa-circle-o"></i> 广告列表</a></li>@endif
                    </ul>
                </li>
            @endif

            @if(array_key_exists('视频管理',session("permission")))
            <li class="treeview @if(preg_match('/videos/',request()->url())) active @endif">
                <a href="#">
                    <i class="fa fa-file-video-o"></i> <span>视频管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    @if(in_array("admin/videos",session("permission")['视频管理']))
                    <li @if(preg_match('/videos/',request()->url())) class="active" @endif><a href="{{url("admin/videos")}}"><i class="fa fa-circle-o"></i> 视频列表</a></li>@endif
                </ul>
            </li>
            @endif

            @if(array_key_exists('音乐管理',session("permission")))
            <li class="treeview @if(preg_match('/musics/',request()->url())) active @endif">
                <a href="#">
                    <i class="fa fa-music"></i> <span>音乐管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    @if(in_array("admin/musics",session("permission")['音乐管理']))
                    <li @if(preg_match('/musics/',request()->url())) class="active" @endif><a href="{{url("admin/musics")}}"><i class="fa fa-circle-o"></i> 音乐列表</a></li>@endif
                </ul>
            </li>
            @endif

            @if(array_key_exists('群组管理',session("permission")))
            <li class="treeview @if(preg_match('/groups/',request()->url())) active @endif">
                <a href="#">
                    <i class="fa  fa-group (alias)"></i> <span>群组管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    @if(in_array("admin/groups",session("permission")['群组管理']))
                    <li @if(preg_match('/groups/',request()->url())) class="active" @endif ><a href="{{url("admin/groups")}}"><i class="fa fa-circle-o"></i> 群组列表</a></li>@endif
                </ul>
            </li>
            @endif

            @if(array_key_exists('用户管理',session("permission")))
            <li class="treeview @if(preg_match('/users/',request()->url())) active @endif">
                <a href="#">
                    <i class="fa fa-user"></i> <span>用户管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    @if(in_array("admin/users",session("permission")['用户管理']))
                    <li @if(preg_match('/users/',request()->url())) class="active" @endif><a href="{{url("admin/users")}}"><i class="fa fa-circle-o"></i> 用户列表</a></li>@endif
                </ul>
            </li>
            @endif

            @if(array_key_exists('订单管理',session("permission")))
            <li class="treeview @if(preg_match('/business/',request()->url())||preg_match('/ship/',request()->url())
            ||preg_match('/ship/',request()->url())
            ||preg_match('/given/',request()->url())
            ||preg_match('/storage/',request()->url())
            ||preg_match('/recharge/',request()->url())
            ||preg_match('/withdrawal/',request()->url())
            ||preg_match('/transfer/',request()->url())
            ||preg_match('/expenditure/',request()->url())
            ||preg_match('/income/',request()->url())
            ||preg_match('/refund/',request()->url())
            ||preg_match('/upgrade/',request()->url())

            ) active @endif">
                <a href="#">
                    <i class="fa  fa-reorder (alias)"></i> <span>订单管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    @if(in_array("admin/order/business",session("permission")['订单管理']))
                    <li @if(preg_match('/business/',request()->url())) class="active" @endif ><a href="{{url("admin/order/business")}}"><i class="fa fa-circle-o"></i> 用户业务列表</a></li>@endif
                        @if(in_array("admin/order/ship",session("permission")['订单管理']))
                    <li @if(preg_match('/ship/',request()->url())) class="active" @endif ><a href="{{url("admin/order/ship")}}"><i class="fa fa-circle-o"></i> 船票订单列表</a></li>@endif
                            @if(in_array("admin/order/given",session("permission")['订单管理']))
                    <li @if(preg_match('/given/',request()->url())) class="active" @endif ><a href="{{url("admin/order/given")}}"><i class="fa fa-circle-o"></i> 船票赠送列表</a></li>@endif
                                @if(in_array("admin/order/storage",session("permission")['订单管理']))
                    <li @if(preg_match('/storage/',request()->url())) class="active" @endif ><a href="{{url("admin/order/storage")}}"><i class="fa fa-circle-o"></i> 空间订单列表</a></li>@endif
                                    @if(in_array("admin/order/recharge",session("permission")['订单管理']))
                    <li @if(preg_match('/recharge/',request()->url())) class="active" @endif ><a href="{{url("admin/order/recharge")}}"><i class="fa fa-circle-o"></i> 用户充值列表</a></li>@endif
                                        @if(in_array("admin/order/withdrawal",session("permission")['订单管理']))
                    <li @if(preg_match('/withdrawal/',request()->url())) class="active" @endif ><a href="{{url("admin/order/withdrawal")}}"><i class="fa fa-circle-o"></i> 用户提现列表</a></li>@endif
                                            @if(in_array("admin/order/transfer",session("permission")['订单管理']))
                    <li @if(preg_match('/transfer/',request()->url())) class="active" @endif ><a href="{{url("admin/order/transfer")}}"><i class="fa fa-circle-o"></i> 用户转账列表</a></li>@endif
                                                @if(in_array("admin/order/expenditure",session("permission")['订单管理']))
                    <li @if(preg_match('/expenditure/',request()->url())) class="active" @endif ><a href="{{url("admin/order/expenditure")}}"><i class="fa fa-circle-o"></i> 红包支出列表</a></li>@endif
                                                    @if(in_array("admin/order/income",session("permission")['订单管理']))
                    <li @if(preg_match('/income/',request()->url())) class="active" @endif ><a href="{{url("admin/order/income")}}"><i class="fa fa-circle-o"></i> 红包收入列表</a></li>@endif
                                                        @if(in_array("admin/order/refund",session("permission")['订单管理']))
                    <li @if(preg_match('/refund/',request()->url())) class="active" @endif ><a href="{{url("admin/order/refund")}}"><i class="fa fa-circle-o"></i> 红包退还列表</a></li>@endif
                                                            @if(in_array("admin/order/upgrade",session("permission")['订单管理']))
                    <li @if(preg_match('/upgrade/',request()->url())) class="active" @endif ><a href="{{url("admin/order/upgrade")}}"><i class="fa fa-circle-o"></i> 用户升级列表</a></li>@endif
                </ul>
            </li>
            @endif

            @if(array_key_exists('评论管理',session("permission")))
            <li class="treeview  @if(preg_match('/comments/',request()->url())||preg_match('/replies/',request()->url())) active @endif">
                <a href="#">
                    <i class="fa  fa-comments"></i> <span>评论管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    @if(in_array("admin/comments",session("permission")['评论管理']))
                    <li @if(preg_match('/comments/',request()->url())) class="active" @endif><a href="{{url("admin/comments")}}"><i class="fa fa-circle-o"></i> 评论列表</a></li>@endif
                        @if(in_array("admin/replies",session("permission")['评论管理']))
                    <li @if(preg_match('/replies/',request()->url())) class="active" @endif><a href="{{url("admin/replies")}}"><i class="fa fa-circle-o"></i> 回复列表</a></li>@endif
                </ul>
            </li>
            @endif

            @if(array_key_exists('举报管理',session("permission")))
            <li class="treeview  @if(preg_match('/reports/',request()->url())
            ||preg_match('/reasons/',request()->url())
            ||preg_match('/reportUsers/',request()->url())
            ||preg_match('/reportGroups/',request()->url())
            ) active @endif">
                <a href="#">
                    <i class="fa  fa-warning (alias)"></i> <span>举报管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    @if(in_array("admin/reports",session("permission")['举报管理']))
                    <li @if(preg_match('/reports/',request()->url())) class="active" @endif><a href="{{url("admin/reports")}}"><i class="fa fa-circle-o"></i> 举报内容列表</a></li>@endif
                        @if(in_array("admin/reportUsers",session("permission")['举报管理']))
                    <li @if(preg_match('/reportUsers/',request()->url())) class="active" @endif><a href="{{url("admin/reportUsers")}}"><i class="fa fa-circle-o"></i> 举报用户列表</a></li>@endif
                            @if(in_array("admin/reportGroups",session("permission")['举报管理']))
                    <li @if(preg_match('/reportGroups/',request()->url())) class="active" @endif><a href="{{url("admin/reportGroups")}}"><i class="fa fa-circle-o"></i> 举报群组列表</a></li>@endif
                                @if(in_array("admin/report/reasons",session("permission")['举报管理']))
                    <li @if(preg_match('/reasons/',request()->url())) class="active" @endif><a href="{{url("admin/report/reasons")}}"><i class="fa fa-circle-o"></i> 举报原因列表</a></li>@endif
                </ul>
            </li>
            @endif

            @if(array_key_exists('系统设置',session("permission")))
            <li class="treeview @if(preg_match('/system/',request()->url())) active @endif">
                <a href="#">
                    <i class="fa fa-wrench"></i> <span>系统设置</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    @if(in_array("admin/system/index",session("permission")['系统设置']))
                    <li @if(preg_match('/index/',request()->url())) class="active" @endif><a href="{{url("admin/system/index")}}"><i class="fa fa-circle-o"></i> 网站设置</a></li>@endif
                        @if(in_array("admin/system/agreement",session("permission")['系统设置']))
                    <li @if(preg_match('/agreement/',request()->url())) class="active" @endif><a href="{{url("admin/system/agreement")}}"><i class="fa fa-circle-o"></i> 意见收集</a></li>@endif
                        @if(in_array("admin/system/app",session("permission")['系统设置']))
                            <li @if(preg_match('/app/',request()->url())) class="active" @endif><a href="{{url("admin/system/app")}}"><i class="fa fa-circle-o"></i> APP应用配置</a></li>@endif
                </ul>
            </li>
            @endif

        </ul>
    </section>

</aside>