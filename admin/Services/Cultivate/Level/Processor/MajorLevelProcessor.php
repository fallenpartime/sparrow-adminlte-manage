<?php
/**
 * 机构
 * Date: 2018/12/10
 * Time: 22:17
 */
namespace Admin\Services\Cultivate\Level\Processor;

use Common\Models\Cultivate\CultivateMajorLevel;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class MajorLevelProcessor extends BaseProcessor
{
    protected $tableName = 'cultivate_major_levels';
    protected $tableClass = CultivateMajorLevel::class;
}