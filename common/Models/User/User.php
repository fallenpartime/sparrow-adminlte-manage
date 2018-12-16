<?php
/**
 * 用户信息表
 * Date: 2018/12/9
 * Time: 18:09
 */
namespace Common\Models\User;

use Common\Models\BaseModel;
use Common\Models\Cultivate\CultivateCourseApply;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends BaseModel
{
    use SoftDeletes;

    protected $table = 'users';
    protected $appends = ['operate_list', 'status_list'];

    public function getOperateListAttribute()
    {
        return array_get($this->attributes, 'operate_list', []);
    }

    public function getStatusListAttribute()
    {
        return array_get($this->attributes, 'status_list', []);
    }

    public function info()
    {
        return $this->hasOne(UserInfo::class);
    }

    public function courseApplies()
    {
        return $this->hasMany(CultivateCourseApply::class);
    }

    public function applyInfos()
    {
        return $this->hasMany(UserApplyInfo::class);
    }
}