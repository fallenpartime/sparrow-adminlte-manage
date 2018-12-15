<?php
/**
 * 文章表
 * Date: 2018/12/9
 * Time: 18:29
 */

namespace Common\Models\Article;

use Common\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends BaseModel
{
    use SoftDeletes;

    protected $table = 'articles';
    protected $appends = ['edit_url', 'operate_list', 'status_list'];

    public function getEditUrlAttribute()
    {
        return array_get($this->attributes, 'edit_url', '');
    }

    public function getOperateListAttribute()
    {
        return array_get($this->attributes, 'operate_list', []);
    }

    public function getStatusListAttribute()
    {
        return array_get($this->attributes, 'status_list', []);
    }

    public function pictures()
    {
        return $this->hasMany(ArticlePicture::class, 'article_id');
    }
}