<?php
/**
 * 交易控制器
 * Date: 2018/12/5
 * Time: 17:03
 */
namespace App\Http\Admin\Controllers\Trade;

use App\Http\Admin\Action\Trade\Order\IndexAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * 订单列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }
}