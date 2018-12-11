<?php
/**
 * 专业课程
 * Date: 2018/12/11
 * Time: 23:51
 */
namespace App\Http\Admin\Controllers\Cultivate;

use App\Http\Admin\Action\Cultivate\Major\Course\CreateAction;
use App\Http\Admin\Action\Cultivate\Major\Course\EditAction;
use App\Http\Admin\Action\Cultivate\Major\Course\IndexAction;
use App\Http\Admin\Action\Cultivate\Major\Course\RemoveAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class MajorCourseController extends Controller
{
    /**
     * 专业课程列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 创建专业课程
     * @param Request $request
     */
    public function create(Request $request)
    {
        return (new CreateAction($request))->run();
    }

    /**
     * 编辑专业课程
     * @param Request $request
     */
    public function edit(Request $request)
    {
        return (new EditAction($request))->run();
    }

    /**
     * 作废专业课程
     * @param Request $request
     */
    public function remove(Request $request)
    {
        return (new RemoveAction($request))->run();
    }
}