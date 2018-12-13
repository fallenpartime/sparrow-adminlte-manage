<?php
/**
 * 报价控制器
 * Date: 2018/12/10
 * Time: 9:04
 */
namespace App\Http\Admin\Controllers\Cultivate;

use App\Http\Admin\Action\Cultivate\Price\CreateAction;
use App\Http\Admin\Action\Cultivate\Price\IndexAction;
use App\Http\Admin\Action\Cultivate\Price\ActiveAction;

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
     * 激活报价
     * @param Request $request
     */
    public function remove(Request $request)
    {
        return (new ActiveAction($request))->run();
    }
}