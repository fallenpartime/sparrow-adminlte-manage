<?php
/**
 * 文章图片
 * Date: 2018/12/9
 * Time: 18:30
 */

namespace Common\Models\Article;

use Common\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticlePicture extends BaseModel
{
    use SoftDeletes;

    protected $table = 'article_pictures';
    protected $appends = ['edit_url', 'operate_list'];

    public function getEditUrlAttribute()
    {
        return array_get($this->attributes, 'edit_url', '');
    }

    public function getOperateListAttribute()
    {
        return array_get($this->attributes, 'operate_list', []);
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}