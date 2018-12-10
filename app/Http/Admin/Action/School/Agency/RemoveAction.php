<?php
/**
 * 作废机构
 * Date: 2018/12/9
 * Time: 19:30
 */

namespace App\Http\Admin\Action\School\Agency;

use Admin\Action\BaseAction;
use Admin\Services\School\Agency\Processor\AgencyProcessor;
use Common\Models\Cultivate\CultivateAgency;
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
            $this->record = CultivateAgency::find($id);
        }
        if (empty($this->record)) {
            $this->errorJson(500, '机构不存在');
        }
        $this->process();
    }

    protected function process()
    {
        $this->getLogTool()->operateLog(3, $this->record->id, '作废机构');
        $res = (new AgencyProcessor())->destroy($this->record->id);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}