<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset("adminlte/dist/img/user2-160x160.jpg")}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <li class="header">管理模块</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>传联系统</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url("/admin")}}"><i class="fa fa-circle-o"></i> 系统首页</a></li>
                </ul>
            </li>

            <li class="treeview @if(preg_match('/manager/',request()->url())) active @endif">
                <a href="#">
                    <i class="fa fa-table"></i> <span>管理员管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li class="@if(preg_match('/manager/',request()->url())) active @endif"><a href="{{url("admin/managers")}}"><i class="fa fa-circle-o"></i> 管理员列表</a></li>
                    <li ><a href="{{url("admin/managers")}}"><i class="fa fa-circle-o"></i> 角色列表</a></li>
                    <li ><a href="{{url("admin/managers")}}"><i class="fa fa-circle-o"></i> 权限列表</a></li>
                </ul>
            </li>


            <li class="treeview @if(preg_match('/articles|tags/',request()->url())) active @endif">
                <a href="#">
                    <i class="fa fa-book"></i> <span>文章管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li @if(preg_match('/articles/',request()->url())) class="active" @endif ><a href="{{url("admin/articles")}}"><i class="fa fa-circle-o"></i> 文章列表</a></li>
                    <li @if(preg_match('/article\/tags/',request()->url())) class="active" @endif ><a href="{{url("admin/article/tags")}}"><i class="fa fa-circle-o"></i> 文章标签</a></li>
                </ul>
            </li>

            <li class="treeview @if(preg_match('/photos/',request()->url())) active @endif">
                <a href="#">
                    <i class="fa fa-file-image-o"></i> <span>相册管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li @if(preg_match('/photos/',request()->url())) class="active" @endif  ><a href="{{url("admin/photos")}}"><i class="fa fa-circle-o"></i> 相册列表</a></li>
                </ul>
            </li>

            <li class="treeview @if(preg_match('/videos/',request()->url())) active @endif">
                <a href="#">
                    <i class="fa fa-file-video-o"></i> <span>视频管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li @if(preg_match('/videos/',request()->url())) class="active" @endif><a href="{{url("admin/videos")}}"><i class="fa fa-circle-o"></i> 视频列表</a></li>
                </ul>
            </li>

            <li class="treeview @if(preg_match('/musics/',request()->url())) active @endif">
                <a href="#">
                    <i class="fa fa-music"></i> <span>音乐管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li @if(preg_match('/musics/',request()->url())) class="active" @endif><a href="{{url("admin/musics")}}"><i class="fa fa-circle-o"></i> 音乐列表</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa  fa-group (alias)"></i> <span>群组管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li ><a href="{{url("admin/managers")}}"><i class="fa fa-circle-o"></i> 群组列表</a></li>
                </ul>
            </li>

            <li class="treeview @if(preg_match('/users/',request()->url())) active @endif">
                <a href="#">
                    <i class="fa fa-user"></i> <span>用户管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li @if(preg_match('/users/',request()->url())) class="active" @endif><a href="{{url("admin/users")}}"><i class="fa fa-circle-o"></i> 用户列表</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa  fa-reorder (alias)"></i> <span>订单管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li ><a href="{{url("admin/managers")}}"><i class="fa fa-circle-o"></i> 订单列表</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa  fa-comments"></i> <span>评论管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li ><a href="{{url("admin/managers")}}"><i class="fa fa-circle-o"></i> 评论列表</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa  fa-warning (alias)"></i> <span>举报管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li ><a href="{{url("admin/managers")}}"><i class="fa fa-circle-o"></i> 举报列表</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-commenting"></i> <span>客服管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li ><a href="{{url("admin/managers")}}"><i class="fa fa-circle-o"></i> 客服设置</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-trademark"></i> <span>广告管理</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li ><a href="{{url("admin/managers")}}"><i class="fa fa-circle-o"></i> 广告列表</a></li>
                </ul>
            </li>

            <li class="treeview @if(preg_match('/system/',request()->url())) active @endif">
                <a href="#">
                    <i class="fa fa-wrench"></i> <span>系统设置</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li @if(preg_match('/index/',request()->url())) class="active" @endif><a href="{{url("admin/system/index")}}"><i class="fa fa-circle-o"></i> 网站设置</a></li>
                    <li @if(preg_match('/about/',request()->url())) class="active" @endif><a href="{{url("admin/about")}}"><i class="fa fa-circle-o"></i> 关于我们</a></li>
                    <li @if(preg_match('/top/',request()->url())) class="active" @endif><a href="{{url("admin/system/top")}}"><i class="fa fa-circle-o"></i> 置顶记录</a></li>
                </ul>
            </li>


        </ul>
    </section>

</aside>