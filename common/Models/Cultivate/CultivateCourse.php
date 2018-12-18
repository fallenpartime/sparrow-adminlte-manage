<?php
/**
 * 培训生成的课程
 */
namespace Common\Models\Cultivate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CultivateCourse extends Model
{
    use SoftDeletes;

    protected $table = 'cultivate_courses';
    protected $appends = ['edit_url', 'operate_list'];

    public function major()
    {
        return $this->belongsTo(CultivateMajor::class, 'major_no', 'no');
    }

    public function level()
    {
        return $this->belongsTo(CultivateMajorLevel::class, 'level_no', 'no');
    }

    public function currentPrice()
    {
        return $this->belongsTo(CultivateCoursePrice::class, 'price_no', 'no');
//        return $this->hasOne(CultivateCoursePrice::class, 'no', 'price_no');
    }


    public function prices()
    {
        return $this->hasMany(CultivateCoursePrice::class, 'course_no', 'no');
    }

    public function teachers()
    {
        return $this->hasMany(CultivateCourseTeacher::class, 'course_no', 'no');
    }

    public function getEditUrlAttribute()
    {
        return array_get($this->attributes, 'edit_url', '');
    }

    public function getOperateListAttribute()
    {
        return array_get($this->attributes, 'operate_list', []);
    }
}
