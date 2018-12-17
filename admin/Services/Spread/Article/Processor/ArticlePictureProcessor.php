<?php
/**
 * 文章图片
 * Date: 2018/12/15
 * Time: 16:11
 */
namespace Admin\Services\Spread\Article\Processor;

use Common\Models\Article\ArticlePicture;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class ArticlePictureProcessor extends BaseProcessor
{
    protected $tableName = 'article_pictures';
    protected $tableClass = ArticlePicture::class;
}