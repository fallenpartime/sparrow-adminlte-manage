<?php
/**
 * 等级控制器
 * Date: 2018/12/5
 * Time: 12:30
 */
namespace App\Http\Admin\Controllers\Cultivate;

use App\Http\Admin\Action\Cultivate\Level\CreateAction;
use App\Http\Admin\Action\Cultivate\Level\EditAction;
use App\Http\Admin\Action\Cultivate\Level\IndexAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * 等级列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 创建等级
     * @param Request $request
     */
    public function create(Request $request)
    {
        return (new CreateAction($request))->run();
    }

    /**
     * 编辑等级
     * @param Request $request
     */
    public function edit(Request $request)
    {
        return (new EditAction($request))->run();
    }
}