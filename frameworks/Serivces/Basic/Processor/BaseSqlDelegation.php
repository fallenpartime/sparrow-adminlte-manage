<?php
/**
 *
 * Date: 2018/10/7
 * Time: 20:06
 */
namespace Frameworks\Services\Basic\Processor;

interface BaseSqlDelegation
{
    public function getListSql($model, $params, $url, $options = []);
}