<?php
/**
 * 菜单管理
 * Date: 2018/10/3
 * Time: 20:56
 */
namespace Admin\Services\Menu;

use Admin\Config\AdminMenuConfig;

class AdminMenuService
{
    /**
     * 生成模板小导航栏数组
     * @param $params
     * @return array
     */
    public static function initViewMenu($params)
    {
        $menus = [];
        if (empty($params)) {
            return $menus;
        }
        array_walk($params, function ($param) use (&$menus) {
            $title = trim($param['title']);
            $isUrl = intval($param['url']);
            $active = intval($param['active']);
            $url = '';
            if ($isUrl) {
                $url = route($title);
            }
            $action = $title;
            $title = AdminMenuConfig::getMenuName($title);
            $menus[$action] = compact("title", "url", "active");
        });
        return $menus;
    }
}