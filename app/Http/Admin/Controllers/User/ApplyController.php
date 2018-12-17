<?php
/**
 * 用户申请列表
 * Date: 2018/12/16
 * Time: 22:06
 */
namespace App\Http\Admin\Controllers\User;

use App\Http\Admin\Action\User\apply\IndexAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class ApplyController extends Controller
{
    /**
     * 用户申请列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }
}