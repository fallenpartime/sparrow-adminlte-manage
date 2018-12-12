<?php
/**
 * 作废专业
 * Date: 2018/12/10
 * Time: 8:59
 */
namespace App\Http\Admin\Action\Cultivate\Major;

use Admin\Action\BaseAction;
use Admin\Services\Cultivate\Major\Processor\MajorProcessor;
use Common\Models\Cultivate\CultivateMajor;
use Frameworks\Tool\Http\Config\HttpConfig;
use Frameworks\Traits\ApiActionTrait;

class RemoveAction extends BaseAction
{
    use ApiActionTrait;

    protected $record = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->record = CultivateMajor::find($id);
        }
        if (empty($this->record)) {
            $this->errorJson(500, '专业不存在');
        }
        $this->process();
    }

    protected function process()
    {
        $this->getLogTool()->operateLog(32, $this->record->id, '作废专业');
        $res = (new MajorProcessor())->destroy($this->record->id);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}