<?php
/**
 * 开班教师控制器
 * Date: 2018/12/11
 * Time: 23:57
 */
namespace App\Http\Admin\Controllers\Cultivate;

use App\Http\Admin\Action\Cultivate\Course\Teacher\CreateAction;
use App\Http\Admin\Action\Cultivate\Course\Teacher\EditAction;
use App\Http\Admin\Action\Cultivate\Course\Teacher\IndexAction;
use App\Http\Admin\Action\Cultivate\Course\Teacher\RemoveAction;

use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class CourseTeacherController extends Controller
{
    /**
     * 开班教师列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 创建开班教师
     * @param Request $request
     */
    public function create(Request $request)
    {
        return (new CreateAction($request))->run();
    }

    /**
     * 编辑开班教师
     * @param Request $request
     */
    public function edit(Request $request)
    {
        return (new EditAction($request))->run();
    }

    /**
     * 作废开班教师
     * @param Request $request
     */
    public function remove(Request $request)
    {
        return (new RemoveAction($request))->run();
    }
}