<?php
/**
 * 开班列表
 * Date: 2018/12/12
 * Time: 22:29
 */
namespace Admin\Services\Sql\Cultivate\Course\Teacher;

use Frameworks\Services\Basic\Processor\BaseSqlDelegation;
use Frameworks\Services\Basic\Processor\BaseSqlProcessor;

class CourseTeacherSqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
{
    public function getListSql($model, $params, $url, $options = [])
    {
        $urlParams = ['search'=>'search'];
        // 开班编号
        $courseNo = trim(array_get($params, 'course_no'));
        if (!empty($courseNo)) {
            $model = $model->where('course_no', $courseNo);
            $urlParams['course_no'] = $courseNo;
        }
        // 年份
        $year = intval(trim(array_get($params, 'year')));
        // 等级
        $levelNo = trim(array_get($params, 'level_no'));
        // 专业
        $majorNo = trim(array_get($params, 'major_no'));
        $urlParams['year'] = $year;
        $urlParams['level_no'] = $levelNo;
        $urlParams['major_no'] = $majorNo;
        $model = $model->whereHas('course', function ($query) use ($params) {
            if (!empty($search['year'])) {
                $query->where('year', $search['year']);
            }
            if (!empty($search['level_no'])) {
                $query->where('level_no', $search['level_no']);
            }
            if (!empty($search['major_no'])) {
                $query->where('major_no', $search['major_no']);
            }
        });
        // 教师
        $teacherNo = trim(array_get($params, 'teacher_no'));
        if (!empty($teacherNo)) {
            $model = $model->where('teacher_no', $teacherNo);
            $urlParams['teacher_no'] = $teacherNo;
        }
        $url .= '?'.implode('&', $urlParams);
        return [$model, $urlParams, $url];
    }
}