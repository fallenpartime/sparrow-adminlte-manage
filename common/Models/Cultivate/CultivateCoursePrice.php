<?php
/**
 * 培训课程定价表
 */
namespace Common\Models\Cultivate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CultivateCoursePrice extends Model
{
    use SoftDeletes;

    protected $table = 'cultivate_course_prices';
    protected $appends = ['edit_url', 'operate_list'];

    public function getEditUrlAttribute()
    {
        return array_get($this->attributes, 'edit_url', '');
    }

    public function getOperateListAttribute()
    {
        return array_get($this->attributes, 'operate_list', []);
    }

    public function level()
    {
        return $this->belongsTo(CultivateMajorLevel::class, 'level_no', 'no');
    }

    public function course()
    {
        return $this->belongsTo(CultivateCourse::class, 'course_no', 'no');
    }
}
