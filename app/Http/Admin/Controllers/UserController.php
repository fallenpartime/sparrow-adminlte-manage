<?php
/**
 * 用户管理
 * Date: 2018/12/9
 * Time: 17:37
 */
namespace App\Http\Admin\Controllers;

use App\Http\Admin\Action\User\IndexAction;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 用户列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }
}