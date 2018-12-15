<?php
/**
 * 文章管理中心
 * Date: 2018/12/9
 * Time: 17:43
 */
namespace App\Http\Admin\Action\Spread\Article;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Menu\AdminMenuService;
use Admin\Services\Sql\Spread\Article\ArticleSqlProcessor;
use Admin\Tool\CommonTool;
use Common\Models\Article\Article;

class IndexAction extends BaseAction
{

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route(RouteConfig::ROUTE_SPREAD_ARTICLE_LIST);
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new ArticleSqlProcessor())->getListSql(new Article(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->select(['id', 'title', 'author', 'is_show', 'list_pic', 'read_count', 'like_count', 'created_at', 'published_at'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonTool::pagination($total, $pageSize, $page, $url);
        list($operateList, $operateUrl) = $this->allowOperate();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'  =>  $this->initViewMenu(),
            'operateList'   => $operateList,
            'operateUrl'    => $operateUrl,
            'redirectUrl'   => route(RouteConfig::ROUTE_SPREAD_ARTICLE_LIST),
        ];
        return $this->createView(ViewConfig::SPREAD_ARTICLE_LIST, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title' => AdminMenuConfig::MENU_SPREAD, 'url' => 0, 'active' => 0],
            ['title' => AdminMenuConfig::MENU_SPREAD_ARTICLE, 'url' => 0, 'active' => 0],
            ['title' => RouteConfig::ROUTE_SPREAD_ARTICLE_LIST, 'url' => 0, 'active' => 1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function processList($list)
    {
        foreach ($list as $key => $item) {
            $list[$key]->edit_url = route(RouteConfig::ROUTE_SPREAD_ARTICLE_EDIT, ['id'=>$item->id]);
            $list = $this->initStatusList($list, $key);
            $list = $this->listAllowOperate($list, $key);
        }
        return $list;
    }

    protected function initStatusList($list, $key)
    {
        $statusList = ['show_status'=>''];
        $article = $list[$key];
        $isShow = $article->is_show;
        if ($isShow) {
            $statusList['show_status'] = '显示';
        } else {
            $statusList['show_status'] = '隐藏';
        }
        $list[$key]['status_list'] = $statusList;
        return $list;
    }

    protected function allowOperate()
    {
        $operateList = [
            'allow_remove' => 0,
        ];
        $operateUrl = [
            'remove_url' => '',
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_SPREAD_ARTICLE_REMOVE)) {
            $operateList['allow_remove'] = 1;
            $operateUrl['remove_url'] = route(RouteConfig::ROUTE_SPREAD_ARTICLE_REMOVE);
        }
        return [$operateList, $operateUrl];
    }

    protected function listAllowOperate($list, $key)
    {
        $operateList = [
            'allow_operate_edit' => 0,
            'allow_operate_remove' => 0,
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_SPREAD_ARTICLE_EDIT)) {
            $operateList['allow_operate_edit'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction(RouteConfig::ROUTE_SPREAD_ARTICLE_REMOVE)) {
            $operateList['allow_operate_remove'] = 1;
        }
        $list[$key]->operate_list = $operateList;
        return $list;
    }
}