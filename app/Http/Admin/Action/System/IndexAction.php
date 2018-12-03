<?php
/**
 * 系统登录跳转首页
 * Date: 2018/12/3
 * Time: 10:26
 */
namespace App\Http\Admin\Action\System;

use Admin\Action\BaseAction;
use Admin\Config\RouteConfig;

class IndexAction extends BaseAction
{
    public function run()
    {
        return redirect(route(RouteConfig::ROUTE_AUTHORITY_LIST));
    }
}
