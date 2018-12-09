<?php
/**
 * 培训机构
 */
namespace Common\Models\Cultivate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CultivateAgency extends Model
{
    use SoftDeletes;

    protected $table = 'cultivate_agencies';
}
