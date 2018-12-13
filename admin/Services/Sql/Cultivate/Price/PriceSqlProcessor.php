<?php
/**
 * 报价列表
 * Date: 2018/12/14
 * Time: 0:54
 */
namespace Admin\Services\Sql\Cultivate\Price;

use Frameworks\Services\Basic\Processor\BaseSqlDelegation;
use Frameworks\Services\Basic\Processor\BaseSqlProcessor;

class PriceSqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
{
    public function getListSql($model, $params, $url, $options = [])
    {
        $urlParams = ['search'=>'search'];
        // 编号
        $no = trim(array_get($params, 'no'));
        if (!empty($no)) {
            $model = $model->where('no', $no);
            $urlParams['no'] = $no;
        }
        // 类别
        $type = intval(array_get($params, 'type'));
        if (!empty($type)) {
            $model = $model->where('type', $type);
            $urlParams['type'] = $type;
        }
        // 激活状态
        $activeStatus = intval(array_get($params, 'active_status'));
        if (!empty($activeStatus)) {
            $activeValue = $activeStatus - 1;
            $model = $model->where('active_status', $activeValue);
            $urlParams['active_status'] = $activeStatus;
        }
        // 使用状态
        $usedStatus = intval(array_get($params, 'used_status'));
        if (!empty($usedStatus)) {
            $userdValue = $usedStatus - 1;
            $model = $model->where('used_status', $userdValue);
            $urlParams['used_status'] = $usedStatus;
        }
        // 开课编号
        $courseNo = trim(array_get($params, 'course_no'));
        // 年份
        $year = intval(trim(array_get($params, 'year')));
        // 等级
        $levelNo = trim(array_get($params, 'level_no'));
        // 专业
        $majorNo = trim(array_get($params, 'major_no'));
        // 教师
        $teacherNo = trim(array_get($params, 'teacher_no'));
        $urlParams['course_no'] = $courseNo;
        $urlParams['year'] = $year;
        $urlParams['level_no'] = $levelNo;
        $urlParams['major_no'] = $majorNo;
        $urlParams['teacher_no'] = $teacherNo;
        $model = $model->whereHas('course', function ($query) use ($params) {
            if (!empty($params['course_no'])) {
                $query->where('course_no', $params['course_no']);
            }
            if (!empty($params['year'])) {
                $query->where('year', $params['year']);
            }
            if (!empty($params['level_no'])) {
                $query->where('level_no', $params['level_no']);
            }
            if (!empty($params['teacher_no'])) {
                $query->whereHas('teachers', function ($query) use ($params) {
                    $query->whereHas('teacher', function ($query) use ($params) {
                        $query->where('no', $params['teacher_no']);
                    });
                });
            }
            $query->whereHas('major', function ($query) use ($params) {
                if (!empty($params['major_no'])) {
                    $query->where('no', $params['major_no']);
                }
            });
        });
        $url .= '?'.implode('&', $urlParams);
        return [$model, $urlParams, $url];
    }
}