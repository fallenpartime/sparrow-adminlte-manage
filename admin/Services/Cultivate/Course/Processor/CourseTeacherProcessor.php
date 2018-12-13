<?php
/**
 * 培训开班教师
 * Date: 2018/12/12
 * Time: 22:30
 */
namespace Admin\Services\Cultivate\Course\Processor;

use Common\Models\Cultivate\CultivateCourseTeacher;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class CourseTeacherProcessor extends BaseProcessor
{
    protected $tableName = 'cultivate_course_teachers';
    protected $tableClass = CultivateCourseTeacher::class;
}