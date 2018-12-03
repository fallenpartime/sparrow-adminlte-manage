<?php
/**
 * 系统控制器
 * Date: 2018/12/3
 * Time: 10:28
 */

namespace App\Http\Admin\Controllers;

use App\Http\Admin\Action\System\IndexAction;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    /**
     * 系统登录跳转首页
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }
}