<?php
/**
 * 机构
 * Date: 2018/12/10
 * Time: 22:17
 */
namespace Admin\Services\School\Agency\Processor;

use Common\Models\Cultivate\CultivateAgency;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class AgencyProcessor extends BaseProcessor
{
    protected $tableName = 'cultivate_agencies';
    protected $tableClass = CultivateAgency::class;
}