<?php
/**
 * 机构查询
 * Date: 2018/12/10
 * Time: 21:00
 */

namespace Admin\Services\Sql\School\Agency;

use Frameworks\Services\Basic\Processor\BaseSqlDelegation;
use Frameworks\Services\Basic\Processor\BaseSqlProcessor;

class AgencySqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
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
        $url .= '?'.implode('&', $urlParams);
        return [$model, $urlParams, $url];
    }
}