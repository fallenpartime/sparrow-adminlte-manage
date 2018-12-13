<?php
/**
 * 培训机构关联授课人员
 */
namespace Common\Models\Cultivate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CultivateCourseTeacher extends Model
{
    use SoftDeletes;

    protected $table = 'cultivate_course_teachers';
    protected $appends = ['edit_url', 'operate_list'];

    public function getEditUrlAttribute()
    {
        return array_get($this->attributes, 'edit_url', '');
    }

    public function getOperateListAttribute()
    {
        return array_get($this->attributes, 'operate_list', []);
    }

    public function course()
    {
        return $this->belongsTo(CultivateCourse::class, 'course_no', 'no');
    }

    public function teacher()
    {
        return $this->belongsTo(CultivateTeacher::class, 'teacher_no', 'no');
    }

}
