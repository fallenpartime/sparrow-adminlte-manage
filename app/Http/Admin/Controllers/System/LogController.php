<?php
/**
 * 日志控制器
 * Date: 2018/12/3
 * Time: 15:08
 */
namespace App\Http\Admin\Controllers\System;

use App\Http\Admin\Action\System\Log\IndexOperateAction;
use App\Http\Admin\Action\System\Log\IndexSystemAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * 系统日志
     * @param Request $request
     */
    public function systemLog(Request $request)
    {
        return (new IndexSystemAction($request))->run();
    }

    /**
     * 业务操作日志
     * @param Request $request
     */
    public function operateLog(Request $request)
    {
        return (new IndexOperateAction($request))->run();
    }
}