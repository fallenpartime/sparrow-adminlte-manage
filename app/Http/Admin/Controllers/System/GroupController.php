<?php
/**
 * 管理员分组控制器
 */
namespace App\Http\Admin\Controllers\System;

use App\Http\Admin\Action\System\Group\CreateAction;
use App\Http\Admin\Action\System\Group\EditAction;
use App\Http\Admin\Action\System\Group\IndexAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * 分组列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 分组创建
     * @param Request $request
     */
    public function create(Request $request)
    {
        return (new CreateAction($request))->run();
    }

    /**
     * 分组编辑
     * @param Request $request
     */
    public function edit(Request $request)
    {
        return (new EditAction($request))->run();
    }
}
