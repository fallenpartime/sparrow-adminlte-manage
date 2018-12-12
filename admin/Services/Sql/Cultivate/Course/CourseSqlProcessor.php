<?php
/**
 * 开班列表
 * Date: 2018/12/12
 * Time: 22:29
 */
namespace Admin\Services\Sql\Cultivate\Course;

use Frameworks\Services\Basic\Processor\BaseSqlDelegation;
use Frameworks\Services\Basic\Processor\BaseSqlProcessor;

class CourseSqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
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
        // 年份
        $year = intval(trim(array_get($params, 'year')));
        if (!empty($year)) {
            $model = $model->where('year', $year);
            $urlParams['year'] = $year;
        }
        // 等级
        $levelNo = trim(array_get($params, 'level_no'));
        if (!empty($levelNo)) {
            $model = $model->where('level_no', $levelNo);
            $urlParams['level_no'] = $levelNo;
        }
        // 专业
        $majorNo = trim(array_get($params, 'major_no'));
        if (!empty($majorNo)) {
            $model = $model->where('major_no', $majorNo);
            $urlParams['major_no'] = $majorNo;
        }
        $url .= '?'.implode('&', $urlParams);
        return [$model, $urlParams, $url];
    }
}