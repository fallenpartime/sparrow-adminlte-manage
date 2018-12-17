<?php
/**
 * 编辑文章
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
use Common\Models\Article\Article;
use Frameworks\Tool\Http\Config\HttpConfig;
use Frameworks\Traits\ApiActionTrait;

class EditAction extends BaseAction
{
    use ApiActionTrait;

    protected $record = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->record = Article::find($id);
        }
        if ($httpTool->isAjax()) {
            $this->process();
        }
        return $this->showInfo();
    }

    protected function showInfo()
    {
        if (empty($this->record)) {
            $this->redirect('文章不存在');
        }
        $result = [
            'record'    =>  $this->record,
            'menu'      =>  $this->initViewMenu(),
            'actionUrl'         => route(RouteConfig::ROUTE_SPREAD_ARTICLE_EDIT),
            'redirectUrl'       => route(RouteConfig::ROUTE_SPREAD_ARTICLE_LIST),
        ];
        return $this->createView(ViewConfig::SPREAD_ARTICLE_EDIT, $result);
    }

    protected function initViewMenu()
    {
        $menuParams = [
            ['title'=>AdminMenuConfig::MENU_SPREAD, 'url'=>0, 'active'=>0],
            ['title'=>AdminMenuConfig::MENU_SPREAD_ARTICLE, 'url'=>0, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_SPREAD_ARTICLE_LIST, 'url'=>1, 'active'=>0],
            ['title'=>RouteConfig::ROUTE_SPREAD_ARTICLE_EDIT, 'url'=>0, 'active'=>1],
        ];
        return AdminMenuService::initViewMenu($menuParams);
    }

    protected function process()
    {
        if (empty($this->record)) {
            $this->errorJson(500, '文章不存在');
        }
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
        $res = $this->update($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function update($data)
    {
        $this->getLogTool()->operateLog(81, $this->record->id, '添加推广文章');
        $processor = new ArticleProcessor();
        list($status, $updateId) = $processor->update($this->record->id, $data);
        if (empty($status)) {
            $this->errorJson(500, '文章编辑失败');
        }
        $this->successJson();
    }
}