<?php
/**
 * 专业关联报价列表
 * Date: 2018/12/10
 * Time: 9:02
 */
namespace App\Http\Admin\Action\Cultivate\Price;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Common\Config\PriceConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Menu\AdminMenuService;
use Admin\Services\Sql\Cultivate\Price\PriceSqlProcessor;
use Admin\Tool\CommonTool;
use Common\Models\Cultivate\CultivateCourse;
use Common\Models\Cultivate\CultivateCoursePrice;
use Common\Models\Cultivate\CultivateMajor;
use Common\Models\Cultivate\CultivateMajorLevel;
use Common\Models\Cultivate\CultivateTeacher;

class IndexAction extends BaseAction
{

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route(RouteConfig::ROUTE_COURSE_PRICE_LIST);
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new PriceSqlProcessor())->getListSql(new CultivateCoursePrice(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->with(['course'])->select(['id', 'type', 'title', 'sale_desc', 'course_no', 'no', 'train', 'identify', 'discount', 'money', 'real_money', 'active_status', 'used_status', 'created_at'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonTool::pagination($total, $pageSize, $page, $url);
        $courseList = CultivateCourse::select(['no', 'name'])->get();
        $majorList = CultivateMajor::select(['no', 'name'])->get();
        $levelList = CultivateMajorLevel::select(['no', 'name'])->get();
        $teacherList = CultivateTeacher::select(['no', 'name'])->get();
        list($operateList, $operateUrl) = $this->allowOperate();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'  =>  $this->initViewMenu(),
            'typeList'      => PriceConfig::getTypeList(),
            'courseList'    => $courseList,
            'majorList'     => $majorList,
            'levelList'     => $levelList,
            'teacherList'   => $teacherList,
            'operateList'   => $operateList,
            'operateUrl'    => $operateUrl,
            'redirectUrl'   => route(RouteConfig::ROUTE_COURSE_PRICE_LIST),
        ];
        return $this->createView(ViewConfig::COURSE_PRICE_LIST, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title' => AdminMenuConfig::MENU_CULTIVATE_CENTER, 'url' => 0, 'active' => 0],
            ['title' => AdminMenuConfig::MENU_CULTIVATE_COURSE_PRICE, 'url' => 0, 'active' => 0],
            ['title' => RouteConfig::ROUTE_COURSE_PRICE_LIST, 'url' => 0, 'active' => 1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function processList($list)
    {
        foreach ($list as $key => $item) {
            $list = $this->initStatus($list, $key);
            $list = $this->listAllowOperate($list, $key);
        }
        return $list;
    }

    protected function initStatus($list, $key)
    {
        $typeList = PriceConfig::getTypeList();
        $statusList = [
            'active_desc'   =>  '未激活',
            'used_desc'     =>  '未使用',
            'type_desc'     =>  '',
        ];
        $activeStatus = $list[$key]->active_status;
        $userdStatus = $list[$key]->used_status;
        $type = $list[$key]->type;
        if ($activeStatus == 1) {
            $statusList['active_desc'] = '已激活';
        }
        if ($userdStatus == 1) {
            $statusList['active_desc'] = '已使用';
        }
        if ($type > 0 && array_key_exists($type, $typeList)) {
            $statusList['type_desc'] = $typeList[$type];
        }
        $list[$key]->status_list = $statusList;
        return $list;
    }

    protected function allowOperate()
    {
        $operateList = [
            'allow_active' => 0,
        ];
        $operateUrl = [
            'active_url' => '',
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_COURSE_PRICE_ACTIVE)) {
            $operateList['allow_active'] = 1;
            $operateUrl['active_url'] = route(RouteConfig::ROUTE_COURSE_PRICE_ACTIVE);
        }
        return [$operateList, $operateUrl];
    }

    protected function listAllowOperate($list, $key)
    {
        $operateList = [
            'allow_active' => 0,
        ];
        $activeStatus = $list[$key]->active_status;
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_COURSE_PRICE_ACTIVE)) {
            if ($activeStatus == 0) {
                $operateList['allow_active'] = 1;
            }
        }
        $list[$key]->operate_list = $operateList;
        return $list;
    }
}