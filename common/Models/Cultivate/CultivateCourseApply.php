<?php
/**
 * 课程申请
 * Date: 2018/12/9
 * Time: 18:01
 */
namespace Common\Models\Cultivate;

use Common\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class CultivateCourseApply extends BaseModel
{
    use SoftDeletes;

    protected $table = 'cultivate_course_applies';
}