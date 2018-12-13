<?php
/**
 * 作废开班关联教师
 * Date: 2018/12/10
 * Time: 9:30
 */
namespace App\Http\Admin\Action\Cultivate\Course\Teacher;

use Admin\Action\BaseAction;
use Admin\Services\Cultivate\Course\Processor\CourseTeacherProcessor;
use Common\Models\Cultivate\CultivateCourseTeacher;
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
            $this->record = CultivateCourseTeacher::find($id);
        }
        if (empty($this->record)) {
            $this->errorJson(500, '开班教师记录不存在');
        }
        $this->process();
    }

    protected function process()
    {
        $this->getLogTool()->operateLog(62, $this->record->id, '作废开班教师记录');
        $res = (new CourseTeacherProcessor())->destroy($this->record->id);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}