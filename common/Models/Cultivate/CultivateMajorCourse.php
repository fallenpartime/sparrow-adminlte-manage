<?php
/**
 * 培训专业课程
 */
namespace Common\Models\Cultivate;

use Illuminate\Database\Eloquent\Model;

class CultivateMajorCourse extends Model
{
    protected $table = 'cultivate_major_courses';
    protected $appends = ['edit_url', 'operate_list'];

    public function getEditUrlAttribute()
    {
        return array_get($this->attributes, 'edit_url', '');
    }

    public function getOperateListAttribute()
    {
        return array_get($this->attributes, 'operate_list', []);
    }

    public function major()
    {
        return $this->belongsTo(CultivateMajor::class, 'major_no', 'no');
    }
}
