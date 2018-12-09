<?php
/**
 * 机构图片
 * Date: 2018/12/9
 * Time: 20:13
 */
namespace Common\Models\Cultivate;

use Common\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class CultivateAgencyPicture extends BaseModel
{
    use SoftDeletes;

    protected $table = 'cultivate_agency_pictures';
}