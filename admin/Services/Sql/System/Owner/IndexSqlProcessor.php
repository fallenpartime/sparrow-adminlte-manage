<?php
/**
 * 管理员列表
 * Date: 2018/12/3
 * Time: 15:19
 */
namespace Admin\Services\Sql\System\Owner;

use Frameworks\Services\Basic\Processor\BaseSqlDelegation;
use Frameworks\Services\Basic\Processor\BaseSqlProcessor;

class IndexSqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
{
    public function getListSql($model, $params, $url, $options = [])
    {
        $urlParams = ['search'=>'search'];
        $isOwner = intval(array_get($params, 'is_owner'));
        if ($isOwner > 0) {
            $ownerValue = $isOwner - 1;
            $model = $model->where('is_owner', $ownerValue);
            $urlParams['is_owner'] = $isOwner;
        }
        $name = array_get($params, 'name');
        $phone = array_get($params, 'phone');
        $search = [];
        if (!empty($name)) {
            $search['name'] = $name;
            $urlParams['name'] = $name;
        }
        if (!empty($phone)) {
            $search['phone'] = $phone;
            $urlParams['phone'] = $phone;
        }
        if (!empty($search)) {
            $model = $model->whereHas('user', function($query) use ($search) {
                if (!empty($search['name'])) {
                    $query->where('name', $search['name']);
                }
                if (!empty($search['phone'])) {
                    $query->where('phone', $search['phone']);
                }
            });
        }
        return [$model, $urlParams];
    }
}