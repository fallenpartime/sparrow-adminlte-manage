<?php
/**
 * 机构图片
 * Date: 2018/12/10
 * Time: 22:18
 */
namespace Admin\Services\School\Agency\Processor;

use Common\Models\Cultivate\CultivateAgencyPicture;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class AgencyPictureProcessor extends BaseProcessor
{
    protected $tableName = 'cultivate_agency_pictures';
    protected $tableClass = CultivateAgencyPicture::class;
}