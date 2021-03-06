<?php
/**
 * 开课控制器
 * Date: 2018/12/5
 * Time: 12:30
 */
namespace App\Http\Admin\Controllers\Cultivate;

use App\Http\Admin\Action\Cultivate\Course\CreateAction;
use App\Http\Admin\Action\Cultivate\Course\EditAction;
use App\Http\Admin\Action\Cultivate\Course\IndexAction;
use App\Http\Admin\Action\Cultivate\Course\RemoveAction;

use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * 开课列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 创建开课
     * @param Request $request
     */
    public function create(Request $request)
    {
        return (new CreateAction($request))->run();
    }

    /**
     * 编辑开课
     * @param Request $request
     */
    public function edit(Request $request)
    {
        return (new EditAction($request))->run();
    }

    /**
     * 作废开课
     * @param Request $request
     */
    public function remove(Request $request)
    {
        return (new RemoveAction($request))->run();
    }
}