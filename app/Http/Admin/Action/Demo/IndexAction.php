<?php
/**
 * demo展示
 * Date: 2018/12/1
 * Time: 22:59
 */
namespace App\Http\Admin\Action\Demo;

use Admin\Action\BaseAction;

class IndexAction extends BaseAction
{
    public function run()
    {
        return view('admin.demo.index');
    }
}