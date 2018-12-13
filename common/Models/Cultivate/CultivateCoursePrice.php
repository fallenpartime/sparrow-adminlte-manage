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
    protected $appends = ['operate_list', 'status_list'];

    public function getOperateListAttribute()
    {
        return array_get($this->attributes, 'operate_list', []);
    }

    public function getStatusListAttribute()
    {
        return array_get($this->attributes, 'status_list', []);
    }

    public function course()
    {
        return $this->belongsTo(CultivateCourse::class, 'course_no', 'no');
    }
}
