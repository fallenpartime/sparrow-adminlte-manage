<?php
/**
 * 管理员控制器
 */
namespace App\Http\Admin\Controllers\System;

use App\Http\Admin\Action\System\Owner\AuthorityAction;
use App\Http\Admin\Action\System\Owner\CreateAction;
use App\Http\Admin\Action\System\Owner\EditAction;
use App\Http\Admin\Action\System\Owner\IndexAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * 管理员列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 管理员创建
     * @param Request $request
     */
    public function create(Request $request)
    {
        return (new CreateAction($request))->run();
    }

    /**
     * 管理员编辑
     * @param Request $request
     */
    public function edit(Request $request)
    {
        return (new EditAction($request))->run();
    }

    /**
     * 管理员权限
     * @param Request $request
     */
    public function authority(Request $request)
    {
        return (new AuthorityAction($request))->run();
    }
}
