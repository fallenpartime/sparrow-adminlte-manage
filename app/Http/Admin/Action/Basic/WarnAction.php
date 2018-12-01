<?php
/**
 * 警示
 * Date: 2018/12/1
 * Time: 17:40
 */
namespace App\Http\Admin\Action\Basic;

use Admin\Action\BaseAction;

class WarnAction extends BaseAction
{
    public function run()
    {
        return view('admin.basic.warn', ['message'=>'权限不足']);
    }
}