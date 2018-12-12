<?php
/**
 * 培训开班
 * Date: 2018/12/12
 * Time: 22:30
 */
namespace Admin\Services\Cultivate\Course\Processor;

use Common\Models\Cultivate\CultivateCourse;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class CourseProcessor extends BaseProcessor
{
    protected $tableName = 'cultivate_courses';
    protected $tableClass = CultivateCourse::class;
}