<?php
/**
 * 作废专业课程
 * Date: 2018/12/11
 * Time: 23:26
 */
namespace App\Http\Admin\Action\Cultivate\Major\Course;

use Admin\Action\BaseAction;
use Admin\Services\Cultivate\Major\Processor\MajorCourseProcessor;
use Common\Models\Cultivate\CultivateMajorCourse;
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
            $this->record = CultivateMajorCourse::find($id);
        }
        if (empty($this->record)) {
            $this->errorJson(500, '专业课程不存在');
        }
        $this->process();
    }

    protected function process()
    {
        $this->getLogTool()->operateLog(42, $this->record->id, '作废专业课程');
        $res = (new MajorCourseProcessor())->destroy($this->record->id);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}