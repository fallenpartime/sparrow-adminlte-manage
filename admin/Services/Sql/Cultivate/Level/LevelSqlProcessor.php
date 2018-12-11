<?php
/**
 * 培训等级列表
 * Date: 2018/12/11
 * Time: 22:16
 */
namespace Admin\Services\Sql\Cultivate\Level;

use Frameworks\Services\Basic\Processor\BaseSqlDelegation;
use Frameworks\Services\Basic\Processor\BaseSqlProcessor;

class LevelSqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
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