<?php
/**
 * 培训开班
 * Date: 2018/12/12
 * Time: 22:30
 */
namespace Admin\Services\Cultivate\Price\Processor;

use Common\Models\Cultivate\CultivateCoursePrice;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class CoursePriceProcessor extends BaseProcessor
{
    protected $tableName = 'cultivate_course_prices';
    protected $tableClass = CultivateCoursePrice::class;
}