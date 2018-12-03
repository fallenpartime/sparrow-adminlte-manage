<?php

namespace App\Http\Admin\Controllers;

use App\Http\Admin\Action\Basic\CheckAction;
use App\Http\Admin\Action\Basic\LoginAction;
use App\Http\Admin\Action\Basic\WarnAction;
use Illuminate\Http\Request;

class BasicController extends Controller
{
    /**
     * 权限警示
     * @param Request $request
     * @return mixed
     */
    public function warn(Request $request) {
        return (new WarnAction($request))->run();
    }

    /**
     * 登录
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        return (new LoginAction($request))->run();
    }

    /**
     * 登录验证
     * @param Request $request
     * @return mixed
     */
    public function check(Request $request)
    {
        return (new CheckAction($request))->run();
    }
}
