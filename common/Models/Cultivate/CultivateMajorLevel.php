<?php
/**
 * 培训专业等级
 */
namespace Common\Models\Cultivate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CultivateMajorLevel extends Model
{
    use SoftDeletes;

    protected $table = 'cultivate_major_levels';
    protected $appends = ['edit_url', 'operate_list'];

    public function getEditUrlAttribute()
    {
        return array_get($this->attributes, 'edit_url', '');
    }

    public function getOperateListAttribute()
    {
        return array_get($this->attributes, 'operate_list', []);
    }
}
