<?php
/**
 * 作废文章
 * Date: 2018/12/10
 * Time: 9:31
 */
namespace App\Http\Admin\Action\Spread\Article;

use Admin\Action\BaseAction;
use Admin\Services\Spread\Article\Processor\ArticleProcessor;
use Common\Models\Article\Article;
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
            $this->record = Article::find($id);
        }
        if (empty($this->record)) {
            $this->errorJson(500, '文章不存在');
        }
        $this->process();
    }

    protected function process()
    {
        $this->getLogTool()->operateLog(82, $this->record->id, '作废文章');
        $res = (new ArticleProcessor())->destroy($this->record->id);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}