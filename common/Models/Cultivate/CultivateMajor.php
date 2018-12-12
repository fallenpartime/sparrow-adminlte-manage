<?php
/**
 * 培训专业
 */
namespace Common\Models\Cultivate;

use Illuminate\Database\Eloquent\Model;

class CultivateMajor extends Model
{
    protected $table = 'cultivate_majors';
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
