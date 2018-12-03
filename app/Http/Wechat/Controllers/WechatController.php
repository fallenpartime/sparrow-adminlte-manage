<?php
/**
 * 微信服务控制器
 * Date: 2018/12/3
 * Time: 12:16
 */
namespace App\Http\Wechat\Controllers;

use App\Http\Wechat\Action\Wechat\ServiceAction;
use Illuminate\Http\Request;

class WechatController extends Controller
{
    public function service(Request $request)
    {
        return (new ServiceAction($request))->run();
    }
}