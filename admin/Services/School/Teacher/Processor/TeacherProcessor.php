<?php
/**
 * 教师
 * Date: 2018/12/10
 * Time: 23:39
 */
namespace Admin\Services\School\Teacher\Processor;

use Common\Models\Cultivate\CultivateTeacher;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class TeacherProcessor extends BaseProcessor
{
    protected $tableName = 'cultivate_teachers';
    protected $tableClass = CultivateTeacher::class;
}