<?php
/**
 * 文章发布
 * Date: 2018/12/10
 * Time: 9:31
 */
namespace App\Http\Admin\Action\Spread\Article;

use Admin\Action\BaseAction;
use Admin\Services\Spread\Article\Processor\ArticleProcessor;
use Carbon\Carbon;
use Common\Models\Article\Article;
use Frameworks\Tool\Http\Config\HttpConfig;
use Frameworks\Traits\ApiActionTrait;

class PublishAction extends BaseAction
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
        $publishedAt = $this->record->published_at;
        $processor = new ArticleProcessor();
        if (!empty($publishedAt)) {
            $this->unPublish($processor);
        } else {
            $this->publish($processor);
        }
    }

    protected function publish($processor)
    {
        $showStatus = $this->record->is_show;
        if (empty($showStatus)) {
            $this->errorJson(500, '隐藏状态不可发布');
        }
        $tsNow = Carbon::now()->format('Y-m-d H:i;s');
        list($status, $updateId) = $processor->update($this->record->id, ['published_at'=>$tsNow]);
        if ($status) {
            $this->getLogTool()->operateLog(83, $this->record->id, "发布推广文章");
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function unPublish($processor)
    {
        list($status, $updateId) = $processor->update($this->record->id, ['published_at'=>null]);
        if ($status) {
            $this->getLogTool()->operateLog(83, $this->record->id, "撤销发布推广文章");
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}