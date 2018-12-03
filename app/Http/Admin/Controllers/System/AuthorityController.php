<?php
/**
 * 后台权限控制器
 */
namespace App\Http\Admin\Controllers\System;

use App\Http\Admin\Action\System\Authority\CreateAction;
use App\Http\Admin\Action\System\Authority\EditAction;
use App\Http\Admin\Action\System\Authority\IndexAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class AuthorityController extends Controller
{
    /**
     * 权限列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 权限创建
     * @param Request $request
     */
    public function create(Request $request)
    {
        return (new CreateAction($request))->run();
    }

    /**
     * 权限编辑
     * @param Request $request
     */
    public function edit(Request $request)
    {
        return (new EditAction($request))->run();
    }
}
