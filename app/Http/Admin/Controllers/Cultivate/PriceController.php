<?php
/**
 * 报价控制器
 * Date: 2018/12/10
 * Time: 9:04
 */
namespace App\Http\Admin\Controllers\Cultivate;

use App\Http\Admin\Action\Cultivate\Price\CreateAction;
use App\Http\Admin\Action\Cultivate\Price\EditAction;
use App\Http\Admin\Action\Cultivate\Price\IndexAction;
use App\Http\Admin\Action\Cultivate\Price\RemoveAction;

use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     * 报价列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 创建报价
     * @param Request $request
     */
    public function create(Request $request)
    {
        return (new CreateAction($request))->run();
    }

    /**
     * 编辑报价
     * @param Request $request
     */
    public function edit(Request $request)
    {
        return (new EditAction($request))->run();
    }

    /**
     * 作废报价
     * @param Request $request
     */
    public function remove(Request $request)
    {
        return (new RemoveAction($request))->run();
    }
}