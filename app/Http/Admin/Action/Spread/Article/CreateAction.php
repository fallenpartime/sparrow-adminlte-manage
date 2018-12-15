<?php
/**
 * 创建文章
 * Date: 2018/12/10
 * Time: 9:31
 */
namespace App\Http\Admin\Action\Spread\Article;

use Admin\Action\BaseAction;
use Admin\Config\AdminMenuConfig;
use Admin\Config\RouteConfig;
use Admin\Config\ViewConfig;
use Admin\Services\Menu\AdminMenuService;
use Admin\Services\Spread\Article\Processor\ArticleProcessor;
use Common\Config\ArticleConfig;
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
        $result = [
            'menu'  =>  $this->initViewMenu(),
            'actionUrl'         => route(RouteConfig::ROUTE_SPREAD_ARTICLE_CREATE),
            'redirectUrl'       => route(RouteConfig::ROUTE_SPREAD_ARTICLE_LIST),
        ];
        return $this->createView(ViewConfig::SPREAD_ARTICLE_CREATE, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_SPREAD, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_SPREAD_ARTICLE, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_SPREAD_ARTICLE_LIST, 'url'=>1, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_SPREAD_ARTICLE_CREATE, 'url'=>0, 'active'=>1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $title = $httpTool->getBothSafeParam('title');
        $author = $httpTool->getBothSafeParam('author');
        $description = $httpTool->getBothSafeParam('description');
        $content = trim($_REQUEST['content']);
        $content = !empty($content)? $content: '';
        $picPreview = $this->request->get('list_pic_preview');
        if(empty($title)){
            $this->errorJson(500, '标题不能为空');
        }
        if(empty($author)){
            $this->errorJson(500, '作者不能为空');
        }
        if(empty($description)){
            $this->errorJson(500, '简介不能为空');
        }
        if(empty($content)){
            $this->errorJson(500, '内容不能为空');
        }
        $data = [
            'type'          =>  ArticleConfig::NEWS_TYPE,
            'title'         =>  $title,
            'author'        =>  $author,
            'description'   =>  $description,
            'content'       =>  $content,
            'list_pic'      =>  !empty($picPreview)?  $picPreview[0]: null,
        ];
        $res = $this->save($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function save($data)
    {
        $processor = new ArticleProcessor();
        list($status, $model) = $processor->insert($data);
        if (empty($status)) {
            $this->errorJson(500, '文章创建失败');
        }
        $this->getLogTool()->operateLog(80, $model->id, '添加推广文章');
        $this->successJson();
    }
}