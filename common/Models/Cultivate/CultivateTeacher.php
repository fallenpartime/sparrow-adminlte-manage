<?php
/**
 * 培训授课人员
 */
namespace Common\Models\Cultivate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CultivateTeacher extends Model
{
    use SoftDeletes;

    protected $table = 'cultivate_teachers';
}
