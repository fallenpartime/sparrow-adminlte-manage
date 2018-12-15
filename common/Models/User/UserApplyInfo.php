<?php
/**
 * 用户申请报名信息
 * Date: 2018/12/9
 * Time: 18:35
 */
namespace Common\Models\User;

use Common\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserApplyInfo extends BaseModel
{
    use SoftDeletes;

    protected $table = 'user_apply_infos';
}