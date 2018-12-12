<?php
/**
 * 专业课程列表
 * Date: 2018/12/12
 * Time: 13:09
 */
namespace Admin\Services\Sql\Cultivate\Major\Course;

use Frameworks\Services\Basic\Processor\BaseSqlDelegation;
use Frameworks\Services\Basic\Processor\BaseSqlProcessor;

class MajorCourseSqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
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
        // 类型
        $type = intval(trim(array_get($params, 'type')));
        if (!empty($type)) {
            $model = $model->where('type', $type);
            $urlParams['type'] = $type;
        }
        // 名称
        $name = trim(array_get($params, 'name'));
        if (!empty($name)) {
            $model = $model->where('name', $name);
            $urlParams['name'] = $name;
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