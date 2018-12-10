<?php
/**
 * Created by PhpStorm.
 * User: Fallen
 * Date: 2018/12/10
 * Time: 23:45
 */

namespace Admin\Services\Sql\School\Teacher;


use Frameworks\Services\Basic\Processor\BaseSqlDelegation;
use Frameworks\Services\Basic\Processor\BaseSqlProcessor;

class TeacherSqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
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
        // 姓名
        $name = trim(array_get($params, 'name'));
        if (!empty($name)) {
            $model = $model->where('name', $name);
            $urlParams['name'] = $name;
        }
        // 联系方式
        $phone = trim(array_get($params, 'phone'));
        if (!empty($phone)) {
            $model = $model->where('phone', $phone);
            $urlParams['phone'] = $phone;
        }
        $url .= '?'.implode('&', $urlParams);
        return [$model, $urlParams, $url];
    }
}