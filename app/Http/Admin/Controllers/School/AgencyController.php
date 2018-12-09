<?php
/**
 * 机构控制器
 * Date: 2018/12/5
 * Time: 14:14
 */
namespace App\Http\Admin\Controllers\School;

use App\Http\Admin\Action\School\Agency\CreateAction;
use App\Http\Admin\Action\School\Agency\EditAction;
use App\Http\Admin\Action\School\Agency\IndexAction;
use App\Http\Admin\Action\School\Agency\RemoveAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    /**
     * 机构列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 创建机构
     * @param Request $request
     */
    public function create(Request $request)
    {
        return (new CreateAction($request))->run();
    }

    /**
     * 编辑机构
     * @param Request $request
     */
    public function edit(Request $request)
    {
        return (new EditAction($request))->run();
    }

    /**
     * 作废机构
     * @param Request $request
     */
    public function remove(Request $request)
    {
        return (new RemoveAction($request))->run();
    }
}