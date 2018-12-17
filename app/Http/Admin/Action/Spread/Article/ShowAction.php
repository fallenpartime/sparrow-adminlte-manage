<?php
/**
 * 修改文章显示状态
 * Date: 2018/12/10
 * Time: 9:31
 */
namespace App\Http\Admin\Action\Spread\Article;

use Admin\Action\BaseAction;
use Admin\Services\Spread\Article\Processor\ArticleProcessor;
use Common\Models\Article\Article;
use Frameworks\Tool\Http\Config\HttpConfig;
use Frameworks\Traits\ApiActionTrait;

class ShowAction extends BaseAction
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
        $oldShowStatus = $this->record->is_show;
        $toShowStatus = ($oldShowStatus + 1) % 2;
        $processor = new ArticleProcessor();
        list($status, $updateId) = $processor->update($this->record->id, ['is_show'=>$toShowStatus]);
        if ($status) {
            $this->getLogTool()->operateLog(83, $this->record->id, "推广文章显示状态修改,{$oldShowStatus}=>{$toShowStatus}");
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}