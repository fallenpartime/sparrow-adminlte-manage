<?php
/**
 * 用户信息表
 * Date: 2018/12/9
 * Time: 18:09
 */
namespace Common\Models\User;

use Common\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends BaseModel
{
    use SoftDeletes;

    protected $table = 'users';
}