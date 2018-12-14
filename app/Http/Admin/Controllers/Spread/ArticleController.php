<?php
/**
 * 文章管理
 * Date: 2018/12/9
 * Time: 17:40
 */
namespace App\Http\Admin\Controllers\Spread;

use App\Http\Admin\Action\Spread\Article\CreateAction;
use App\Http\Admin\Action\Spread\Article\EditAction;
use App\Http\Admin\Action\Spread\Article\IndexAction;
use App\Http\Admin\Action\Spread\Article\PublishAction;
use App\Http\Admin\Action\Spread\Article\RemoveAction;
use App\Http\Admin\Action\Spread\Article\ShowAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * 文章管理
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 创建文章
     * @param Request $request
     */
    public function create(Request $request)
    {
        return (new CreateAction($request))->run();
    }

    /**
     * 编辑文章
     * @param Request $request
     */
    public function edit(Request $request)
    {
        return (new EditAction($request))->run();
    }

    /**
     * 作废文章
     * @param Request $request
     */
    public function remove(Request $request)
    {
        return (new RemoveAction($request))->run();
    }

    /**
     * 文章显示状态修改
     * @param Request $request
     */
    public function show(Request $request)
    {
        return (new ShowAction($request))->run();
    }

    /**
     * 文章发布
     * @param Request $request
     */
    public function publish(Request $request)
    {
        return (new PublishAction($request))->run();
    }
}