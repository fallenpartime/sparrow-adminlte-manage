<?php
/**
 * 课程申请
 * Date: 2018/12/9
 * Time: 18:01
 */
namespace Common\Models\Cultivate;

use Common\Models\BaseModel;
use Common\Models\User\User;
use Common\Models\User\UserApplyInfo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CultivateCourseApply extends BaseModel
{
    use SoftDeletes;

    protected $table = 'cultivate_course_applies';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(CultivateCourse::class, 'course_no', 'no');
    }

    public function applyInfo()
    {
        return $this->belongsTo(UserApplyInfo::class, 'info_id');
    }
}