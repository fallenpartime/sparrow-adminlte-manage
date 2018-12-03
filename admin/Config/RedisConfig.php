<?php
/**
 * 后台redis配置
 * Date: 2018/12/3
 * Time: 11:51
 */
namespace Admin\Config;

use Common\Config\RedisConfig as CommonRedisConfig;

class RedisConfig
{
    const ADMIN_TOKEN = CommonRedisConfig::REDIS_PREFIX.'admin:login:';
    const ADMIN_TOKEN_SITE = CommonRedisConfig::REDIS_PREFIX.'_admin';
}