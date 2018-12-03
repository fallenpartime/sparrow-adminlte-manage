<?php
/**
 * 管理员角色控制器
 */
namespace App\Http\Admin\Controllers\System;

use App\Http\Admin\Action\System\Role\CreateAction;
use App\Http\Admin\Action\System\Role\EditAction;
use App\Http\Admin\Action\System\Role\IndexAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * 角色列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 角色创建
     * @param Request $request
     */
    public function create(Request $request)
    {
        return (new CreateAction($request))->run();
    }

    /**
     * 角色编辑
     * @param Request $request
     */
    public function edit(Request $request)
    {
        return (new EditAction($request))->run();
    }
}
