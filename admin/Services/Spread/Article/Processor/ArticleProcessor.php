<?php
/**
 * 文章
 * Date: 2018/12/15
 * Time: 16:11
 */
namespace Admin\Services\Spread\Article\Processor;

use Common\Models\Article\Article;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class ArticleProcessor extends BaseProcessor
{
    protected $tableName = 'articles';
    protected $tableClass = Article::class;
}