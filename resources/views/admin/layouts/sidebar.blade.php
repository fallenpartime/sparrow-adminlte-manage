<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">系统菜单</li>
            @if(!empty($admin_info['is_manager'] || in_array(\Admin\Config\AdminMenuConfig::MENU_MANAGE_CENTER, $ts_list)))
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>权限中心</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if(!empty($admin_info['is_manager'] || in_array(\Admin\Config\AdminMenuConfig::MENU_MANAGE_OWNER, $ts_list)))
                    <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> 管理员管理
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(!empty($admin_info['is_manager'] || in_array(\Admin\Config\RouteConfig::ROUTE_OWNER_LIST, $ts_list)))
                            <li><a href="{{ route(\Admin\Config\RouteConfig::ROUTE_OWNER_LIST) }}"><i class="fa fa-circle-o"></i> 管理员列表</a></li>
                            @endif
                            @if(!empty($admin_info['is_manager'] || in_array(\Admin\Config\RouteConfig::ROUTE_OWNER_CREATE, $ts_list)))
                            <li><a href="{{ route(\Admin\Config\RouteConfig::ROUTE_OWNER_CREATE) }}"><i class="fa fa-circle-o"></i> 创建管理员</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if(!empty($admin_info['is_manager'] || in_array(\Admin\Config\AdminMenuConfig::MENU_MANAGE_GROUP, $ts_list)))
                    <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> 分组管理
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(!empty($admin_info['is_manager'] || in_array(\Admin\Config\RouteConfig::ROUTE_GROUP_LIST, $ts_list)))
                            <li><a href="{{ route(\Admin\Config\RouteConfig::ROUTE_GROUP_LIST) }}"><i class="fa fa-circle-o"></i> 分组列表</a></li>
                            @endif
                            @if(!empty($admin_info['is_manager'] || in_array(\Admin\Config\RouteConfig::ROUTE_GROUP_CREATE, $ts_list)))
                            <li><a href="{{ route(\Admin\Config\RouteConfig::ROUTE_GROUP_CREATE) }}"><i class="fa fa-circle-o"></i> 创建分组</a></li>
                                @endif
                        </ul>
                    </li>
                    @endif
                    @if(!empty($admin_info['is_manager'] || in_array(\Admin\Config\AdminMenuConfig::MENU_MANAGE_ROLE, $ts_list)))
                    <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> 角色管理
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(!empty($admin_info['is_manager'] || in_array(\Admin\Config\RouteConfig::ROUTE_ROLE_LIST, $ts_list)))
                            <li><a href="{{ route(\Admin\Config\RouteConfig::ROUTE_ROLE_LIST) }}"><i class="fa fa-circle-o"></i> 角色列表</a></li>
                            @endif
                            @if(!empty($admin_info['is_manager'] || in_array(\Admin\Config\RouteConfig::ROUTE_ROLE_CREATE, $ts_list)))
                            <li><a href="{{ route(\Admin\Config\RouteConfig::ROUTE_ROLE_CREATE) }}"><i class="fa fa-circle-o"></i> 创建角色</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if(!empty($admin_info['is_manager'] || in_array(\Admin\Config\AdminMenuConfig::MENU_MANAGE_AUTHORITY, $ts_list)))
                    <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> 权限管理
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(!empty($admin_info['is_manager'] || in_array(\Admin\Config\RouteConfig::ROUTE_AUTHORITY_LIST, $ts_list)))
                            <li><a href="{{ route(\Admin\Config\RouteConfig::ROUTE_AUTHORITY_LIST) }}"><i class="fa fa-circle-o"></i> 权限列表</a></li>
                            @endif
                            @if(!empty($admin_info['is_manager'] || in_array(\Admin\Config\RouteConfig::ROUTE_AUTHORITY_CREATE, $ts_list)))
                            <li><a href="{{ route(\Admin\Config\RouteConfig::ROUTE_AUTHORITY_CREATE) }}"><i class="fa fa-circle-o"></i> 创建权限</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if(!empty($admin_info['is_manager'] || in_array(\Admin\Config\AdminMenuConfig::MENU_MANAGE_LOG, $ts_list)))
                    <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> 日志管理
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(!empty($admin_info['is_manager'] || in_array(\Admin\Config\RouteConfig::ROUTE_OPERATE_LOG_LIST, $ts_list)))
                                <li><a href="{{ route(\Admin\Config\RouteConfig::ROUTE_OPERATE_LOG_LIST) }}"><i class="fa fa-circle-o"></i> 业务日志</a></li>
                            @endif
                            @if(!empty($admin_info['is_manager'] || in_array(\Admin\Config\RouteConfig::ROUTE_ADMIN_LOG_LIST, $ts_list)))
                            <li><a href="{{ route(\Admin\Config\RouteConfig::ROUTE_ADMIN_LOG_LIST) }}"><i class="fa fa-circle-o"></i> 系统日志</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>