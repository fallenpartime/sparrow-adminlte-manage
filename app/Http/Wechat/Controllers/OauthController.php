<?php
/**
 * 微信认证控制器
 * Date: 2018/12/3
 * Time: 12:20
 */
namespace App\Http\Wechat\Controllers;

use App\Http\Wechat\Action\Oauth\AdminAction;
use Illuminate\Http\Request;

class OauthController extends Controller
{
    /**
     * 微信后台认证
     * @param Request $request
     */
    public function admin(Request $request)
    {
        return (new AdminAction($request))->run();
    }
}