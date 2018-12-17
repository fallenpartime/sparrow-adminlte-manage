<?php
/**
 * 激活报价
 * Date: 2018/12/10
 * Time: 9:03
 */
namespace App\Http\Admin\Action\Cultivate\Price;

use Admin\Action\BaseAction;
use Common\Models\Cultivate\CultivateCoursePrice;
use Frameworks\Tool\Http\Config\HttpConfig;
use Frameworks\Traits\ApiActionTrait;

class ActiveAction extends BaseAction
{
    use ApiActionTrait;

    protected $record = null;
    protected $course = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->record = CultivateCoursePrice::find($id);
        }
        if (empty($this->record)) {
            $this->errorJson(500, '开班报价记录不存在');
        }
        if (!empty($this->record->active_status)) {
            $this->errorJson(500, '开班报价已激活');
        }
        $this->course = $this->record->course;
        if (empty($this->course)) {
            $this->errorJson(500, '开班记录不存在');
        }
        $this->process();
    }

    protected function process()
    {
        CultivateCoursePrice::where('type', 1)->where('course_no', $this->course->noW)->whereNotIn('id', [$this->record->id])->update(['active_status'=>0]);
        $this->record->active_status = 1;
        if ($this->record->save()) {
            $this->course->price_no = $this->record->no;
            $this->course->price = $this->record->money;
            $this->course->pay_price = $this->record->real_money;
            $this->course->save();
            $this->getLogTool()->operateLog(71, $this->record->id, '激活开课报价');
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}