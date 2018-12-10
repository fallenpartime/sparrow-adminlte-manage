<?php
/**
 * 作废机构教师
 * Date: 2018/12/10
 * Time: 8:46
 */
namespace App\Http\Admin\Action\School\Teacher;

use Admin\Action\BaseAction;
use Admin\Services\School\Teacher\Processor\TeacherProcessor;
use Common\Models\Cultivate\CultivateTeacher;
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
            $this->record = CultivateTeacher::find($id);
        }
        if (empty($this->record)) {
            $this->errorJson(500, '教师不存在');
        }
        $this->process();
    }

    protected function process()
    {
        $this->getLogTool()->operateLog(12, $this->record->id, '作废教师');
        $res = (new TeacherProcessor())->destroy($this->record->id);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}