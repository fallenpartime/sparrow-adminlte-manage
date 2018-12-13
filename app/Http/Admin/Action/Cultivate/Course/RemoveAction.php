<?php
/**
 * 作废开班
 * Date: 2018/12/10
 * Time: 8:56
 */
namespace App\Http\Admin\Action\Cultivate\Course;

use Admin\Action\BaseAction;
use Admin\Services\Cultivate\Course\Processor\CourseProcessor;
use Common\Models\Cultivate\CultivateCourse;
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
            $this->record = CultivateCourse::find($id);
        }
        if (empty($this->record)) {
            $this->errorJson(500, '开班记录不存在');
        }
        $this->process();
    }

    protected function process()
    {
        $this->getLogTool()->operateLog(52, $this->record->id, '作废开班记录');
        $res = (new CourseProcessor())->destroy($this->record->id);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}