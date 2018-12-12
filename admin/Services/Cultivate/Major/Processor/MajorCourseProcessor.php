<?php
/**
 * 专业课程
 * Date: 2018/12/12
 * Time: 13:07
 */
namespace Admin\Services\Cultivate\Major\Processor;

use Common\Models\Cultivate\CultivateMajorCourse;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class MajorCourseProcessor extends BaseProcessor
{
    protected $tableName = 'cultivate_major_courses';
    protected $tableClass = CultivateMajorCourse::class;
}