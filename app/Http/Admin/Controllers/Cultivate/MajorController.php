<?php
/**
 * 专业控制器
 * Date: 2018/12/5
 * Time: 12:30
 */
namespace App\Http\Admin\Controllers\Cultivate;

use App\Http\Admin\Action\Cultivate\Major\CreateAction;
use App\Http\Admin\Action\Cultivate\Major\EditAction;
use App\Http\Admin\Action\Cultivate\Major\IndexAction;
use App\Http\Admin\Action\Cultivate\Major\RemoveAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    /**
     * 专业列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 创建专业
     * @param Request $request
     */
    public function create(Request $request)
    {
        return (new CreateAction($request))->run();
    }

    /**
     * 编辑专业
     * @param Request $request
     */
    public function edit(Request $request)
    {
        return (new EditAction($request))->run();
    }

    /**
     * 作废专业
     * @param Request $request
     */
    public function remove(Request $request)
    {
        return (new RemoveAction($request))->run();
    }
}