<?php
/**
 * 机构
 * Date: 2018/12/10
 * Time: 22:17
 */
namespace Admin\Services\Cultivate\Major\Processor;

use Common\Models\Cultivate\CultivateMajor;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class MajorProcessor extends BaseProcessor
{
    protected $tableName = 'cultivate_majors';
    protected $tableClass = CultivateMajor::class;
}