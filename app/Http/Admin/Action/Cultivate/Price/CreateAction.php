<?php
/**
 * 创建专业关联报价
 * Date: 2018/12/10
 * Time: 9:01
 */
namespace App\Http\Admin\Action\Cultivate\Price;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\PriceConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Cultivate\Price\Processor\CoursePriceProcessor;
use Admin\Services\Menu\AdminMenuService;
use Common\Models\Cultivate\CultivateCourse;
use Frameworks\Tool\Http\Config\HttpConfig;
use Frameworks\Traits\ApiActionTrait;

class CreateAction extends BaseAction
{
    use ApiActionTrait;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        if ($httpTool->isAjax()) {
            $this->process();
        }
        return $this->showInfo();
    }

    protected function showInfo()
    {
        $httpTool = $this->getHttpTool();
        $courseNo = $httpTool->getBothSafeParam('course_no');
        $courseList = CultivateCourse::select(['no', 'name'])->get();
        $result = [
            'menu'  =>  $this->initViewMenu(),
            'course_no'     => $courseNo,
            'courseList'    => $courseList,
            'typeList'      => PriceConfig::getTypeList(),
            'actionUrl'         => route(RouteConfig::ROUTE_COURSE_PRICE_CREATE),
            'redirectUrl'       => route(RouteConfig::ROUTE_COURSE_PRICE_LIST),
        ];
        return $this->createView(ViewConfig::COURSE_PRICE_CREATE, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_CULTIVATE_COURSE_PRICE, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_COURSE_PRICE_LIST,  'url'=>1, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_COURSE_PRICE_CREATE, 'url'=>0, 'active'=>1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $type = $httpTool->getBothSafeParam('type', HttpConfig::PARAM_NUMBER_TYPE);
        $courseNo = $httpTool->getBothSafeParam('course_no');
        $train = $httpTool->getBothSafeParam('train');
        $identify = $httpTool->getBothSafeParam('identify');
        $discount = $httpTool->getBothSafeParam('discount');
        $money = $httpTool->getBothSafeParam('money');
        if (empty($discount)) {
            $discount = 10;
        }
        if(empty($type)){
            $this->errorJson(500, '报价类型不能为空');
        }
        if(empty($money)){
            $this->errorJson(500, '总计不能为空');
        }
        if(empty($courseNo)){
            $this->errorJson(500, '开班不能为空');
        }
        $course = CultivateCourse::where('no', $courseNo)->first();
        if (empty($course)) {
            $this->errorJson(500, '开班记录不存在');
        }
        $data = [
            'type'          =>  $type,
            'course_no'     =>  $courseNo,
            'train'         =>  !empty($train)? $train: 0,
            'identify'      =>  !empty($identify)? $identify: 0,
            'discount'      =>  $discount,
            'money'         =>  !empty($money)? $money: 0,
            'real_money'    =>  $money * ($discount / 10),
        ];
        $res = $this->save($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function save($data)
    {
        $processor = new CoursePriceProcessor();
        list($status, $model) = $processor->insert($data);
        if (empty($status)) {
            $this->errorJson(500, '开班报价创建失败');
        }
        $model->no = $model->course_no.$model->type.date('YmdHis');
        $model->save();
        $this->getLogTool()->operateLog(70, $model->id, '添加开班报价');
        $this->successJson();
    }
}