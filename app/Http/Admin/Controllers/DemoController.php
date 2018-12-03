<?php
/**
 * 后台demo控制器
 */
namespace App\Http\Admin\Controllers;

use App\Http\Admin\Action\Demo\IndexAction;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }
}